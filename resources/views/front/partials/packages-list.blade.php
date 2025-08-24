@php
    $regionSlugForLinks = 'region';
    if(isset($start_place_id) && $start_place_id){
        $__placeName = \App\Models\Place::where('id',$start_place_id)->value('name');
        if($__placeName){
            $regionSlugForLinks = \Illuminate\Support\Str::slug($__placeName);
        }
    }
@endphp
@foreach($eventTemplate as $item)
    <div class="item pb_25">
        <div class="package-box">
            <div class="package-box-layout">
                <div
                    class="package-box-photo"
                    style="background-image: url({{ asset('storage/' . ($item->featured_image ?? '')) }}); cursor: pointer;"
                    @php
                        $__baseUrl = route('package.pretty', [
                            'regionSlug' => $regionSlugForLinks,
                            'dayLength' => $item->duration_days . '-dniowe',
                            'id' => $item->id,
                            'slug' => $item->slug,
                        ]);
                        // start_place_id parameter removed from URL; slug determines region.
                    @endphp
                    onclick="window.location.href='{{ $__baseUrl }}';">
                </div>
                <div class="package-box-name-mobile">
                    <a href="{{ $__baseUrl }}">{{ $item->name }}</a></div>
                <div class="package-box-info">
                    <div class="left">
                        <div class="package-box-name">
                            <a href="{{ route('package.pretty', [
                                    'regionSlug' => $regionSlugForLinks,
                                    'dayLength' => $item->duration_days . '-dniowe',
                                    'id' => $item->id,
                                    'slug' => $item->slug,
                                ]) }}">{{ $item->name }}</a>
                            @if($item->subtitle)
                                <div class="package-box-subtitle">{{ $item->subtitle }}</div>
                            @endif
                        </div>
                        <div class="package-box-small-info">
                            <div class="package-box-time">
                                <i class="fas fa-clock"></i> {{ $item->duration_days }} dni
                            </div>
                        </div>
                        <div class="package-box-positioning-graphic-info"></div>
                        <div class="package-box-graphic-info">
                            <div class="amenity-title">Tagi:</div>

                            <div class="package-box-tags">
                                @php
                                    // Fallback: jeśli relacja 'tags' nie została załadowana, dociągnij ją (minimalnie) – chroni przed N+1 jeśli zwykle eager loaded.
                                    if (!method_exists($item, 'tags')) {
                                        $loadedTags = collect();
                                    } else {
                                        if (!$item->relationLoaded('tags') || $item->tags === null) {
                                            // Ostrożnie: pojedyncze zapytanie – akceptowalne jako fallback.
                                            $item->setRelation('tags', $item->tags()->get());
                                        }
                                        $loadedTags = $item->tags;
                                    }
                                @endphp
                                @if ($loadedTags && $loadedTags->isNotEmpty())
                                    @php $tagsBase = route('packages', ['regionSlug' => $regionSlugForLinks]); @endphp
                                    @foreach ($loadedTags as $tag)
                                        @php $tSlug = \Illuminate\Support\Str::slug($tag->name); $tUrl = $tagsBase . '?tag=' . $tSlug; @endphp
                                        <a href="{{ $tUrl }}" class="badge-tag">{{ $tag->name }}</a>
                                    @endforeach
                                @else
                                    {{-- Brak tagów --}}
                                @endif
                            </div>
                        </div>
                        </div>
                    <div class="right">
                        <div class="price-2-boxes">
                        <div class="package-box-actual-price">
                            @php
                                // 'od …' zawsze jako najniższa dostępna cena z przefiltrowanych cen
                                $displayPrice = null;
                                if ($item->pricesPerPerson && $item->pricesPerPerson->count()) {
                                    $validPrices = $item->pricesPerPerson->where('price_per_person', '>', 0);
                                    if ($validPrices->count() > 0) {
                                        $displayPrice = ceil($validPrices->min('price_per_person') / 5) * 5;
                                    }
                                }
                            @endphp
                            od <b>{{ $displayPrice ?? '—' }} zł</b> /os.
                        </div>
                        @php
                            // Dodatkowo: pokaż cenę dla zadanej liczby osób (requestedQty), jeśli policzona/computed_price bazuje na najbliższym progu
                            $qtyNote = null;
                            if (isset($requestedQty) && $requestedQty) {
                                // spróbuj znaleźć najbliższy próg i cenę dla niego
                                $qtyToPrice = [];
                                if ($item->pricesPerPerson && $item->pricesPerPerson->count()) {
                                    // grupy per qty (najnowsza po id)
                                    $grouped = $item->pricesPerPerson
                                        ->where('price_per_person', '>', 0)
                                        ->groupBy('event_template_qty_id')
                                        ->map(function($group){ return $group->sortByDesc('id')->first(); })
                                        ->values();
                                    foreach ($grouped as $price) {
                                        $q = optional($price->eventTemplateQty)->qty;
                                        if ($q) $qtyToPrice[(int)$q] = (float) $price->price_per_person;
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
                                            // Preferuj mniejszy próg (lower). Gdy brak mniejszego – bierz najmniejszy większy (upper)
                                            if ($lower !== null) $closestQty = $lower;
                                            else $closestQty = $upper; // może pozostać null, gdy brak danych
                                        }
                                        if (isset($closestQty) && isset($qtyToPrice[$closestQty])) {
                                            $qtyPrice = ceil($qtyToPrice[$closestQty] / 5) * 5;
                                            $qtyNote = '(' . $qtyPrice . ' zł/os. dla grupy ' . $closestQty . ' osób)';
                                        }
                                    }
                                }
                            }
                        @endphp
                        @if($qtyNote)
                            <div style="margin-top:4px; font-size: 12px; color:#666;">{{ $qtyNote }}</div>
                        @endif
                    <div class="package-box-price">
                        <a href="{{ route('package.pretty', [
                                'regionSlug' => $regionSlugForLinks,
                                'dayLength' => $item->duration_days . '-dniowe',
                                'id' => $item->id,
                                'slug' => $item->slug,
                            ]) }}">Pokaż ofertę</a>
                    </div>
                        </div>
                    </div></div>
                </div>
            </div>
        </div>
@endforeach
