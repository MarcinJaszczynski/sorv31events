@extends('front.layout.master')
@section('main_content')
    <div class="package-page-top">
    <div class="page-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            {{-- <li class="breadcrumb-item"><a href="{{route('home')}}">Start</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('packages') }}">Wycieczki szkolne</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('packages', ['region_id' => 16, 'length_id' => $event->duration_days]) }}">{{ $event->duration_days }}-dniowe</a></li>
                            <li class="breadcrumb-item active">{{ $event->name }}</li> --}}
                            @php
                                // Prefer regionSlug from current pretty URL route param (canonical)
                                $regionSlug = request()->route('regionSlug') ?: 'region';
                                // Fallback ONLY if generic and cookie has specific place
                                if ($regionSlug === 'region') {
                                    $cookieStart = request()->cookie('start_place_id');
                                    if ($cookieStart) {
                                        $placeName = \App\Models\Place::find($cookieStart)?->name;
                                        if ($placeName) { $regionSlug = \Illuminate\Support\Str::slug($placeName); }
                                    }
                                }
                                $daysNumber = $item->duration_days;
                                $daysLabel = $daysNumber . '-dniowe';
                                $packagesUrl = route('packages', ['regionSlug' => $regionSlug]);
                                $packagesDaysUrl = route('packages', ['regionSlug' => $regionSlug, 'length_id' => $daysNumber]);
                            @endphp
                            <li class="breadcrumb-item"><a href="/{{ $regionSlug }}">Start</a></li>
                            <li class="breadcrumb-item"><a href="{{ $packagesUrl }}">Wycieczki szkolne</a></li>
                            <li class="breadcrumb-item"><a href="{{ $packagesDaysUrl }}">{{ $daysLabel }}</a></li>
                            <li class="breadcrumb-item active">{{ $item->name }}</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

    </div>
    </div>

    <div class="package-page-layout pb_50">
        <div class="package-page-arrows pb_20">
            @php $currentStart = $start_place_id ?? request()->cookie('start_place_id'); @endphp
            @if(!empty($prevPackage))
                <a href="{{ $prevPackage->prettyUrl($currentStart ? (int)$currentStart : null) }}">
                    <button class="direction-button"><div class="previous">
                        <i class="fas fa-arrow-left"></i> poprzednia oferta
                    </div></button>
                </a>
            @else
                <button class="direction-button" disabled><i class="fas fa-arrow-left"></i> poprzednia oferta</button>
            @endif

            @if(!empty($nextPackage))
                <a href="{{ $nextPackage->prettyUrl($currentStart ? (int)$currentStart : null) }}">
                    <button class="direction-button"><div class="next">
                        następna oferta <i class="fas fa-arrow-right"></i>
                    </div></button>
                </a>
            @else
                <button class="direction-button" disabled>następna oferta</button>
            @endif
        </div>
        <div class="package-page-border">
        <div class="package-page-layout-section-one">
            <div class="column-left">
                <div class="display-photo">
                    @php
                        $photo = $item->featured_image ?? null;
                    @endphp
                    @if($photo)
                        <img src="{{ asset('storage/' . $photo) }}" alt="{{ $item->name }}">
                    @else
                        <img src="{{ asset('uploads/default.png') }}" alt="Brak zdjęcia">
                    @endif
                </div></div>
            <div class="column-right">
                <div class="title-section">
                    <div class="title">
                        {{ $item->name }}
                    </div>
                    <div class="length">
                        {{ $item->subtitle }}
                    </div>
                    <div class="type">
                        {{ $item->tags->pluck('name')->join(', ') }}
                    </div>
                </div>
                <div class="description-section">
                    <div class="description">
                        {!! $item->event_description !!}
                    </div>
                </div>
                <div class="specifics">
                    <div class="length-section">
                        <div class="icon"><i class="far fa-clock"></i></div>
                        @if($item->duration_days == 1)
                            impreza jednodniowa
                        @else
                            impreza {{ $item->duration_days }}-dniowe
                        @endif
                    </div>
                    <div class="price-section">
                        <div class="icon"><i class="fas fa-money-bill-wave-alt"></i></div>
                        @php
                            // Spójne z kontrolerem: użyj już przefiltrowanej relacji pricesPerPerson (PLN, najnowsze per qty)
                            $minPrice = null;
                            if ($item->pricesPerPerson && $item->pricesPerPerson->count()) {
                                $validPrices = $item->pricesPerPerson->where('price_per_person', '>', 0);
                                if ($validPrices->count() > 0) {
                                    $minPrice = ceil($validPrices->min('price_per_person') / 5) * 5;
                                }
                            }
                            $requestedQty = request('qty') ? (int) request('qty') : null;
                            $qtyNote = null;
                            if ($requestedQty && isset($validPrices) && $validPrices->count() > 0) {
                                $grouped = $validPrices->groupBy('event_template_qty_id')->map(fn($g)=>$g->sortByDesc('id')->first());
                                $qtyToPrice = [];
                                foreach ($grouped as $p) {
                                    $q = optional($p->eventTemplateQty)->qty;
                                    if ($q) $qtyToPrice[(int)$q] = (float) $p->price_per_person;
                                }
                                ksort($qtyToPrice);
                                if (!empty($qtyToPrice)) {
                                    if (isset($qtyToPrice[$requestedQty])) {
                                        $closestQty = $requestedQty;
                                    } else {
                                        $lower = null; $upper = null;
                                        foreach (array_keys($qtyToPrice) as $q) {
                                            if ($q < $requestedQty) $lower = $q;
                                            if ($q > $requestedQty) { $upper = $q; break; }
                                        }
                                        if ($lower === null) $closestQty = $upper;
                                        elseif ($upper === null) $closestQty = $lower;
                                        else $closestQty = ((abs($requestedQty - $lower) <= abs($upper - $requestedQty)) ? $lower : $upper);
                                    }
                                    if (isset($closestQty) && isset($qtyToPrice[$closestQty])) {
                                        $qtyPrice = ceil($qtyToPrice[$closestQty] / 5) * 5;
                                        $qtyNote = $qtyPrice . ' zł dla grupy ' . $closestQty . ' osób';
                                    }
                                }
                            }
                        @endphp
                        od <b>{{ $minPrice ?? '—' }} zł</b> /os.
                        @if($qtyNote)
                            <div style="font-size:12px;color:#666; margin-top:2px;">{{ $qtyNote }}</div>
                        @endif
                    </div>
                    <div class="region-section">
                        <div class="icon"><i class="fas fa-calendar"></i></div>
                        elastyczne terminy
                    </div>
                </div>
                <a href="#contact-scroll"><div class="take-to-contact-button">Zapytaj o tę wycieczkę</div></a>
            </div>
        </div>
            <hr>
        <div class="package-page-layout-section-two">
            <div class="column-left">
                <div class="package-page-schedule-section">
                    <div class="title-section">
                        <div class="title">
                            Program wycieczki:
                        </div>
                        <div class="icon-warning-place">
                            <div class="warning-current-region">
                                <i class="fas fa-info-circle"></i>&nbsp;
                            <div class= "desktop-region-description">Oferta dla wyjazdu z miasta:&nbsp;</div>
                            <div class= "mobile-region-description">Wyjazd z:&nbsp;</div>
                            <div class="current-region-name">
                            @php
                                $currentPlaceName = null;
                                // Prefer explicit start_place_id passed to view
                                if (isset($start_place_id) && $start_place_id) {
                                    $currentPlaceName = optional(\App\Models\Place::find($start_place_id))->name;
                                }
                                // Fallback: derive from regionSlug in URL if not set
                                if (!$currentPlaceName) {
                                    $slugFromRoute = request()->route('regionSlug');
                                    if ($slugFromRoute && $slugFromRoute !== 'region') {
                                        $placeObj = \App\Models\Place::all()->first(function($pl) use ($slugFromRoute){ return str()->slug($pl->name) === $slugFromRoute; });
                                        if ($placeObj) $currentPlaceName = $placeObj->name;
                                    }
                                }
                                // Final fallback label
                                if (!$currentPlaceName) { $currentPlaceName = 'Warszawa'; }
                            @endphp
                            {{ $currentPlaceName }}
                            </div>
                            .
                            </div>
                            <br><br></div>
                    </div>
                    <div class="schedule-days">
                        <div id="itinerary">
            @for ($day = 1; $day <= $item->duration_days; $day++)
                <div class='day-itinerary' id='day-{{ $day }}'>
                    <h3>Dzień {{ $day }}</h3>
                    @php
                        $dayProgram = $item->programPoints
                            ->where('pivot.day', $day)
                            ->sortBy('pivot.order')
                            ->filter(function($p){
                                return (bool)($p->pivot->include_in_program ?? false) && (bool)($p->pivot->active ?? true);
                            });
                    @endphp
                    @if($dayProgram->count() > 0)
                        <ul>
                            @foreach($dayProgram as $point)
                                @php
                                    $titleText = preg_replace('/\s*-?\s*\d+:\d+h?.*$/', '', $point->name);
                                    $showBold = (bool)($point->pivot->show_title_style ?? true);
                                    $showDesc = (bool)($point->pivot->show_description ?? true);
                                @endphp
                                <li>
                                    • @if($showBold)<strong>{{ $titleText }}</strong>@else{{ $titleText }}@endif
                                    @if($showDesc && $point->description)
                                        – <span class="program-point-description">{!! strip_tags($point->description) !!}</span>
                                    @endif

                                    @php
                                        // Dzieci wyświetlamy tylko jeśli rodzic jest w programie
                                        $children = $point->children ?? collect();
                                    @endphp
                                    @if($children->count() > 0)
                                        @php
                                            // Posortowane wg pivot->order w relacji children()
                                            $childrenToShow = $children->filter(function($child) use ($item){
                                                // Pobierz właściwości dziecka dla tego szablonu
                                                $prop = $child->childPropertiesForTemplate($item->id)->first();
                                                return $prop && (bool)($prop->pivot->include_in_program ?? false) && (bool)($prop->pivot->active ?? true);
                                            });
                                        @endphp
                                        @if($childrenToShow->count() > 0)
                                            <ul class="program-children">
                                                @foreach($childrenToShow as $child)
                                                    @php
                                                        $prop = $child->childPropertiesForTemplate($item->id)->first();
                                                        $childTitle = preg_replace('/\s*-?\s*\d+:\d+h?.*$/', '', $child->name);
                                                        $childBold = (bool)($prop->pivot->show_title_style ?? true);
                                                        $childDescFlag = (bool)($prop->pivot->show_description ?? true);
                                                    @endphp
                                                    <li>
                                                        • @if($childBold)<strong>{{ $childTitle }}</strong>@else{{ $childTitle }}@endif
                                                        @if($childDescFlag && $child->description)
                                                            – <span class="program-point-description">{!! strip_tags($child->description) !!}</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>Program do ustalenia...</p>
                    @endif
                </div>
                @if($day < $item->duration_days)
                    <hr>
                @endif
            @endfor
                        </div>
                    </div>
                </div>
                <hr>
                @php
                    $facultativeDay = ($item->duration_days ?? 0) + 1;
                    $facultativeProgram = $item->programPoints
                        ->where('pivot.day', $facultativeDay)
                        ->sortBy('pivot.order')
                        ->filter(function($p){
                            return (bool)($p->pivot->include_in_program ?? false) && (bool)($p->pivot->active ?? true);
                        });
                @endphp
                @if($facultativeProgram->count() > 0)
                    <div class="package-page-facultative-section">
                        <div class="title-section">
                            <div class="title">
                                Fakultatywnie proponujemy:
                            </div>
                        </div>
                        <div class="schedule-days">
                            <div id="facultative-itinerary">
                                <div class='day-itinerary' id='day-facultative'>
                                    <ul>
                                        @foreach($facultativeProgram as $point)
                                            @php
                                                $titleText = preg_replace('/\s*-?\s*\d+:\d+h?.*$/', '', $point->name);
                                                $showBold = (bool)($point->pivot->show_title_style ?? true);
                                                $showDesc = (bool)($point->pivot->show_description ?? true);
                                            @endphp
                                            <li>
                                                • @if($showBold)<strong>{{ $titleText }}</strong>@else{{ $titleText }}@endif
                                                @if($showDesc && $point->description)
                                                    – <span class="program-point-description">{!! strip_tags($point->description) !!}</span>
                                                @endif

                                                @php
                                                    $children = $point->children ?? collect();
                                                @endphp
                                                @if($children->count() > 0)
                                                    @php
                                                        $childrenToShow = $children->filter(function($child) use ($item){
                                                            $prop = $child->childPropertiesForTemplate($item->id)->first();
                                                            return $prop && (bool)($prop->pivot->include_in_program ?? false) && (bool)($prop->pivot->active ?? true);
                                                        });
                                                    @endphp
                                                    @if($childrenToShow->count() > 0)
                                                        <ul class="program-children">
                                                            @foreach($childrenToShow as $child)
                                                                @php
                                                                    $prop = $child->childPropertiesForTemplate($item->id)->first();
                                                                    $childTitle = preg_replace('/\s*-?\s*\d+:\d+h?.*$/', '', $child->name);
                                                                    $childBold = (bool)($prop->pivot->show_title_style ?? true);
                                                                    $childDescFlag = (bool)($prop->pivot->show_description ?? true);
                                                                @endphp
                                                                <li>
                                                                    • @if($childBold)<strong>{{ $childTitle }}</strong>@else{{ $childTitle }}@endif
                                                                    @if($childDescFlag && $child->description)
                                                                        –<span class="program-point-description">{!! strip_tags($child->description) !!}</span>
                                                                    @endif
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="column-right">
                <div class="space-column-right">

                    <div class="collapsible-container" id="price-scroll">
                    <button type="button" class="collapsible">Cennik
                        <span class="toggle-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div class="content price">
                        {{-- Dynamic pricing from database - all available prices --}}
                        @if($item->pricesPerPerson && $item->pricesPerPerson->count() > 0)
                            @php
                                $pricesGrouped = $item->pricesPerPerson
                                    ->where('price_per_person', '>', 0)
                                    ->groupBy('event_template_qty_id')
                                    ->map(function($group){
                                        return $group->sortByDesc('id')->first();
                                    })
                                    ->sortBy(function($p){ return optional($p->eventTemplateQty)->qty; });
                                $keys = $pricesGrouped->map(fn($p)=>optional($p->eventTemplateQty)->qty)->filter()->values()->all();
                                sort($keys);
                                $ranges = [];
                                foreach ($keys as $idx => $q) {
                                    $price = $pricesGrouped->firstWhere('eventTemplateQty.qty', $q);
                                    if (!$price) continue;
                                    $start = (int)$q;
                                    $end = isset($keys[$idx+1]) ? ((int)$keys[$idx+1] - 1) : null;
                                    if ($end !== null && $end >= $start) {
                                        $ranges[] = [
                                            'from' => $start,
                                            'to' => $end,
                                            'price' => ceil(($price->price_per_person)/5)*5,
                                        ];
                                    }
                                }
                                // Dodaj ostatni przedział "40+" (lub największy klucz +)
                                if (count($keys) > 0) {
                                    $lastIdx = count($keys) - 1;
                                    $lastQ = (int)$keys[$lastIdx];
                                    $lastPrice = $pricesGrouped->firstWhere('eventTemplateQty.qty', $lastQ);
                                    if ($lastPrice) {
                                        $ranges[] = [
                                            'from' => $lastQ,
                                            'to' => 55,
                                            'price' => ceil(($lastPrice->price_per_person)/5)*5,
                                        ];
                                    }
                                }
                                $ranges = array_reverse($ranges); // tylko odwrócenie kolejności wyświetlania
                            @endphp
                            @foreach($ranges as $r)
                                <div class="people_price">
                                    <div class="small2">
                                        <div class="price">{{ $r['price'] }} PLN</div>
                                    </div>
                                    <div class="small1">
                                        za osobę dla grupy {{ $r['from'] }}–{{ $r['to'] }} osób
                                    </div>
                                </div>
                            @endforeach
                        @endif
                        <div class="people_price">
                            <div class="small2" style="font-size: 0.8em"><div class="price" style="padding: 0.3em 0.5em"><a href="mailto:rafa@bprafa.pl">zapytaj o ofertę <i class="fas fa-envelope"></i></a></div></div>
                            <div class="small1">dla innej ilości osób</div>
                        </div>
                    </div>
                    </div>

                    <div class="collapsible-container">
                    <button type="button" class="collapsible">W cenie<span class="toggle-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div class="content price-includes">
                        @php
                            // Pobierz opis ceny imprezy przypisany do szablonu (HTML)
                            $priceDescription = optional($item->eventPriceDescription()->first())->description;
                        @endphp
                        @if(!empty($priceDescription))
                            {!! $priceDescription !!}
                        @else
                            <b>Cena zawiera:</b>
                            <ul>
                                {{-- @if($event->duration_days > 1) --}}
                                    <li>zakwaterowanie w pokojach z łazienkami</li>
                                    <li>wyżywienie zgodnie z programem (2 śniadania, 2 obiady, 2 kolacje)</li>
                                {{-- @endif --}}
                                <li>przejazd autokarem</li>
                                <li>opłaty drogowe i parkingowe</li>
                                <li>opiekę pilota na całej trasie wycieczki</li>
                                <li>bilety wstępu do zwiedzanych obiektów</li>
                                <li>realizację programu</li>
                                <li>przewodników lokalnych</li>
                                <li>ubezpieczenie NNW uczestników wycieczki do kwoty 10 000 zł/osoba</li>
                                <li>podatek VAT</li>
                                <li>miejsca gratis dla opiekunów (1 opiekun na 15 uczestników)</li>
                            </ul>
                            <b>Cena nie zawiera:</b>
                            <ul>
                                <li>wydatków własnych</li>
                                <li>punktów programu opisanych i proponowanych jako “Fakultatywne”</li>
                            </ul>
                        @endif
                    </div>
                    </div>

                    <div class="collapsible-container">
                    <button type="button" class="collapsible">Dodatkowe ubezpieczenie<span class="toggle-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div class="content">
                       <ul>
                           <li><b>Ubezpieczenie kosztów rezygnacji:</b><br>
                           Zachęcamy do zawarcia dobrowolnego ubezpieczenia od Kosztów Imprezy Turystycznej (kosztów rezygnacji). Ubezpieczenie takie daje gwarancję zwrotu 100% poniesionych kosztów w przypadku rezygnacji z udziału w wycieczce na skutek następstwa nieszczęśliwego wypadku typu: choroba, pożar domu, śmierć kogoś bliskiego itp. Koszt ubezpieczenia to 3,2% ceny wycieczki. Ubezpieczyć można zarówno całą grupę jak i poszczególnych uczestników indywidualnie. Polisę taką należy wykupić <u>w dniu podpisywania umowy o organizację Imprezy Turystycznej</u> lub jeśli od zawarcia umowy do rozpoczęcia podróży jest więcej niż 30 dni w terminie do 7 dni od dnia zawarcia umowy.</li>
                           <li><b>Choroby przewlekłe:</b><br>
                           Osoby cierpiące na choroby przewlekłe zobowiązane są do wykupienia rozszerzenia polisy ubezpieczeniowej o ryzyko zaostrzenia choroby przewlekłej (dotyczy ubezpieczenia Kosztów Rezygnacji oraz ubezpieczenia Kosztów Leczenia podczas wyjazdów zagranicznych).</li>
                           <li><b>Zwiększenie sumy ubezpieczenia:</b><br>
                           Każdy podróżny ma prawo zawrzeć polisę ubezpieczeniową na sumy wyższe niż gwarantowane w ofercie. Osoby zainteresowane podniesieniem sumy ubezpieczenia proszone są o kontakt z biurem.
                           </li>
                       </ul>
                    </div>
                    </div>

                    <div class="collapsible-container">
                    <button type="button" class="collapsible">Faktura<span class="toggle-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div class="content">
                        <p>Aby otrzymać fakturę za udział w wycieczce prosimy, <b>przed rozpoczęciem imprezy turystycznej</b>, o przesłanie danych za pomocą elektronicznego formularza który znajduje się poniżej. Faktury wystawiane są po zakończeniu imprezy turystycznej i  przesyłane do Państwa drogą elektroniczną.
                        </p>
                        <a href="https://bprafa.pl/wniosek-o-fakture-na-osobe-fizyczna/">Wniosek o fakturę na osobę fizyczną</a><br>
                        <a href="https://bprafa.pl/faktura-na-firme/">Wniosek o fakturę na firmę</a>
                    </div>
                    </div>

                    <div class="collapsible-container" id="contact-scroll">
                    <button type="button" class="collapsible">Dodatkowe informacje<span class="toggle-icon"><i class="fas fa-chevron-down"></i></span></button>
                    <div class="content">
                        <p> <ul>
                            <li>Program jest ramowy – kolejność zwiedzania może ulec zmianie</li>
                            <li>Na życzenie Klienta program może być zmodyfikowany</li>
                            <li>Zapewnienie specjalnej diety może wiązać się z dodatkowymi opłatami</li>
                            <li>Powyższa oferta ma charakter informacyjny i nie stanowi oferty handlowej w rozumieniu ust.66 § 1 Kodeksu Cywilnego</li>
                        </ul>
                        </p>
                    </div>
                    </div>

                    <div class="line"></div>

                    @if(session('success'))
                        <div class="alert alert-success" style="margin: 1em 0; color: green; font-weight: bold;">
                            {{ session('success') }}
                        </div>
                    @endif
                    <form class="contact-form" method="POST" action="{{ route('send-email') }}">
                        @csrf <!-- Laravel CSRF Protection -->
                        <h4>Zapytaj o tę wycieczkę</h4>
                        <label for="name">Imię i nazwisko:</label>
                        <input type="text" name="name" id="name" placeholder="Wpisz imię i nazwisko">
                        <small class="error"></small>

                        <label for="email">Adres email: <span class="required">*</span></label>
                        <input type="text" name="email" id="email" placeholder="Wpisz adres email">
                        <small class="error"></small>

                        <label for="telephone">Numer telefonu: <span class="required">*</span></label>
                        <input type="text" name="telephone" id="telephone" placeholder="Wpisz numer telefonu">
                        <small class="error"></small>

                        <label for="message">Treść wiadomości:</label>
                        <textarea id="message" name="message" rows="6" placeholder="Wpisz treść wiadomości"></textarea>
                        <small class="error"></small>

                        <div class="center">
                            <input type="submit" value="Wyślij">
                            <p id="success"></p>
                        </div>
                    </form>
                    </div>

                </div>
            </div>

            </div>
        </div>
        </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var coll = document.getElementsByClassName("collapsible");
            var i;

        for (var i = 0; i < coll.length; i++) {
            var content = coll[i].nextElementSibling;
            // Otwórz tylko Cennik na starcie, nie ruszaj innych sekcji
            if (content.classList.contains("price")) {
                coll[i].classList.add("active");
                content.classList.add("active");
            }
            coll[i].addEventListener("click", function () {
                var content = this.nextElementSibling;
                this.classList.toggle("active");
                content.classList.toggle("active");
            });
        }
        });
    </script>


@endsection
