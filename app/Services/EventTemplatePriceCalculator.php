<?php

namespace App\Services;

use App\Models\EventTemplate;
use App\Models\EventTemplateQty;
use App\Models\EventTemplatePricePerPerson;
use App\Models\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EventTemplatePriceCalculator
{
    public function calculateAndSave(EventTemplate $eventTemplate): void
    {
        // Najpierw usuń nieaktualne rekordy cen
        $this->cleanupObsoleteRecords($eventTemplate);

        // Załaduj relacje potrzebne do kalkulacji
        $eventTemplate->load(['taxes', 'markup']);

        $programPoints = $eventTemplate->programPoints()
            ->with(['currency', 'children.currency'])
            ->wherePivot('include_in_calculation', true)
            ->get();

        // Pobierz tylko warianty QTY globalne (nie powiązane z konkretnym szablonem)
        // jeśli warianty są globalne, używaj wszystkich
        // jeśli są powiązane z szablonem, używaj tylko dla tego szablonu
        $qtyVariants = \App\Models\EventTemplateQty::all(); // TODO: sprawdzić czy QTY są globalne czy per szablon
        $currencies = collect();
            foreach ($programPoints as $point) {
                Log::debug('[DEBUG] Iteracja eventTemplate: event_template_id=' . $eventTemplate->id);
            if ($point->currency) {
                $currencies->push($point->currency);
            }
            foreach ($point->children as $child) {
                if ($child->currency) {
                    $currencies->push($child->currency);
                }
            }
        }
        $currencies = $currencies->unique('id');

        // Pobierz dostępne miejsca startowe dla tego szablonu
        $availableStartPlaces = \App\Models\EventTemplateStartingPlaceAvailability::where('event_template_id', $eventTemplate->id)
            ->where('available', true)
            ->with('startPlace')
            ->get();

        // Usuń ceny dla miejsc, które zostały odznaczone (nie są już dostępne)
        $availableStartPlaceIds = $availableStartPlaces->pluck('start_place_id')->toArray();
        \App\Models\EventTemplatePricePerPerson::where('event_template_id', $eventTemplate->id)
            ->whereNotIn('start_place_id', $availableStartPlaceIds)
            ->delete();

        if ($availableStartPlaces->isEmpty()) {
            \Illuminate\Support\Facades\Log::warning("Brak dostępnych kombinacji miejsc startowych do przeliczenia cen dla event_template_id={$eventTemplate->id}. Przeliczanie zostaje pominięte.");
            return;
        }

        \Illuminate\Support\Facades\Log::info("Przeliczanie cen TYLKO dla dostępnych kombinacji miejsc startowych (oznaczonych jako dostępne w adminie) dla event_template_id={$eventTemplate->id}. Liczba kombinacji: " . $availableStartPlaces->count());

        // Use centralized calculation engine (matches admin widget)
        $engine = new EventTemplateCalculationEngine();

            // find best PLN currency id (use symbol or name - table has `symbol` and `name`)
            $plnCurrency = Currency::where('symbol', 'PLN')
                ->orWhere('name', 'like', '%złoty%')
                ->orWhere('name', 'like', '%zloty%')
                ->first();
            $plnCurrencyId = $plnCurrency?->id ?? null;

        // Oblicz ceny dla każdego dostępnego miejsca startowego
        foreach ($availableStartPlaces as $availability) {
            // Pomijaj kalkulację jeśli miejsce startu programu jest tym samym miejscem
            if ($eventTemplate->start_place_id == $availability->start_place_id) {
                \Illuminate\Support\Facades\Log::info("Pominięto kalkulację dla start_place_id={$availability->start_place_id} (to samo co miejsce startu programu)");
                continue;
            }

            \Illuminate\Support\Facades\Log::info("Przeliczanie (engine) dla start_place_id={$availability->start_place_id} (nazwa: " . ($availability->startPlace->name ?? 'brak') . ")");

            $detailed = $engine->calculateDetailed($eventTemplate, $availability->start_place_id);

            // Zapisz wyniki tylko w PLN (zgodne z administracyjnym widokiem)
            foreach ($qtyVariants as $qtyVariant) {
                $qty = $qtyVariant->qty;
                if (!isset($detailed[$qty])) {
                    continue;
                }
                $calc = $detailed[$qty];

                // build tax breakdown from template taxes using same inputs
                $taxBreakdown = [];
                $totalTaxAmount = 0;
                foreach ($eventTemplate->taxes ?? [] as $tax) {
                    if (!$tax->is_active) {
                        continue;
                    }
                    $taxAmount = $tax->calculateTaxAmount($calc['price_base'] ?? 0, $calc['markup_amount'] ?? 0);
                    if ($taxAmount > 0) {
                        $taxBreakdown[] = [
                            'tax_id' => $tax->id,
                            'tax_name' => $tax->name,
                            'tax_percentage' => $tax->percentage,
                            'apply_to_base' => $tax->apply_to_base,
                            'apply_to_markup' => $tax->apply_to_markup,
                            'tax_amount' => round($taxAmount, 2),
                        ];
                        $totalTaxAmount += $taxAmount;
                    }
                }

                $saveData = [
                    'price_per_person' => $calc['price_per_person'] ?? 0,
                    'price_per_tax' => round($totalTaxAmount, 2),
                    'transport_cost' => isset($calc['transport_cost']) ? round($calc['transport_cost'], 2) : null,
                    'price_base' => round($calc['price_base'] ?? 0, 2),
                    'markup_amount' => round($calc['markup_amount'] ?? 0, 2),
                    'tax_amount' => round($totalTaxAmount, 2),
                    'price_with_tax' => round($calc['price_with_tax'] ?? 0, 2),
                    'tax_breakdown' => $taxBreakdown,
                    'updated_at' => now(),
                ];

                try {
                    \Illuminate\Support\Facades\Log::info("[ENGINE] Próba zapisu ceny: event_template_id={$eventTemplate->id}, event_template_qty_id={$qtyVariant->id}, start_place_id={$availability->start_place_id}, currency_id=" . ($plnCurrencyId ?? 'brak') . ", qty={$qty}");
                    EventTemplatePricePerPerson::updateOrCreate([
                        'event_template_id' => $eventTemplate->id,
                        'event_template_qty_id' => $qtyVariant->id,
                        'currency_id' => $plnCurrencyId,
                        'start_place_id' => $availability->start_place_id,
                    ], $saveData);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Błąd podczas zapisu ceny (engine): " . $e->getMessage() . " | Data: " . json_encode([
                        'event_template_id' => $eventTemplate->id,
                        'event_template_qty_id' => $qtyVariant->id,
                        'currency_id' => $plnCurrencyId,
                        'start_place_id' => $availability->start_place_id,
                        'saveData' => $saveData,
                    ]));
                }
            }
        }
    }

    private function calculatePricesForStartPlace($eventTemplate, $startPlaceId, $qtyVariants, $currencies, $programPoints): void
    {
        // Sprawdź czy startPlaceId jest ustawione (pomijaj tylko null)
        if ($startPlaceId === null) {
            \Illuminate\Support\Facades\Log::warning("POMINIĘTO przeliczanie ceny: brak start_place_id dla event_template_id={$eventTemplate->id}");
            return;
        }

        // Pobierz podatki przypisane do tego szablonu wydarzenia
        $eventTaxes = $eventTemplate->taxes;

        // Oblicz koszt transportu dla tego miejsca startowego
        $transportCostPLN = $this->calculateTransportCost($eventTemplate, $startPlaceId);

        foreach ($qtyVariants as $qtyVariant) {
            \Illuminate\Support\Facades\Log::info("[DEBUG] Iteracja qtyVariant: event_template_id={$eventTemplate->id}, start_place_id={$startPlaceId}, event_template_qty_id={$qtyVariant->id}, qty={$qtyVariant->qty}");
            $qty = $qtyVariant->qty;
            $qtyTotal = $qty + ($qtyVariant->gratis ?? 0) + ($qtyVariant->staff ?? 0) + ($qtyVariant->driver ?? 0);
            foreach ($currencies as $currency) {
                $total = 0;
                // Główne punkty
                foreach ($programPoints->where('currency_id', $currency->id) as $point) {
                    $groupSize = $point->group_size ?? 1;
                    $unitPrice = $point->unit_price ?? 0;
                    $pointPrice = ceil($qtyTotal / $groupSize) * $unitPrice;
                    $total += $pointPrice;
                }
                // Podpunkty
                foreach ($programPoints as $point) {
                    foreach ($point->children->where('currency_id', $currency->id) as $child) {
                        $groupSize = $child->group_size ?? 1;
                        $unitPrice = $child->unit_price ?? 0;
                        $childPrice = ceil($qtyTotal / $groupSize) * $unitPrice;
                        $total += $childPrice;
                    }
                }

                // Dodaj koszt transportu tylko dla PLN (zabezpieczone sprawdzanie waluty)
                $transportPerPerson = 0;
                if ($this->isPolishCurrency($currency) && $transportCostPLN > 0) {
                    $transportPerPerson = $qty > 0 ? ceil($transportCostPLN / $qty) : 0;
                    $total += $transportCostPLN;
                    \Illuminate\Support\Facades\Log::info("Adding transport cost: transportCostPLN={$transportCostPLN}, qty={$qty}, transportPerPerson={$transportPerPerson}, new total={$total}, currency={$currency->name}");
                } else {
                    \Illuminate\Support\Facades\Log::info("No transport cost added: currency={$currency->name} (code: {$currency->code}), transportCostPLN={$transportCostPLN}, qty={$qty}");
                }

                // Oblicz narzut (markup)
                $markupAmount = 0;
                if ($eventTemplate->markup && $eventTemplate->markup->percent > 0) {
                    $markupAmount = ($total * $eventTemplate->markup->percent) / 100;
                }

                // Suma bez podatków
                $priceWithoutTax = $total + $markupAmount;

                // Oblicz podatki
                $taxBreakdown = [];
                $totalTaxAmount = 0;
                foreach ($eventTaxes as $tax) {
                    if (!$tax->is_active) continue;
                    $taxAmount = $tax->calculateTaxAmount($total, $markupAmount);
                    if ($taxAmount > 0) {
                        $taxBreakdown[] = [
                            'tax_id' => $tax->id,
                            'tax_name' => $tax->name,
                            'tax_percentage' => $tax->percentage,
                            'apply_to_base' => $tax->apply_to_base,
                            'apply_to_markup' => $tax->apply_to_markup,
                            'tax_amount' => round($taxAmount, 2)
                        ];
                        $totalTaxAmount += $taxAmount;
                    }
                }

                // Cena końcowa z podatkami
                $priceWithTax = $priceWithoutTax + $totalTaxAmount;

                // Cena za osobę: dziel tylko przez uczestników (qty)
                $pricePerPerson = $qty > 0 ? round($priceWithTax / $qty, 2) : 0;

                $saveData = [
                    'price_per_person' => $pricePerPerson, // Cena za osobę z podatkami
                    'price_per_tax' => round($totalTaxAmount, 2),  // Kwota podatków za osobę
                    'transport_cost' => $this->isPolishCurrency($currency) ? round($transportCostPLN, 2) : null,
                    'price_base' => round($total, 2),
                    'markup_amount' => round($markupAmount, 2),
                    'tax_amount' => round($totalTaxAmount, 2),
                    'price_with_tax' => round($priceWithTax, 2),
                    'tax_breakdown' => $taxBreakdown,
                    'updated_at' => now(),
                ];
                try {
                    \Illuminate\Support\Facades\Log::info("[DEBUG] Próba zapisu ceny: event_template_id={$eventTemplate->id}, event_template_qty_id={$qtyVariant->id}, start_place_id={$startPlaceId}, currency_id=".($currency->id ?? 'brak').", qty={$qty}");
                    \Illuminate\Support\Facades\Log::info("Saving price data: " . json_encode($saveData)
                        . " | event_template_id={$eventTemplate->id}"
                        . ", event_template_qty_id={$qtyVariant->id}"
                        . ", currency_id=" . ($currency->id ?? 'brak')
                        . ", currency_code=" . ($currency->code ?? 'brak')
                        . ", start_place_id={$startPlaceId}"
                        . ", qty={$qty}");
                    EventTemplatePricePerPerson::updateOrCreate([
                        'event_template_id' => $eventTemplate->id,
                        'event_template_qty_id' => $qtyVariant->id,
                        'currency_id' => $currency->id,
                        'start_place_id' => $startPlaceId,
                    ], $saveData);
                } catch (\Throwable $e) {
                    \Illuminate\Support\Facades\Log::error("Błąd podczas zapisu ceny: " . $e->getMessage() . " | Data: " . json_encode([
                        'event_template_id' => $eventTemplate->id,
                        'event_template_qty_id' => $qtyVariant->id,
                        'currency_id' => $currency->id,
                        'start_place_id' => $startPlaceId,
                        'saveData' => $saveData
                    ]));
                }
            }
        }
    }
    private function calculateTransportCost($eventTemplate, $startPlaceId): float
    {
        if (!$startPlaceId || !$eventTemplate->start_place_id || !$eventTemplate->end_place_id) {
            \Illuminate\Support\Facades\Log::info("Transport cost = 0: Missing places. startPlaceId={$startPlaceId}, template_start={$eventTemplate->start_place_id}, template_end={$eventTemplate->end_place_id}");
            return 0;
        }

        // Odległość: miejsce startowe → początek programu
        $d1 = \App\Models\PlaceDistance::where('from_place_id', $startPlaceId)
            ->where('to_place_id', $eventTemplate->start_place_id)
            ->first()?->distance_km ?? 0;

        // Odległość: koniec programu → miejsce startowe  
        $d2 = \App\Models\PlaceDistance::where('from_place_id', $eventTemplate->end_place_id)
            ->where('to_place_id', $startPlaceId)
            ->first()?->distance_km ?? 0;

        // Program km
        $programKm = $eventTemplate->program_km ?? 0;

        $basicDistance = $d1 + $d2 + $programKm;

        // Wzór: 1.1 × podstawowa_odległość + 50 km
        $transportCost = 1.1 * $basicDistance + 50;

        \Illuminate\Support\Facades\Log::info("Transport cost calculation: d1={$d1}, d2={$d2}, programKm={$programKm}, basicDistance={$basicDistance}, transportCost={$transportCost} for startPlace={$startPlaceId}, template={$eventTemplate->id}");

        return $transportCost;
    }

    /**
     * Usuwa nieaktualne rekordy cen dla szablonu
     */
    private function cleanupObsoleteRecords(EventTemplate $eventTemplate): void
    {
        // Pobierz aktualne ID wariantów ilości uczestników
        $currentQtyIds = \App\Models\EventTemplateQty::pluck('id')->toArray();

        // Pobierz aktualne ID dostępnych miejsc startowych dla tego szablonu
        $availableStartPlaceIds = \App\Models\EventTemplateStartingPlaceAvailability::where('event_template_id', $eventTemplate->id)
            ->where('available', true)
            ->pluck('start_place_id')
            ->toArray();

        // Jeśli nie ma dostępnych miejsc startowych, zachowaj rekordy z start_place_id = null (backward compatibility)
        if (empty($availableStartPlaceIds)) {
            $availableStartPlaceIds = [null];
        }

        // Usuń rekordy dla nieistniejących wariantów ilości uczestników
        EventTemplatePricePerPerson::where('event_template_id', $eventTemplate->id)
            ->whereNotIn('event_template_qty_id', $currentQtyIds)
            ->delete();

        // Usuń rekordy dla niedostępnych miejsc startowych
        $query = EventTemplatePricePerPerson::where('event_template_id', $eventTemplate->id);

        if (in_array(null, $availableStartPlaceIds)) {
            // Jeśli null jest dozwolone, usuń tylko te które mają start_place_id nie na liście (ale nie null)
            $availableStartPlaceIdsWithoutNull = array_filter($availableStartPlaceIds, fn($id) => $id !== null);
            if (!empty($availableStartPlaceIdsWithoutNull)) {
                $query->where(function ($q) use ($availableStartPlaceIdsWithoutNull) {
                    $q->whereNotNull('start_place_id')
                        ->whereNotIn('start_place_id', $availableStartPlaceIdsWithoutNull);
                });
            } else {
                // Usuń wszystkie z start_place_id != null jeśli tylko null jest dozwolone
                $query->whereNotNull('start_place_id');
            }
        } else {
            // Usuń rekordy z start_place_id = null oraz te nie na liście
            $query->where(function ($q) use ($availableStartPlaceIds) {
                $q->whereNull('start_place_id')
                    ->orWhereNotIn('start_place_id', $availableStartPlaceIds);
            });
        }

        $query->delete();
    }

    /**
     * Sprawdza czy waluta to polski złoty (zabezpieczone przed duplikatami)
     */
    private function isPolishCurrency($currency): bool
    {
        if (!$currency) {
            return false;
        }

        // Sprawdź kod waluty (jeśli jest ustawiony)
        if (!empty($currency->code) && $currency->code === 'PLN') {
            return true;
        }

        // Sprawdź nazwę waluty (zabezpieczone przed różnymi wariantami)
        $name = strtolower($currency->name ?? '');

        return str_contains($name, 'polski') && str_contains($name, 'złoty') ||
            str_contains($name, 'złoty') && str_contains($name, 'polski') ||
            $name === 'pln' ||
            $name === 'polski złoty' ||
            $name === 'złoty polski';
    }
}
