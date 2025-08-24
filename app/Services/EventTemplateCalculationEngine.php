<?php

namespace App\Services;

use App\Models\EventTemplate;
use App\Models\EventTemplateQty;
use App\Models\EventTemplatePricePerPerson;
use App\Models\Currency;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class EventTemplateCalculationEngine
{
    /**
     * Zwraca szczegółowe obliczenia keyed by qty
     * @return array
     */
    public function calculateDetailed(EventTemplate $template, ?int $startPlaceId = null, ?float $transportKm = null, bool $debug = false): array
    {
        $programPoints = $template->programPoints()
            ->with(['currency', 'children.currency'])
            ->wherePivot('include_in_calculation', true)
            ->get();

        // try to get variants that belong to this template
        try {
            $qtyVariants = $template->qtyVariants()->get();
        } catch (\Illuminate\Database\QueryException $e) {
            // some environments don't have event_template_id column on event_template_qties
            // fallback: try to collect event_template_qty_id values from existing price rows for this template
            $qtyIds = DB::table('event_template_price_per_person')
                ->where('event_template_id', $template->id)
                ->distinct()
                ->pluck('event_template_qty_id')
                ->filter()
                ->values()
                ->all();

            if (!empty($qtyIds)) {
                $qtyVariants = EventTemplateQty::whereIn('id', $qtyIds)->get();
            } else {
                // last resort: match by common qty numbers
                $common = [20,25,30,35,40];
                $qtyVariants = EventTemplateQty::whereIn('qty', $common)->get();
                if ($qtyVariants->isEmpty()) {
                    // fallback to all
                    $qtyVariants = EventTemplateQty::all();
                }
            }
        }

        $bus = $template->bus;
        $programKm = $template->program_km ?? 0;
        $templateStartId = $template->start_place_id;
        $templateEndId = $template->end_place_id;

        // distances
        $d1 = 0;
        $d2 = 0;
        if ($startPlaceId && $templateStartId) {
            $d1 = \App\Models\PlaceDistance::where('from_place_id', $startPlaceId)
                ->where('to_place_id', $templateStartId)
                ->first()?->distance_km ?? 0;
        }
        if ($templateEndId && $startPlaceId) {
            $d2 = \App\Models\PlaceDistance::where('from_place_id', $templateEndId)
                ->where('to_place_id', $startPlaceId)
                ->first()?->distance_km ?? 0;
        }

        $basicDistance = $d1 + $d2 + $programKm;
        if ($transportKm !== null) {
            $totalKm = $transportKm;
        } else {
            $totalKm = 1.1 * $basicDistance + 50;
        }

        $results = [];

        foreach ($qtyVariants as $qtyVariant) {
            $variantId = $qtyVariant->id;
            $qty = $qtyVariant->qty;
            $gratis = $qtyVariant->gratis ?? 0;
            $staff = $qtyVariant->staff ?? 0;
            $driver = $qtyVariant->driver ?? 0;
            $qtyTotal = $qty + $gratis + $staff + $driver;

            $plnTotal = 0;
            $plnPoints = [];
            $currenciesTotals = [];
            $currenciesPoints = [];
            $hotelStructure = [];
            $busTransportCostTotal = null;

            // points
            foreach ($programPoints as $point) {
                if (!$point->currency) continue;
                $currencyCode = $point->currency->symbol;
                $exchangeRate = $point->currency->exchange_rate ?? 1;
                $groupSize = $point->group_size ?? 1;
                $unitPrice = $point->unit_price ?? 0;

                $cost = $this->calculatePointCost($qty, $groupSize, $unitPrice);
                $convertToPln = $point->convert_to_pln ?? false;

                if ($currencyCode === 'PLN') {
                    $plnPoints[] = ['name' => $point->name, 'cost' => $cost];
                    $plnTotal += $cost;
                } elseif ($convertToPln) {
                    $plnPoints[] = ['name' => $point->name . ' (przeliczone)', 'cost' => $cost * $exchangeRate];
                    $plnTotal += $cost * $exchangeRate;
                } else {
                    $currenciesPoints[$currencyCode][] = ['name' => $point->name, 'cost' => $cost];
                    $currenciesTotals[$currencyCode] = ($currenciesTotals[$currencyCode] ?? 0) + $cost;
                }

                foreach ($point->children as $child) {
                    if (!$child->currency) continue;
                    $childCurrencyCode = $child->currency->symbol;
                    $childExchangeRate = $child->currency->exchange_rate ?? 1;
                    $childGroupSize = $child->group_size ?? 1;
                    $childUnitPrice = $child->unit_price ?? 0;
                    $childCost = $this->calculatePointCost($qty, $childGroupSize, $childUnitPrice);
                    $childConvertToPln = $child->convert_to_pln ?? false;

                    if ($childCurrencyCode === 'PLN') {
                        $plnPoints[] = ['name' => '→ ' . $child->name, 'cost' => $childCost];
                        $plnTotal += $childCost;
                    } elseif ($childConvertToPln) {
                        $plnPoints[] = ['name' => '→ ' . $child->name . ' (przeliczone)', 'cost' => $childCost * $childExchangeRate];
                        $plnTotal += $childCost * $childExchangeRate;
                    } else {
                        $currenciesPoints[$childCurrencyCode][] = ['name' => '→ ' . $child->name, 'cost' => $childCost];
                        $currenciesTotals[$childCurrencyCode] = ($currenciesTotals[$childCurrencyCode] ?? 0) + $childCost;
                    }
                }
            }

            // insurance
            $insuranceTotal = 0;
            $dayInsurances = $template->dayInsurances ?? collect();
            foreach ($dayInsurances as $dayInsurance) {
                $insurance = $dayInsurance->insurance;
                if ($insurance && $insurance->insurance_enabled) {
                    if ($insurance->insurance_per_day) {
                        $insuranceTotal += $insurance->price_per_person * 1;
                    }
                    if ($insurance->insurance_per_person) {
                        $insuranceTotal += $insurance->price_per_person * max(0, $qty - ($qtyVariant->gratis ?? 0));
                    }
                }
            }
            if ($insuranceTotal > 0) {
                $plnPoints[] = ['name' => 'Ubezpieczenie', 'cost' => $insuranceTotal];
                $plnTotal += $insuranceTotal;
            }

            // --- NOCLEGI: odtwórz algorytm z widgeta (DP - minimalny koszt kombinacji pokoi)
            $hotelDays = $template->hotelDays()->get();
            foreach ($hotelDays as $hotelDay) {
                $roomGroups = [
                    'qty' => [
                        'count' => $qty,
                        'room_ids' => $hotelDay->hotel_room_ids_qty ?? [],
                    ],
                    'gratis' => [
                        'count' => $qtyVariant->gratis ?? 0,
                        'room_ids' => $hotelDay->hotel_room_ids_gratis ?? [],
                    ],
                    'staff' => [
                        'count' => $qtyVariant->staff ?? 0,
                        'room_ids' => $hotelDay->hotel_room_ids_staff ?? [],
                    ],
                    'driver' => [
                        'count' => $qtyVariant->driver ?? 0,
                        'room_ids' => $hotelDay->hotel_room_ids_driver ?? [],
                    ],
                ];
                $dayTotal = [];
                $roomAlloc = [];
                foreach ($roomGroups as $groupType => $groupData) {
                    $peopleCount = $groupData['count'];
                    $roomIds = $groupData['room_ids'];
                    if ($peopleCount <= 0) continue;
                    if (empty($roomIds)) {
                        $roomAlloc[] = [
                            'room' => null,
                            'alloc' => null,
                            'total_people' => $peopleCount,
                            'cost' => 0,
                            'currency' => null,
                            'group_type' => $groupType,
                            'room_count' => 0,
                            'warning' => 'Brak przypisanych pokoi dla tej grupy (' . $groupType . ') w noclegu.'
                        ];
                        continue;
                    }
                    $rooms = \App\Models\HotelRoom::whereIn('id', $roomIds)->get();

                    $roomTypeCount = [];
                    foreach ($rooms as $room) {
                        $roomTypeCount[$room->id] = 0;
                    }

                    $maxPeople = $peopleCount;
                    $maxCapacity = $rooms->sum('people_count') * ($peopleCount);
                    $dp = array_fill(0, $maxCapacity + 1, INF);
                    $dp[0] = 0;
                    $choice = array_fill(0, $maxCapacity + 1, null);

                    foreach ($rooms as $room) {
                        for ($i = $room->people_count; $i <= $maxCapacity; $i++) {
                            if ($dp[$i - $room->people_count] + $room->price < $dp[$i]) {
                                $dp[$i] = $dp[$i - $room->people_count] + $room->price;
                                $choice[$i] = $room->id;
                            }
                        }
                    }

                    // Szukaj najtańszego rozwiązania dla liczby miejsc >= liczba osób
                    $minCost = INF;
                    $bestI = null;
                    for ($i = $peopleCount; $i <= $maxCapacity; $i++) {
                        if ($dp[$i] < $minCost) {
                            $minCost = $dp[$i];
                            $bestI = $i;
                        }
                    }

                    if ($minCost === INF) {
                        $roomAlloc[] = [
                            'room' => null,
                            'alloc' => null,
                            'total_people' => $peopleCount,
                            'cost' => 0,
                            'currency' => null,
                            'group_type' => $groupType,
                            'room_count' => 0,
                            'warning' => 'Brak możliwej kombinacji pokoi dla tej grupy (' . $groupType . ') w noclegu.'
                        ];
                    } else {
                        // Odtwarzanie wyboru pokoi
                        $allocRooms = [];
                        $i = $bestI;
                        while ($i > 0 && $choice[$i] !== null) {
                            $room = $rooms->firstWhere('id', $choice[$i]);
                            $allocRooms[] = $room;
                            $i -= $room->people_count;
                        }

                        // Zlicz ile razy każdy pokój został użyty
                        $roomCounts = [];
                        foreach ($allocRooms as $room) {
                            $roomCounts[$room->id] = ($roomCounts[$room->id] ?? 0) + 1;
                        }

                        $peopleAssigned = 0;
                        foreach ($roomCounts as $roomId => $count) {
                            $room = $rooms->firstWhere('id', $roomId);
                            for ($j = 0; $j < $count; $j++) {
                                $alloc = [
                                    'qty' => 0,
                                    'gratis' => 0,
                                    'staff' => 0,
                                    'driver' => 0,
                                ];

                                $toAssign = min($room->people_count, $peopleCount - $peopleAssigned);
                                $alloc[$groupType] = $toAssign;

                                $roomAlloc[] = [
                                    'room' => $room,
                                    'alloc' => $alloc,
                                    'total_people' => $toAssign,
                                    'cost' => $room->price,
                                    'currency' => $room->currency,
                                    'group_type' => $groupType,
                                    'room_count' => 1,
                                ];

                                $dayTotal[$room->currency] = ($dayTotal[$room->currency] ?? 0) + $room->price;
                                $roomTypeCount[$room->id]++;
                                $peopleAssigned += $toAssign;

                                if ($peopleAssigned >= $peopleCount) break 2;
                            }
                        }
                    }
                }

                $hotelStructure[] = [
                    'day' => $hotelDay->day,
                    'rooms' => $roomAlloc,
                    'day_total' => $dayTotal,
                ];

                // Dodaj do ogólnej sumy kosztów noclegów
                foreach ($dayTotal as $cur => $val) {
                    if ($cur === 'PLN') {
                        $plnPoints[] = [
                            'name' => 'Noclegi - dzień ' . $hotelDay->day,
                            'unit_price' => null,
                            'group_size' => null,
                            'cost' => $val,
                            'is_child' => false,
                            'currency_symbol' => 'PLN',
                        ];
                        $plnTotal += $val;
                    } else {
                        $currenciesPoints[$cur][] = [
                            'name' => 'Noclegi - dzień ' . $hotelDay->day,
                            'unit_price' => null,
                            'group_size' => null,
                            'cost' => $val,
                            'is_child' => false,
                            'currency_symbol' => $cur,
                        ];
                        $currenciesTotals[$cur] = ($currenciesTotals[$cur] ?? 0) + $val;
                    }
                }
            }

            // transport: obsługa autokaru (bus) zgodnie z widgetem
            $transportCostPLN = 0;
                if ($startPlaceId !== null && $templateStartId && $templateEndId) {
                    $basicDistanceForTransport = $d1 + $d2 + $programKm;
                    $defaultTransportKm = 1.1 * $basicDistanceForTransport + 50;

                    // jeśli jest konfiguracja autokaru, policz koszt autokaru w jego walucie
                    if ($bus) {
                        $duration = $template->duration_days ?? 1;
                        $includedKm = $duration * $bus->package_km_per_day;
                        $baseCost = $duration * $bus->package_price_per_day;
                        $busCurrency = $bus->currency ?? 'PLN';

                        $totalKm = $defaultTransportKm;
                        if ($totalKm <= $includedKm) {
                            $busTransportCost = $baseCost;
                        } else {
                            $extraKm = $totalKm - $includedKm;
                            $busTransportCost = $baseCost + ($extraKm * $bus->extra_km_price);
                        }

                        // liczba autobusów
                        $busCapacity = $bus->capacity > 0 ? $bus->capacity : 50;
                        $busCount = (int) ceil($qtyTotal / $busCapacity);

                        $busTransportCostTotal = $busTransportCost * $busCount;

                        if ($busCurrency === 'PLN') {
                            $plnPoints[] = ['name' => 'Koszt transportu (autokar)', 'cost' => $busTransportCostTotal];
                            $plnTotal += $busTransportCostTotal;
                        } else {
                            $currenciesPoints[$busCurrency][] = ['name' => 'Koszt transportu (autokar)', 'cost' => $busTransportCostTotal];
                            $currenciesTotals[$busCurrency] = ($currenciesTotals[$busCurrency] ?? 0) + $busTransportCostTotal;
                        }
                    } else {
                        // brak autokaru: dodaj domyślny koszt transportu do PLN
                        $transportCostPLN = $defaultTransportKm;
                        $plnPoints[] = ['name' => 'Koszt transportu', 'cost' => $transportCostPLN];
                        $plnTotal += $transportCostPLN;
                    }
            }

            // prepare temp calculation and markup
            $tempCalculation = ['PLN'=>['total'=>$plnTotal]];
            foreach ($currenciesTotals as $code => $total) { if ($code !== 'PLN') $tempCalculation[$code] = ['total'=>$total]; }
            $totalPLNBeforeMarkup = $this->calculateTotalInPLN($tempCalculation);
            $markupAmount = $this->calculateMarkupForTemplate($template, $totalPLNBeforeMarkup);

            // taxes
            $taxes = $template->taxes ?? collect();
            $totalTaxAmount = 0;
            foreach ($taxes as $tax) {
                if (!$tax->is_active) continue;
                $taxAmount = $tax->calculateTaxAmount($plnTotal, $markupAmount);
                $totalTaxAmount += $taxAmount;
            }

            $priceWithTax = $plnTotal + $markupAmount + $totalTaxAmount;
            $pricePerPerson = $qty > 0 ? round($priceWithTax / $qty, 2) : 0;

            $results[$qty] = [
                'event_template_qty_id' => $variantId,
                'qty' => $qty,
                'gratis' => $gratis,
                'staff' => $staff,
                'driver' => $driver,
                'price_per_person' => $pricePerPerson,
                'price_with_tax' => round($priceWithTax,2),
                'price_base' => round($plnTotal,2),
                'markup_amount' => round($markupAmount,2),
                'tax_amount' => round($totalTaxAmount,2),
                'transport_cost' => $transportCostPLN ? round($transportCostPLN,2) : null,
            ];

            if ($debug) {
                $results[$qty]['debug'] = [
                    'd1' => $d1,
                    'd2' => $d2,
                    'basicDistance' => $basicDistance,
                    'defaultTransportKm' => $defaultTransportKm ?? null,
                    'busTransportCostTotal' => $busTransportCostTotal,
                    'plnPoints' => $plnPoints,
                    'currenciesTotals' => $currenciesTotals,
                    'hotelStructure' => $hotelStructure,
                ];
            }
        }

        ksort($results);
        return $results;
    }

    private function calculatePointCost($qty, $groupSize, $unitPrice)
    {
        if ($groupSize <= 0) $groupSize = 1;
        return ceil($qty / $groupSize) * $unitPrice;
    }

    private function calculateTotalInPLN(array $tempCalculation): float
    {
        $total = 0;
        foreach ($tempCalculation as $code => $data) {
            if ($code === 'PLN') { $total += $data['total']; }
            else {
                $currency = Currency::where('symbol', $code)->first();
                $rate = $currency?->exchange_rate ?? 1;
                $total += $data['total'] * $rate;
            }
        }
        return $total;
    }

    private function calculateMarkupForTemplate(EventTemplate $template, float $base): float
    {
        // Prefer explicitly assigned Markup model if present
        $percent = null;

        // If relation is loaded or available, prefer it
        if (isset($template->markup) && $template->markup?->percent !== null) {
            $percent = $template->markup->percent;
        }

        // If markup_id is set but relation not loaded, try to resolve it
        if ($percent === null && !empty($template->markup_id)) {
            $markup = \App\Models\Markup::find($template->markup_id);
            $percent = $markup?->percent;
        }

        // Fallback to legacy field on template
        if ($percent === null && isset($template->markup_percent) && $template->markup_percent !== null) {
            $percent = $template->markup_percent;
        }

        // Final fallback: system default markup (ensure some value)
        if ($percent === null) {
            $default = \App\Models\Markup::where('is_default', true)->first();
            $percent = $default?->percent ?? 20;
        }

        \Illuminate\Support\Facades\Log::info("[MARKUP] Using markup percent={$percent} for event_template_id={$template->id}");
        return $base * ($percent / 100);
    }
}
