<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\EventTemplate;
use App\Models\EventTemplateStartingPlaceAvailability;
use App\Models\EventTemplatePricePerPerson;
use App\Models\Currency;
use App\Models\Place;
use App\Models\EventType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cookie;

class FrontController extends Controller
{
    /**
     * Remove diacritics from a string (for fuzzy search)
     */
    private function removeDiacritics($string)
    {
        $diacritics = [
            'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n', 'ó' => 'o', 'ś' => 's', 'ż' => 'z', 'ź' => 'z',
            'Ą' => 'A', 'Ć' => 'C', 'Ę' => 'E', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'O', 'Ś' => 'S', 'Ż' => 'Z', 'Ź' => 'Z',
        ];
        return strtr($string, $diacritics);
    }
    public function blog(Request $request)
    {
        // Featured posts (max 3)
        $featuredPosts = BlogPost::where('status', 'active')
            ->where('published_at', '<=', now())
            ->where('is_featured', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        // Fill with regular posts if not enough featured
        $remainingCount = 3 - $featuredPosts->count();
        $regularPosts = collect();
        if ($remainingCount > 0) {
            $excludeIds = $featuredPosts->pluck('id')->toArray();
            $regularPosts = BlogPost::where('status', 'active')
                ->where('published_at', '<=', now())
                ->whereNotIn('id', $excludeIds)
                ->orderBy('published_at', 'desc')
                ->take($remainingCount)
                ->get();
        }
        $blogPosts = $featuredPosts->merge($regularPosts);
        return view('front.blog', compact('blogPosts'));
    }

    public function blogPost($slug)
    {
        $blogPost = BlogPost::where('slug', $slug)
            ->where('status', 'active')
            ->where('published_at', '<=', now())
            ->firstOrFail();

        // Previous/next navigation
        $previousPost = BlogPost::where('status', 'active')
            ->where('published_at', '<=', now())
            ->where('published_at', '<', $blogPost->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
        $nextPost = BlogPost::where('status', 'active')
            ->where('published_at', '<=', now())
            ->where('published_at', '>', $blogPost->published_at)
            ->orderBy('published_at', 'asc')
            ->first();

        return view('front.blog-post', compact('blogPost', 'previousPost', 'nextPost'));
    }
    public function directorypackages(Request $request)
    {
        $form_name = $request->name;
        $form_min_price = $request->min_price;
        $form_max_price = $request->max_price;
        $form_destination_id = $request->destination_id;
        $form_length_id = $request->length_id;

    $region_id = $request->region_id ?? Cookie::get('region_id', 16);

        // NEW: start places (for unified selector functionality, appearance unchanged)
        $startPlaceIds = EventTemplateStartingPlaceAvailability::query()
            ->where('available', true)
            ->select('start_place_id')
            ->distinct()
            ->pluck('start_place_id');
    $startPlaces = Place::whereIn('id', $startPlaceIds)->where('starting_place', true)->orderBy('name')->get();
        $currentStartPlaceId = $request->get('start_place_id');
        if (!$currentStartPlaceId) {
            $currentStartPlaceId = $request->cookie('start_place_id');
        }
        if ($currentStartPlaceId && !$startPlaces->where('id', (int)$currentStartPlaceId)->first()) {
            $currentStartPlaceId = null; // invalid -> reset
        }

        if ($request->region_id) {
            Cookie::queue('region_id', $request->region_id, 60 * 24 * 365); // 1 year expiration
        }

        $mapEventTemplate = function($eventTemplate) {
            $eventTemplate->featured_photo = $eventTemplate->featured_image ?: 'default.png';
            $eventTemplate->description = $eventTemplate->event_description;
            $eventTemplate->length_id = $eventTemplate->duration_days;
            $eventTemplate->price = '0';
            $eventTemplate->old_price = null;
            $eventTemplate->transport_id = null;
            $eventTemplate->destination_id = null;
            $eventTemplate->region_id = null;
            $eventTemplate->length = (object) [
                'id' => $eventTemplate->duration_days,
                'name' => $eventTemplate->duration_days == 1 ? '1 dzień' : $eventTemplate->duration_days . ' dni'
            ];
            $eventTemplate->transport = (object) [
                'id' => null,
                'name' => 'Nie określono'
            ];
            return $eventTemplate;
        };

        // Helper closure to fetch templates filtered by selected start_place availability (if chosen)
        $fetchByDuration = function($operator, $value, $limit) use ($mapEventTemplate, $request) {
            $q = \App\Models\EventTemplate::query()
                ->where('is_active', true)
                ->when($operator === '>=', fn($qq) => $qq->where('duration_days', '>=', $value), fn($qq) => $qq->where('duration_days', $value))
                ->orderByDesc('id') // deterministic-ish newest first
                ->with(['startingPlaceAvailabilities']);

            $startPlaceId = $request->get('start_place_id') ?: $request->cookie('start_place_id');
            if ($startPlaceId) {
                $q->whereHas('startingPlaceAvailabilities', function($sub) use ($startPlaceId) {
                    $sub->where('start_place_id', (int)$startPlaceId)->where('available', true);
                });
            }
            return $q->take($limit)->get()->map($mapEventTemplate);
        };

        $random_one_day = $fetchByDuration('=', 1, 8);
        $random_one_day_mobile = $fetchByDuration('=', 1, 3);
        $random_two_day = $fetchByDuration('=', 2, 8);
        $random_three_day = $fetchByDuration('=', 3, 8);
        $random_four_day = $fetchByDuration('=', 4, 8);
        $random_five_day = $fetchByDuration('=', 5, 8);
        $random_six_day = $fetchByDuration('>=', 6, 8);

    $destinations = collect();
    $regions = collect();
    $destinationModel = 'App\\Models\\Destination';
    $regionModel = 'App\\Models\\Region';
    if (class_exists($destinationModel)) {
        $destinations = $destinationModel::orderBy('name','asc')->get();
    }
    if (class_exists($regionModel)) {
        $regions = $regionModel::orderBy('name','asc')->get();
    }

        $lengths = \App\Models\EventTemplate::select('duration_days')
            ->whereNotNull('duration_days')
            ->distinct()
            ->orderBy('duration_days', 'asc')
            ->get()
            ->map(function($template) {
                return (object)[
                    'id' => $template->duration_days,
                    'name' => $template->duration_days == 1 ? '1 dzień' : $template->duration_days . ' dni'
                ];
            });

        $query = \App\Models\EventTemplate::orderBy('slug', 'desc');
        if ($form_name) {
            $query->where('name', 'like', '%' . $form_name . '%');
        }
        if ($form_min_price) {
            $query->where('price', '>', $form_min_price);
        }
        if ($form_max_price) {
            $query->where('price', '<', $form_max_price);
        }
        if ($form_destination_id) {
            $query->where('destination_id', $form_destination_id);
        }
        if ($form_length_id) {
            $query->where('length_id', $form_length_id);
        }
        if ($region_id) {
            $query->where('region_id', $region_id);
        }
        $packages = $query->paginate(12);
        $packages->getCollection()->transform($mapEventTemplate);

        return view('front.directory-packages', compact(
            'random_six_day', 'random_five_day', 'random_four_day', 'random_three_day',
            'random_two_day', 'random_one_day_mobile', 'random_one_day',
            'destinations', 'regions', 'lengths', 'packages',
            'form_name', 'form_min_price', 'form_max_price', 'form_destination_id',
            'region_id', 'form_length_id', 'startPlaces', 'currentStartPlaceId'
        ));
    }
    public function home(Request $request)
    {
        // Lista dostępnych miejsc startowych (jak w packages())
        $startPlaceIds = EventTemplateStartingPlaceAvailability::query()
            ->where('available', true)
            ->select('start_place_id')
            ->distinct()
            ->pluck('start_place_id');
    $startPlaces = Place::whereIn('id', $startPlaceIds)->where('starting_place', true)->orderBy('name')->get();

        // Kolejność ustalania start_place_id: route slug -> explicit query -> cookie -> (brak domyślnego na home)
        $start_place_id = null;
        $regionSlug = $request->route('regionSlug');
        if ($regionSlug && $regionSlug !== 'region') {
            $place = $startPlaces->first(function($pl) use ($regionSlug){ return str()->slug($pl->name) === $regionSlug; });
            if ($place) {
                $start_place_id = $place->id;
                Cookie::queue('start_place_id', (string)$start_place_id, 60 * 24 * 365);
                // diagnostyka: który Place został dopasowany przez regionSlug
                try { Log::info("home: regionSlug={$regionSlug}, matched_place_id={$place->id}, name={$place->name}"); } catch (\Throwable $e) {}
            }
        }
        if (!$start_place_id) {
            $start_place_id = $request->get('start_place_id');
        }
        if (!$start_place_id) {
            $start_place_id = $request->cookie('start_place_id');
        }
        // Walidacja: jeśli wybrane id nie jest na liście dostępnych – ignoruj
        if ($start_place_id && !$startPlaces->where('id', (int)$start_place_id)->first()) {
            $start_place_id = null;
        }

        $durations = [
            (object)['id' => 1, 'name' => '1 dzień'],
            (object)['id' => 2, 'name' => '2 dni'],
            (object)['id' => 3, 'name' => '3 dni'],
            (object)['id' => 5, 'name' => '5 dni'],
            (object)['id' => 7, 'name' => '7 dni'],
        ];

        // Pobierz (max 12) aktywnych EventTemplates, opcjonalnie przefiltrowanych po dostępności dla start_place_id
        $carouselQuery = EventTemplate::where('is_active', true)
            ->with([
                'startingPlaceAvailabilities',
                'pricesPerPerson.eventTemplateQty',
                'pricesPerPerson.currency',
            ]);
        if ($start_place_id) {
            $carouselQuery->whereHas('startingPlaceAvailabilities', function($q) use ($start_place_id) {
                $q->where('start_place_id', $start_place_id)->where('available', true);
            });
        }
        $random = $carouselQuery->latest('id')
            ->take(12)
            ->get()
            ->map(function($eventTemplate) use ($start_place_id) {
                $eventTemplate->featured_photo = $eventTemplate->featured_image ? basename($eventTemplate->featured_image) : 'default.png';
                $eventTemplate->length = (object) [
                    'id' => $eventTemplate->duration_days,
                    'name' => $eventTemplate->duration_days == 1 ? '1 dzień' : $eventTemplate->duration_days . ' dni'
                ];

                // Filtrowanie cen – analogiczne do packages(): tylko PLN, >0, dopasowane do start_place_id (lub null jeśli brak wybranego)
                $plnCurrencyIds = Currency::where(function ($q) {
                    $q->where('name', 'like', '%polski%złoty%')
                        ->orWhere('name', 'like', '%złoty%polski%')
                        ->orWhere('name', '=', 'Polski złoty')
                        ->orWhere('name', '=', 'Złoty polski')
                        ->orWhere('code', '=', 'PLN');
                })->pluck('id')->toArray();

                if ($eventTemplate->relationLoaded('pricesPerPerson')) {
                    $prices = $eventTemplate->pricesPerPerson
                        ->filter(function($p) use ($plnCurrencyIds, $start_place_id) {
                            if (!in_array($p->currency_id, $plnCurrencyIds)) return false;
                            if ($p->price_per_person <= 0) return false;
                            if ($start_place_id) {
                                return (int)$p->start_place_id === (int)$start_place_id;
                            }
                            return $p->start_place_id === null; // brak wybranego miejsca -> ceny globalne
                        })
                        ->groupBy('event_template_qty_id')
                        ->map(fn($group) => $group->sortByDesc('id')->first())
                        ->values();
                    $eventTemplate->setRelation('pricesPerPerson', $prices);
                    $min = $prices->count() ? $prices->min('price_per_person') : null;
                    $eventTemplate->computed_price = $min !== null ? (float)$min : null;
                } else {
                    $eventTemplate->computed_price = null;
                }

                return $eventTemplate;
            });
        $random_chunks = $random->chunk(4);

        $eventTypes = \App\Models\EventType::orderBy('name')->get();

        // Pobierz najnowsze aktywne posty blogowe (do 3)
        $blogPosts = \App\Models\BlogPost::where('status', 'active')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('front.home', [
            'startPlaces' => $startPlaces,
            'start_place_id' => $start_place_id,
            'durations' => collect($durations),
            'random_chunks' => $random_chunks,
            'blogPosts' => $blogPosts,
            'eventTypes' => $eventTypes,
            // Ensure view has sliders variable even if slider section is commented out or feature disabled
            'sliders' => collect(),
        ]);
    }

    public function packages()
    {
        // Pobierz prawdziwe dane z bazy
        $length_id = request('length_id');
        $sort_by = request('sort_by');
        $event_type_id = request('event_type_id');

        // Najpierw route param regionSlug -> start_place
        $start_place_id = null;
        $regionSlug = request()->route('regionSlug');
        if ($regionSlug && $regionSlug !== 'region') {
            $place = Place::all()->first(function($pl) use ($regionSlug){ return str()->slug($pl->name) === $regionSlug; });
            if ($place) {
                $start_place_id = $place->id;
                // Upewnij się, że cookie nadpisane, aby JS nie przywrócił starej wartości
                Cookie::queue('start_place_id', (string)$start_place_id, 60 * 24 * 365);
            }
        }
        // Jeśli nie było route slug konkretnego miejsca – dopuszczamy query param
        if (!$start_place_id) {
            $start_place_id = request('start_place_id');
        }
        // Fallback cookie
        if (!$start_place_id) {
            $start_place_id = request()->cookie('start_place_id');
        }

        // Pobierz unikalne start_place_id z event_template_starting_place_availability
        $startPlaceIds = EventTemplateStartingPlaceAvailability::query()
            ->where('available', true)
            ->select('start_place_id')
            ->distinct()
            ->pluck('start_place_id');
    $startPlaces = Place::whereIn('id', $startPlaceIds)->where('starting_place', true)->orderBy('name')->get();

        // Śledzenie czy użyto domyślnej wartości Warszawa
        $usedDefaultWarszawa = false;
        
        // Jeśli nie ma wybranego start_place_id w URL lub jest pusty, sprawdź cookie
        if (!$start_place_id || !$startPlaces->where('id', $start_place_id)->first()) {
            $warszawaPlace = $startPlaces->firstWhere('name', 'Warszawa');
            if ($warszawaPlace) {
                $start_place_id = $warszawaPlace->id;
                $usedDefaultWarszawa = true;
            }
        }

        // Pobierz wszystkie Event Types dla filtra
        $eventTypes = EventType::orderBy('name')->get();

        $eventTemplate = EventTemplate::where('is_active', true)
            ->with([
                'tags',
                'programPoints',
                'startingPlaceAvailabilities.startPlace',
                'eventTypes',
                'pricesPerPerson.eventTemplateQty',
                'pricesPerPerson.currency',
            ])
            ->when($length_id, function($query) use ($length_id) {
                if ($length_id === '6plus') {
                    $query->where('duration_days', '>=', 6);
                } elseif ($length_id) {
                    $query->where('duration_days', $length_id);
                }
            })
            ->when($start_place_id, function($query) use ($start_place_id) {
                $query->whereHas('startingPlaceAvailabilities', function($q) use ($start_place_id) {
                    $q->where('start_place_id', $start_place_id)
                      ->where('available', true);
                });
            })
            ->when($event_type_id, function($query) use ($event_type_id) {
                $query->whereHas('eventTypes', function($q) use ($event_type_id) {
                    $q->where('event_types.id', $event_type_id);
                });
            })
            ->get();

        // Fuzzy search for destination_name (by name or tags, diacritics-insensitive)
        $destination_name = request('destination_name');
        if ($destination_name) {
            $search = $this->removeDiacritics(mb_strtolower($destination_name));
            $eventTemplate = $eventTemplate->filter(function($item) use ($search) {
                $name = $this->removeDiacritics(mb_strtolower($item->name));
                $nameMatch = strpos($name, $search) !== false;
                $tagMatch = $item->tags && $item->tags->contains(function($tag) use ($search) {
                    $tagName = $this->removeDiacritics(mb_strtolower($tag->name));
                    return strpos($tagName, $search) !== false;
                });
                return $nameMatch || $tagMatch;
            })->values();
        }

        // Sortowanie kolekcji po cenie lub nazwie
        if ($sort_by === 'price_asc') {
            $eventTemplate = $eventTemplate->sort(function($a, $b) {
                $aPrice = is_numeric($a->price) ? (float)$a->price : null;
                $bPrice = is_numeric($b->price) ? (float)$b->price : null;
                if ($aPrice === null && $bPrice === null) return 0;
                if ($aPrice === null) return 1;
                if ($bPrice === null) return -1;
                return $aPrice <=> $bPrice;
            })->values();
        } elseif ($sort_by === 'price_desc') {
            $eventTemplate = $eventTemplate->sort(function($a, $b) {
                $aPrice = is_numeric($a->price) ? (float)$a->price : null;
                $bPrice = is_numeric($b->price) ? (float)$b->price : null;
                if ($aPrice === null && $bPrice === null) return 0;
                if ($aPrice === null) return 1;
                if ($bPrice === null) return -1;
                return $bPrice <=> $aPrice;
            })->values();
        } elseif ($sort_by === 'name_asc') {
            $eventTemplate = $eventTemplate->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE)->values();
        } elseif ($sort_by === 'name_desc') {
            $eventTemplate = $eventTemplate->sortByDesc('name', SORT_NATURAL|SORT_FLAG_CASE)->values();
        }

        // Ujednolicenie z widokiem szczegółu: ceny PLN, >0, filtrowane po start_place_id, jedna najnowsza cena na qty + minimalna dla listy
        $plnCurrencyIds = Currency::where(function ($q) {
            $q->where('name', 'like', '%polski%złoty%')
                ->orWhere('name', 'like', '%złoty%polski%')
                ->orWhere('name', '=', 'Polski złoty')
                ->orWhere('name', '=', 'Złoty polski')
                ->orWhere('code', '=', 'PLN');
        })->pluck('id')->toArray();

        $eventTemplate = $eventTemplate->map(function($item) use ($plnCurrencyIds, $start_place_id) {
            // Ceny tylko dla wybranego start_place_id; jeśli nie wybrano żadnego, weź ceny globalne (start_place_id = null)
            $prices = $item->pricesPerPerson
                ->filter(function($p) use ($plnCurrencyIds, $start_place_id) {
                    if (!in_array($p->currency_id, $plnCurrencyIds)) return false;
                    if ($p->price_per_person <= 0) return false;
                    if ($start_place_id) {
                        return (int) $p->start_place_id === (int) $start_place_id;
                    }
                    return $p->start_place_id === null;
                })
                ->groupBy('event_template_qty_id')
                ->map(fn($group) => $group->sortByDesc('id')->first())
                ->values();

        // Ustaw przefiltrowane ceny jako relację (dla spójności w widokach)
            $item->setRelation('pricesPerPerson', $prices);

            // computed_price: minimalna dostępna cena po filtrach
            $min = $prices->count() ? $prices->min('price_per_person') : null;
            $item->computed_price = $min !== null ? (float) $min : null;
            return $item;
        });

        // Jeśli użytkownik wybrał region (start_place_id) – usuń eventy bez cen (>0) dla tego miejsca
        if ($start_place_id) {
            $eventTemplate = $eventTemplate->filter(function ($item) {
                return $item->pricesPerPerson && $item->pricesPerPerson->count() > 0;
            })->values();
            // Dodatkowo: zachowaj tylko te eventy, które mają availability dla wybranego start_place_id
            $eventTemplate = $eventTemplate->filter(function ($item) use ($start_place_id) {
                return $item->startingPlaceAvailabilities && $item->startingPlaceAvailabilities->contains(function($av) use ($start_place_id) {
                    return (int)$av->start_place_id === (int)$start_place_id && $av->available; });
            })->values();
        }

        return view('front.packages', [
            'eventTemplate' => $eventTemplate,
            'startPlaces' => $startPlaces,
            'start_place_id' => $start_place_id,
            'eventTypes' => $eventTypes,
            'event_type_id' => $event_type_id,
            'usedDefaultWarszawa' => $usedDefaultWarszawa,
        ]);
    }

    /**
     * Partial HTML with filtered packages list for live search (AJAX)
     */
    public function packagesPartial(Request $request)
    {
        $length_id = $request->get('length_id');
        $sort_by = $request->get('sort_by');
        $start_place_id = $request->get('start_place_id');
        $event_type_id = $request->get('event_type_id');
        $destination_name = $request->get('destination_name');
    $min_price = $request->get('min_price');
    $max_price = $request->get('max_price');
    $qtyRequested = $request->get('qty');

        $eventTemplate = EventTemplate::where('is_active', true)
            ->with([
                'tags',
                'programPoints',
                'startingPlaceAvailabilities.startPlace',
                'eventTypes',
                // ceny za osobę + warianty qty do wyliczeń
                'pricesPerPerson.eventTemplateQty',
                'pricesPerPerson.currency',
            ])
            ->when($length_id, function($query) use ($length_id) {
                if ($length_id === '6plus') {
                    $query->where('duration_days', '>=', 6);
                } elseif ($length_id) {
                    $query->where('duration_days', $length_id);
                }
            })
            ->when($start_place_id, function($query) use ($start_place_id) {
                $query->whereHas('startingPlaceAvailabilities', function($q) use ($start_place_id) {
                    $q->where('start_place_id', $start_place_id)
                      ->where('available', true);
                });
            })
            ->when($event_type_id, function($query) use ($event_type_id) {
                $query->whereHas('eventTypes', function($q) use ($event_type_id) {
                    $q->where('event_types.id', $event_type_id);
                });
            })
            ->get();

        if ($destination_name) {
            $search = $this->removeDiacritics(mb_strtolower($destination_name));
            $eventTemplate = $eventTemplate->filter(function($item) use ($search) {
                $name = $this->removeDiacritics(mb_strtolower($item->name));
                $nameMatch = strpos($name, $search) !== false;
                $tagMatch = $item->tags && $item->tags->contains(function($tag) use ($search) {
                    $tagName = $this->removeDiacritics(mb_strtolower($tag->name));
                    return strpos($tagName, $search) !== false;
                });
                return $nameMatch || $tagMatch;
            })->values();
        }

        // Oblicz computed_price na podstawie najbliższych progów qty i przefiltruj po cenie
        // Waluty PLN jak w package()
        $plnCurrencyIds = Currency::where(function ($q) {
            $q->where('name', 'like', '%polski%złoty%')
                ->orWhere('name', 'like', '%złoty%polski%')
                ->orWhere('name', '=', 'Polski złoty')
                ->orWhere('name', '=', 'Złoty polski')
                ->orWhere('code', '=', 'PLN');
        })->pluck('id')->toArray();

        $qtyInt = $qtyRequested !== null && $qtyRequested !== '' ? max(1, (int) $qtyRequested) : null;

    $eventTemplate = $eventTemplate->map(function ($item) use ($plnCurrencyIds, $start_place_id, $qtyInt) {
            // Zbierz najnowszą cenę per qty (PLN, >0) wyłącznie dla wybranego start_place_id (lub globalnych, gdy brak wyboru)
            $prices = $item->pricesPerPerson
                ->filter(function($p) use ($plnCurrencyIds, $start_place_id) {
                    if (!in_array($p->currency_id, $plnCurrencyIds)) return false;
                    if ($p->price_per_person <= 0) return false;
                    if ($start_place_id) {
                        return (int) $p->start_place_id === (int) $start_place_id;
                    }
                    return $p->start_place_id === null;
                })
                ->groupBy('event_template_qty_id')
                ->map(fn($group) => $group->sortByDesc('id')->first())
                ->values();

            // Podmień relację, aby widok korzystał z przefiltrowanych cen
            $item->setRelation('pricesPerPerson', $prices);

            // Mapa qty=>price
            $qtyToPrice = [];
            foreach ($prices as $price) {
                $q = $price->eventTemplateQty->qty ?? null;
                if ($q !== null) {
                    $qtyToPrice[(int)$q] = (float) $price->price_per_person;
                }
            }
            ksort($qtyToPrice);

            // Wylicz computed_price dla żądanego qty (najbliższy próg)
            $computed = null;
            if ($qtyInt && !empty($qtyToPrice)) {
                if (isset($qtyToPrice[$qtyInt])) {
                    $computed = $qtyToPrice[$qtyInt];
                } else {
                    $lowerQty = null; $upperQty = null;
                    foreach (array_keys($qtyToPrice) as $q) {
                        if ($q < $qtyInt) $lowerQty = $q;
                        if ($q > $qtyInt) { $upperQty = $q; break; }
                    }
                    if ($lowerQty === null) {
                        $computed = $qtyToPrice[$upperQty] ?? null;
                    } elseif ($upperQty === null) {
                        $computed = $qtyToPrice[$lowerQty] ?? null;
                    } else {
                        $dl = abs($qtyInt - $lowerQty);
                        $du = abs($upperQty - $qtyInt);
                        $computed = $dl <= $du ? $qtyToPrice[$lowerQty] : $qtyToPrice[$upperQty];
                    }
                }
            }

            // Fallback: minimalna cena, gdy brak qty lub brak dopasowań
            if ($computed === null && !empty($qtyToPrice)) {
                $computed = min($qtyToPrice);
            }

            $item->computed_price = $computed;
            return $item;
        });

        // Usuń eventy bez cen dla wybranego start_place_id
        if ($start_place_id) {
            $eventTemplate = $eventTemplate->filter(function($item){
                return $item->pricesPerPerson && $item->pricesPerPerson->count() > 0;
            })->values();
            $eventTemplate = $eventTemplate->filter(function ($item) use ($start_place_id) {
                return $item->startingPlaceAvailabilities && $item->startingPlaceAvailabilities->contains(function($av) use ($start_place_id) {
                    return (int)$av->start_place_id === (int)$start_place_id && $av->available; });
            })->values();
        }

        // Filtr po zakresie cen, jeśli podano min/max
        if ($min_price !== null && $min_price !== '') {
            $minP = (float) $min_price;
            $eventTemplate = $eventTemplate->filter(function($item) use ($minP) {
                return $item->computed_price !== null ? ($item->computed_price >= $minP) : true;
            })->values();
        }
        if ($max_price !== null && $max_price !== '') {
            $maxP = (float) $max_price;
            $eventTemplate = $eventTemplate->filter(function($item) use ($maxP) {
                return $item->computed_price !== null ? ($item->computed_price <= $maxP) : true;
            })->values();
        }

        // Sorting
        if ($sort_by === 'price_asc') {
            $eventTemplate = $eventTemplate->sort(function($a, $b) {
                $aPrice = is_numeric($a->computed_price) ? (float)$a->computed_price : INF;
                $bPrice = is_numeric($b->computed_price) ? (float)$b->computed_price : INF;
                return $aPrice <=> $bPrice;
            })->values();
        } elseif ($sort_by === 'price_desc') {
            $eventTemplate = $eventTemplate->sort(function($a, $b) {
                $aPrice = is_numeric($a->computed_price) ? (float)$a->computed_price : -INF;
                $bPrice = is_numeric($b->computed_price) ? (float)$b->computed_price : -INF;
                return $bPrice <=> $aPrice;
            })->values();
        } elseif ($sort_by === 'name_asc') {
            $eventTemplate = $eventTemplate->sortBy('name', SORT_NATURAL|SORT_FLAG_CASE)->values();
        } elseif ($sort_by === 'name_desc') {
            $eventTemplate = $eventTemplate->sortByDesc('name', SORT_NATURAL|SORT_FLAG_CASE)->values();
        }

        return view('front.partials.packages-list', [
            'eventTemplate' => $eventTemplate,
            'requestedQty' => $qtyInt,
            'start_place_id' => $start_place_id,
        ]);
    }

    public function package($slug)
    {
        $eventTemplate = EventTemplate::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();
    // Determine start place only from cookie now (no query param kept)
    $startPlaceId = request()->cookie('start_place_id');
    return redirect()->to($eventTemplate->prettyUrl($startPlaceId ? (int)$startPlaceId : null), 301);
    }

    public function packagePretty($regionSlug, $dayLength, $id, $slug)
    {
        $eventTemplate = EventTemplate::where('id', $id)
            ->where('is_active', true)
            ->with(['tags', 'programPoints'])
            ->firstOrFail();

        // Always resolve start_place_id from regionSlug
        $startPlaceId = null;
        if ($regionSlug && $regionSlug !== 'region') {
            $place = Place::all()->first(function($pl) use ($regionSlug){ return str()->slug($pl->name) === $regionSlug; });
            if ($place) {
                $startPlaceId = $place->id;
            }
        }

        // If not found, fallback to null (no cookie fallback, strict URL-based)

        // Optionally, redirect if regionSlug does not match canonical slug for selected place
        $expectedRegion = $startPlaceId ? str()->slug(optional(Place::find($startPlaceId))->name) : 'region';
        $expectedDay = ($eventTemplate->duration_days ?? 0) . '-dniowe';
        $expectedSlug = $eventTemplate->slug;
        if ($regionSlug !== $expectedRegion || $dayLength !== $expectedDay || $slug !== $expectedSlug) {
            return redirect()->to($eventTemplate->prettyUrl($startPlaceId ? (int)$startPlaceId : null), 301);
        }

    // Pricing logic (PLN only, filtered by start_place_id)
        $plnCurrencyIds = Currency::where(function ($q) {
            $q->where('name', 'like', '%polski%złoty%')
                ->orWhere('name', 'like', '%złoty%polski%')
                ->orWhere('name', '=', 'Polski złoty')
                ->orWhere('name', '=', 'Złoty polski')
                ->orWhere('code', '=', 'PLN');
        })->pluck('id')->toArray();

        $pricesQuery = EventTemplatePricePerPerson::with(['eventTemplateQty', 'currency'])
            ->where('event_template_id', $eventTemplate->id)
            ->whereIn('currency_id', $plnCurrencyIds)
            ->where('price_per_person', '>', 0);
        if ($startPlaceId) {
            $pricesQuery->where('start_place_id', (int) $startPlaceId);
        } else {
            $pricesQuery->whereNull('start_place_id');
        }
        $filteredPrices = $pricesQuery
            ->orderBy('event_template_qty_id')
            ->orderByDesc('id')
            ->get()
            ->groupBy('event_template_qty_id')
            ->map(fn($group) => $group->first())
            ->values();
        // Tymczasowe logowanie diagnostyczne
        try {
            Log::info("packagePretty: event_template_id={$eventTemplate->id}, resolved_start_place_id=" . ($startPlaceId ?? 'null') . ", prices_found=" . $filteredPrices->count());
            $ids = $filteredPrices->pluck('start_place_id')->unique()->values()->toArray();
            Log::info('packagePretty: start_place_ids_in_prices=' . json_encode($ids));
        } catch (\Throwable $e) {
            // ignore logging failures
        }
        $eventTemplate->setRelation('pricesPerPerson', $filteredPrices);

        // Previous / next within same start place availability (by numeric ID)
        $prevPackage = null; $nextPackage = null;
        if ($startPlaceId) {
            $prevPackage = EventTemplate::where('is_active', true)
                ->where('id', '<', $eventTemplate->id)
                ->whereHas('startingPlaceAvailabilities', function($q) use ($startPlaceId){
                    $q->where('start_place_id', $startPlaceId)->where('available', true);
                })
                ->orderBy('id', 'desc')
                ->first();
            $nextPackage = EventTemplate::where('is_active', true)
                ->where('id', '>', $eventTemplate->id)
                ->whereHas('startingPlaceAvailabilities', function($q) use ($startPlaceId){
                    $q->where('start_place_id', $startPlaceId)->where('available', true);
                })
                ->orderBy('id', 'asc')
                ->first();
        } else {
            // Fallback global (no start place chosen) - only templates with no start place specific pricing required.
            $prevPackage = EventTemplate::where('is_active', true)
                ->where('id', '<', $eventTemplate->id)
                ->orderBy('id', 'desc')
                ->first();
            $nextPackage = EventTemplate::where('is_active', true)
                ->where('id', '>', $eventTemplate->id)
                ->orderBy('id', 'asc')
                ->first();
        }

        return view('front.package', [
            'eventTemplate' => $eventTemplate,
            'item' => $eventTemplate,
            'start_place_id' => $startPlaceId,
            'prevPackage' => $prevPackage,
            'nextPackage' => $nextPackage,
        ]);
    }

    public function insurance()
    {
        return view('front.insurance');
    }

    public function documents()
    {
        return view('front.documents');
    }

    public function contact()
    {
        return view('front.contact');
    }

    public function sendEmail(Request $request)
    {
    // Walidacja (przykład)
    // ...existing code...
}
    }
