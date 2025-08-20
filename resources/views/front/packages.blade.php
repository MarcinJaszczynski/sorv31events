{{-- @php use App\Models\PackageAmenity;
 use App\Models\Amenity;
 use App\Models\Package; @endphp --}}
@extends('front.layout.master')
@section('main_content')

    <div class="page-top">
        <div class="container">
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/{{ $current_region_slug ?? 'region' }}">Start</a></li>
                            <li class="breadcrumb-item active">Wycieczki szkolne</li>
                        </ol>
                    </div>
                </div>
            </div>

    <div class="package pt_20 pb_50">
        </style>
        <div class="region-information">
            <div class="text">
                Pokaż ofertę dla:
            <script>
                function autoSubmit() {
                    document.getElementById("regionForm").submit();
                }
            </script>
                {{-- <form name="regionForm" id="regionForm" action="{{ route('packages') }}" method="get"> --}}
                <form name="regionForm" id="regionForm" action="/{{ request()->route('regionSlug') }}/packages" method="get">
                    <div class="select-form-div">
                        <select name="start_place_id" id="start_place_id_top" class="form-select-region-information">
                            @if(isset($startPlaces))
                                @foreach($startPlaces as $place)
                                    @php $slug = \Illuminate\Support\Str::slug($place->name); @endphp
                                    <option value="{{ $place->id }}" data-slug="{{ $slug }}" @if($start_place_id == $place->id) selected @endif>{{ $place->name }} i okolice</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </form>

                <div class="icon"><i class="fas fa-info-circle"></i>
                <div class="explanation">
                    Prosimy o wybranie miasta opowiadającego miejscu wyjazdu lub miasta, które znajduje się najbliżej.
                </div>
            </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="sidebars col-lg-3 col-md-4 col-xs-1 mb-5" style="padding-right: 30px">
                    <div id="filter-show" class="mobile-filter-button">
                        <div class="show"><i class="fas fa-filter"></i> Pokaż filtry</div>
                    </div>

                    <!-- move this to another file -->
                    <script>
            function toggleFilters() {
                            var div = document.getElementById('filters');
                            var filterShowDiv = document.getElementById('filter-show');

                            // Toggle visibility of filters
                            if (div.style.display !== 'block') {
                                div.style.display = 'block';
                filterShowDiv.innerHTML = '<div class="show"><i class="fas fa-filter"></i> Ukryj filtry</div>';
                            } else {
                                div.style.display = 'none';
                filterShowDiv.innerHTML = '<div class="show"><i class="fas fa-filter"></i> Pokaż filtry</div>';
                            }
                        }

                        function updateFiltersDisplay() {
                            var div = document.getElementById('filters');
                            const viewportWidth = window.innerWidth;
                            var filterShowDiv = document.getElementById('filter-show');

                            if (viewportWidth < 798) {
                                // Ensure that the toggle button works only when the screen is small
                                if (!filterShowDiv.onclick) {
                                    filterShowDiv.onclick = toggleFilters; // Assign onclick if not already assigned
                                }

                                // Hide the filters when screen is small
                                if (div.style.display !== 'block') {
                                    div.style.display = 'none';
                                }
                            } else {
                                // Show the filters when the screen is large enough
                                div.style.display = 'block';

                                // Remove onclick listener when the screen is large
                                if (filterShowDiv.onclick) {
                                    filterShowDiv.onclick = null;
                                }
                            }
                        }

                        // Call once on page load to initialize everything
                        window.onload = function() {
                            updateFiltersDisplay();
                        }

                        // Attach resize event to handle window resizing
                        window.addEventListener('resize', function() {
                            updateFiltersDisplay();  // Call update on resize
                            // Re-attach the toggleFilters in case it's missing after resizing
                            if (window.innerWidth < 798 && !document.getElementById('filter-show').onclick) {
                                document.getElementById('filter-show').onclick = toggleFilters;
                            }
                        });

                    </script>

                    <div id="filters" class="package-sidebar filters-compact">
                        {{-- <form action="{{ route('packages') }}" method="get"> --}}
                        <form id="sidebarFilterForm" action="/{{ request()->route('regionSlug') }}/packages" method="get">
                            <div class="widget">
                                <h2>Pokaż ofertę dla</h2>
                                <div class="box">
                                    <select name="start_place_id" id="start_place_id_sidebar" class="form-select">
                                        @if(isset($startPlaces))
                                            @foreach($startPlaces as $place)
                                                @php $slug = \Illuminate\Support\Str::slug($place->name); @endphp
                                                <option value="{{ $place->id }}" data-slug="{{ $slug }}" @if($start_place_id == $place->id) selected @endif>{{ $place->name }} i okolice</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
<script>
// Helper: set cookie
function setCookie(name, value, days) {
    var expires = "";
    if (days) {
        var date = new Date();
        date.setTime(date.getTime() + (days*24*60*60*1000));
        expires = "; expires=" + date.toUTCString();
    }
    document.cookie = name + "=" + (value || "")  + expires + "; path=/";
}

// Helper: get cookie
function getCookie(name) {
    var nameEQ = name + "=";
    var ca = document.cookie.split(';');
    for(var i=0;i < ca.length;i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1,c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
    }
    return null;
}

// Save start_place_id to cookie
function saveStartPlaceId(val) {
    setCookie('start_place_id', val, 30);
}

function syncStartPlaceSelects(newVal) {
    const top = document.getElementById('start_place_id_top');
    const side = document.getElementById('start_place_id_sidebar');
    if (top && top.value !== newVal) top.value = newVal;
    if (side && side.value !== newVal) side.value = newVal;
}

// On page load: save current start_place_id to cookie only if backend used default Warszawa
document.addEventListener('DOMContentLoaded', function() {
    const serverVal = '{{ $start_place_id }}';
    const cookieVal = getCookie('start_place_id');
    // Jeżeli cookie różni się od wartości serwera (slug wybrany), nadpisujemy cookie i selecty wartością serwera
    if (cookieVal !== serverVal) {
        setCookie('start_place_id', serverVal, 30);
        syncStartPlaceSelects(serverVal);
    } else {
        syncStartPlaceSelects(serverVal);
    }
    @if($usedDefaultWarszawa)
        setCookie('start_place_id', serverVal, 30);
    @endif

    const top = document.getElementById('start_place_id_top');
    const side = document.getElementById('start_place_id_sidebar');
    function onChange(e){
        const select = e.target;
        const val = select.value;
        const slug = select.options[select.selectedIndex].getAttribute('data-slug') || 'region';
        // Aktualizacja od razu
        syncStartPlaceSelects(val);
        setCookie('start_place_id', val, 30);
        // Zbuduj query bez start_place_id
        const form = document.getElementById('sidebarFilterForm');
        const params = new URLSearchParams(new FormData(form));
        params.delete('start_place_id');
        const qs = params.toString();
        const target = '/' + slug + '/packages' + (qs ? ('?' + qs) : '');
        window.location.replace(target);
    }
    if (top) top.addEventListener('change', onChange);
    if (side) side.addEventListener('change', onChange);
});
</script>
                            <div class="widget">
                                <h2>Sortuj według</h2>
                                <div class="box">
                                    <select name="sort_by" class="form-select">
                                        <option value="">Domyślne sortowanie</option>
                                        <option value="price_asc" @if(request('sort_by') == 'price_asc') selected @endif>Cena: od najniższej</option>
                                        <option value="price_desc" @if(request('sort_by') == 'price_desc') selected @endif>Cena: od najwyższej</option>
                                        <option value="name_asc" @if(request('sort_by') == 'name_asc') selected @endif>Alfabetycznie A-Z</option>
                                        <option value="name_desc" @if(request('sort_by') == 'name_desc') selected @endif>Alfabetycznie Z-A</option>
                                    </select>
                                </div>
                            </div>
                            <div class="widget">
                                <h2>Długość wycieczki</h2>
                                <div class="box">
                                    <select name="length_id" class="form-select">
                                        <option value="">Wszystkie długości</option>
                                        <option value="1" @if(request('length_id') == '1') selected @endif>1 dzień</option>
                                        <option value="2" @if(request('length_id') == '2') selected @endif>2 dni</option>
                                        <option value="3" @if(request('length_id') == '3') selected @endif>3 dni</option>
                                        <option value="4" @if(request('length_id') == '4') selected @endif>4 dni</option>
                                        <option value="5" @if(request('length_id') == '5') selected @endif>5 dni</option>
                                        <option value="6plus" @if(request('length_id') == '6plus') selected @endif>6 dni i więcej</option>
                                    </select>
                                </div>
                            </div>
                        <div class="widget">
                            <h2>Cena</h2>
                            <div class="box">
                                <div class="row">
                                    <div class="col-md-6">
                                        {{-- <input type="text" name="min_price" class="form-control" placeholder="Min" value="{{ $form_min_price }}"> --}}
                                        <input type="text" name="min_price" class="form-control" placeholder="Min" value="">
                                    </div>
                                    <div class="col-md-6">
                                        {{-- <input type="text" name="max_price" class="form-control" placeholder="Max" value="{{ $form_max_price }}"> --}}
                                        <input type="text" name="max_price" class="form-control" placeholder="Max" value="">
                                    </div>
                                </div>
                            </div>
                        </div>
<div class="widget">
    <h2>Kierunek</h2>
    <div class="box">
        <input type="text" name="destination_name" id="destination_name" class="form-control" placeholder="Wpisz kierunek" value="{{ request('destination_name', '') }}">
    </div>
</div>
                            <div class="widget">
                                <h2>Typ wycieczki</h2>
                                <div class="box">
                                    <select name="event_type_id" class="form-select">
                                        <option value="">Wszystkie typy wycieczek</option>
                                        @if(isset($eventTypes))
                                            @foreach($eventTypes as $eventType)
                                                <option value="{{ $eventType->id }}" @if(request('event_type_id') == $eventType->id) selected @endif>{{ $eventType->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="widget">
                                <h2>Środek transportu</h2>
                                <div class="box">
                                    <select name="transport_id" class="form-select">
                                        <option value="">Wszystkie środki transportu</option>
                                        {{-- @foreach($transports as $transport)
                                            <option value="{{ $transport->id }}" @if($form_transport_id == $transport->id) selected @endif>{{ $transport->name }}</option>
                                        @endforeach --}}
                                        <option value="1">Autokar</option>
                                        <option value="2">Autobus</option>
                                        <option value="3">Pociąg</option>
                                        <option value="4">Samolot</option>
                                        <option value="5">Własny transport</option>
                                    </select>
                                </div>
                            </div>
                        <div class="filter-button">
                            <button type="submit" class="btn btn-primary">Filtruj</button>
                        </div>
                    </form>
                    </div>
                </div>


                 <div class="col-lg-9 col-md-8 col-xs-1">
                    <div id="packages-results">
                        @include('front.partials.packages-list', [
                            'eventTemplate' => $eventTemplate,
                            'requestedQty' => request('qty') ? (int) request('qty') : null,
                            'start_place_id' => $start_place_id ?? null,
                        ])
                    </div>
                    <div id="packages-loading" style="display:none; padding: 8px 0; color:#666;">
                        Szukam wycieczek…
                    </div>
                </div>


    </div>
@endsection

@push('scripts')
<script>
// Debounced live search for destination_name
(function() {
    var debounceTimer = null;
    var input = document.getElementById('destination_name');
    var qtyInput = document.getElementById('qty');
    var results = document.getElementById('packages-results');
    var loading = document.getElementById('packages-loading');
    var lengthSelect = document.querySelector('select[name="length_id"]');
    var sortSelect = document.querySelector('select[name="sort_by"]');
    var startPlaceSelect = document.getElementById('start_place_id_sidebar') || document.getElementById('start_place_id_top');
    var eventTypeSelect = document.querySelector('select[name="event_type_id"]');
    var minPriceInput = document.querySelector('input[name="min_price"]');
    var maxPriceInput = document.querySelector('input[name="max_price"]');

    function buildQuery() {
        var params = new URLSearchParams();
        if (input && input.value) params.set('destination_name', input.value);
        if (lengthSelect && lengthSelect.value) params.set('length_id', lengthSelect.value);
        if (sortSelect && sortSelect.value) params.set('sort_by', sortSelect.value);
        if (startPlaceSelect && startPlaceSelect.value) params.set('start_place_id', startPlaceSelect.value);
        if (eventTypeSelect && eventTypeSelect.value) params.set('event_type_id', eventTypeSelect.value);
    if (minPriceInput && minPriceInput.value) params.set('min_price', minPriceInput.value);
    if (maxPriceInput && maxPriceInput.value) params.set('max_price', maxPriceInput.value);
    if (qtyInput && qtyInput.value) params.set('qty', qtyInput.value);
        return params.toString();
    }

    function fetchResults() {
        var qs = buildQuery();
        loading.style.display = 'block';
    fetch('/{{ $current_region_slug ?? 'region' }}/packages/partial' + (qs ? ('?' + qs) : ''))
            .then(function(r){ return r.text(); })
            .then(function(html){
                results.innerHTML = html;
            })
            .catch(function(){ /* silent */ })
            .finally(function(){ loading.style.display = 'none'; });
    }

    function debouncedFetch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(fetchResults, 400);
    }

    if (input) {
        input.addEventListener('input', debouncedFetch);
    }
    if (qtyInput) qtyInput.addEventListener('input', debouncedFetch);
    if (minPriceInput) minPriceInput.addEventListener('input', debouncedFetch);
    if (maxPriceInput) maxPriceInput.addEventListener('input', debouncedFetch);
    if (lengthSelect) lengthSelect.addEventListener('change', fetchResults);
    if (sortSelect) sortSelect.addEventListener('change', fetchResults);
    if (startPlaceSelect) startPlaceSelect.addEventListener('change', fetchResults);
    if (eventTypeSelect) eventTypeSelect.addEventListener('change', fetchResults);
})();
</script>
@endpush
