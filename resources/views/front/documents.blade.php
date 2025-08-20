@extends('front.layout.master')

@section('main_content')
    <div class="page-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Start</a></li>
                            <li class="breadcrumb-item active">Dokumenty</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="documents-faq-head container pt_50">
        <h1>Dokumenty</h1>
    </div>

    @php
        $documentsSections = [
            'Warunki uczestnictwa' => [
                ['t' => 'Warunki uczestnictwa w imprezach organizowanych przez Biuro Podróży RAFA – do umów zawartych od 01.01.2025', 'f' => 'warunki_uczestnictwa.pdf'],
                ['t' => 'Regulamin przewozu osób autokarem podczas wycieczek organizowanych przez Biuro Podróży RAFA', 'f' => 'regulamin_przewozu.pdf'],
            ],
            'CEIDG, Wpis do rejestru' => [
                ['t' => 'CEIDG', 'f' => 'ceidg.pdf'],
                ['t' => 'Wpis do rejestru Organizatorów Turystyki', 'f' => 'wpis_do_rejestru.pdf'],
            ],
            'Ochrona uczestników' => [
                ['t' => 'Procedury Ochrony Małoletnich/Dzieci Podczas Wycieczek Organizowanych Przez Biuro Podróży „RAFA”', 'f' => 'procedury_ochrony.pdf'],
                ['t' => 'Polityka RODO', 'f' => 'polityka_rodo.pdf'],
            ],
            'Ustawy' => [
                ['t' => 'Ustawa o imprezach turystycznych', 'f' => 'ustawa_imprezy_turystyczne.pdf'],
                ['t' => 'Standardowy Formularz Informacyjny', 'f' => 'formularz_informacyjny.pdf'],
            ],
        ];
        function docSize($p){ if(!file_exists($p)) return null; $s=filesize($p); $u=['B','KB','MB','GB']; for($i=0;$s>=1024&&$i<count($u)-1;$i++)$s/=1024; return round($s,($i?1:0)).' '.$u[$i]; }
    @endphp

    <div class="documents-sections docs-centered">
        @foreach($documentsSections as $sectionTitle => $docs)
            <section class="docs-section">
                <h2 class="docs-section-title">{{ $sectionTitle }}</h2>
                <div class="docs-grid">
                    @foreach($docs as $idx => $doc)
                        @php
                            $file = $doc['f'];
                            $url = asset('uploads/documents/'.$file);
                            $ext = strtoupper(pathinfo($file, PATHINFO_EXTENSION));
                        @endphp
                        <article class="doc-item-block no-line">
                            <div class="doc-left">
                                <div class="doc-icon" aria-hidden="true"><i class="fas fa-file-pdf"></i></div>
                            </div>
                            <div class="doc-content">
                                <h3 class="doc-title">{{ $doc['t'] }}</h3>
                                {{-- usunięto tag PDF zgodnie z wymaganiem --}}
                                <div class="doc-actions">
                                    <a class="doc-btn" href="{{ $url }}" target="_blank" rel="noopener">POBIERZ</a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endforeach
    </div>

@endsection
