@extends('front.layout.master')

@section('main_content')
    <div class="container package-page-layout package-page-border pt_80">
        <div class="destination">
            <h2 class="destination_question">Wyszukaj swoją wycieczkę szkolną!</h2>
            {{-- TODO: Convert back to dynamic form with action="{{ route('packages') }}" method="get" --}}
            <form class="destination_search" action="{{ route('packages') }}" method="get">
                <div class="layout">
                    <div class="mobile-destination-from">
                        <div class="destination_from">
                            <div class="destination_from_select_option">
                                <select name="start_place_id" id="start_place_id_select" class="destination_from_select_form" required onchange="saveStartPlaceId(this.value)">
                                    <option class="where_from" id="where_from_option" value="" disabled>Skąd? *</option>
                                    @if(isset($startPlaces))
                                        @foreach($startPlaces as $place)
                                            <option value="{{ $place->id }}">{{ $place->name }} i okolice</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="destination_from_search">
                            </div>
                        </div>
                        <div class="icon"><i class="fas fa-info-circle"></i>
                            <div class="explanation">
                                Prosimy o wybranie miasta opowiadającego miejscu wyjazdu lub miasta, które znajduje się najbliżej.
                            </div>
                        </div>
                    </div>
                    <div class="mobile-destination-length">
                        <div class="destination_length_select_option">
                            <select name="length_id" class="destination_length_select_form">
                                <option value="">Wszystkie długości</option>
                                <option value="1" @if(request('length_id') == '1') selected @endif>1 dzień</option>
                                <option value="2" @if(request('length_id') == '2') selected @endif>2 dni</option>
                                <option value="3" @if(request('length_id') == '3') selected @endif>3 dni</option>
                                <option value="4" @if(request('length_id') == '4') selected @endif>4 dni</option>
                                <option value="5" @if(request('length_id') == '5') selected @endif>5 dni</option>
                                <option value="6plus" @if(request('length_id') == '6plus') selected @endif>6 dni i więcej</option>
                            </select>
                            <div class="destination_from_search">
                            </div>
                        </div>
                        <div class="icon"><i class="fas fa-info-circle"></i>
                            <div class="explanation">
                                Wyszukaj wycieczki o wszystkich możliwych długościach lub wybierz konkretną ilość dni.
                            </div>
                        </div>
                    </div>
                    <div class="mobile-question-where">
                        <div class="destination_where_ask_frame">
                            <input type="text" name="destination_name" class="form-control destination_where_ask" placeholder="Dokąd?" value="{{ request('destination_name', '') }}">
                        </div>
                        <div class="icon"><i class="fas fa-info-circle"></i>
                            <div class="explanation">
                               Wpisanie kierunek wycieczki zawęzi wyniki tylko do tej destynacji. Pozostaw to pole puste, by zobaczyć wszystkie dostępne wyjazdy.
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="destination_search_button">Szukaj</button>
                </div>
            </form>
        </div>

        <script>
            const destinationFrom = document.querySelector('.destination_from');
            const destinationFromSelectOption = document.querySelector('.destination_from_select_option');
            const soValue = document.querySelector('#soValue');
            const optionSearch = document.querySelector('#optionSearch');
            const destinationFromOptions = document.querySelector('.destination_from_options');
            const destinationFromOptionsList = document.querySelectorAll('.destination_from_options li');

            if (destinationFromSelectOption) {
                destinationFromSelectOption.addEventListener('click',function(){
                    destinationFrom.classList.toggle('active');
                });
            }

            if (destinationFromOptionsList.length > 0) {
                destinationFromOptionsList.forEach(function(destinationFromOptionsListSingle){
                    destinationFromOptionsListSingle.addEventListener('click',function(){
                        text = this.textContent;
                        if (soValue) soValue.value = text;
                        if (destinationFrom) destinationFrom.classList.remove('active');
                    })
                });
            }

            if (optionSearch && destinationFromOptions) {
                optionSearch.addEventListener('keyup',function(){
                    var filter, li, i, textValue;
                    filter = optionSearch.value.toUpperCase();
                    li = destinationFromOptions.getElementsByTagName('li');
                    for(i = 0; i < li.length; i++){
                        liCount = li[i];
                        textValue = liCount.textContent || liCount.innerText;
                        if(textValue.toUpperCase().indexOf(filter) > -1){
                            li[i].style.display = '';
                        }else{
                            li[i].style.display = 'none';
                        }
                    }
                });
            }


        </script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var select = document.getElementById('start_place_id_select');
            var whereFromOption = document.getElementById('where_from_option');
            var cookieVal = getCookie('start_place_id');
            if (cookieVal && select) {
                select.value = cookieVal;
                if (whereFromOption) whereFromOption.style.display = 'none';
            } else {
                if (whereFromOption) whereFromOption.style.display = '';
                if (select) select.value = '';
            }
        });
        </script>



        <script>
            let select = document.getElementById("select")
            let list = document.getElementById("list")
            let selectText = document.getElementById("selectText")
            let destination_options = document.getElementsByClassName("destination_options")

            if (select && list) {
                select.onclick = function(){
                    list.classList.toggle("open");
                };
            }

            if (destination_options.length > 0 && selectText) {
                for(destination_option of destination_options){
                    destination_option.onclick = function (){
                        selectText.innerHTML = this.innerHTML;
                    }
                }
            }

        </script>

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
                console.log('Saved start_place_id to cookie:', val);
            }
        </script>

                    </div>

    <div class="container pt_70">
        <div class="carousel-header"><h2>Polecane wycieczki szkolne</h2></div>
    <div class="carousel">
        <div id="carouselExampleControls" class="carousel carousel-dark slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach($random_chunks as $index => $chunk)
                    <div class="carousel-item @if($index == 0) active @endif">
                        <div class="card-wrapper">
                            @foreach($chunk as $item)
                                <div class="card">
                                    <div class="image-wrapper">
                                        <img src="{{ asset('storage/' . ($item->featured_image ?? '')) }}" class="card-img-top" alt="...">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $item->name }}</h5>
                                        <div class="card-text">
                                            <div class="price"><i class="far fa-clock"></i>&nbsp&nbsp{{ $item->length->name }}</div>
                                            <div class="price" id="price-accent">
                                                @php
                                                    $displayPrice = null;
                                                    if (isset($item->computed_price) && $item->computed_price !== null) {
                                                        $displayPrice = ceil($item->computed_price / 5) * 5;
                                                    } elseif($item->relationLoaded('pricesPerPerson') && $item->pricesPerPerson->count()) {
                                                        $valid = $item->pricesPerPerson->where('price_per_person', '>', 0);
                                                        if ($valid->count()) {
                                                            $displayPrice = ceil($valid->min('price_per_person') / 5) * 5;
                                                        }
                                                    }
                                                @endphp
                                                od&nbsp;<b>{{ $displayPrice ?? '—' }} zł</b>&nbsp;/os.
                                            </div>
                                        </div>
                                        <a href="{{ $item->prettyUrl() }}" class="offer">Pokaż ofertę</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div></div>

    <div class="container pt_70">
        <div class="redirect-set">
        <div class="redirect-documents-buttons">
            <div class="redirect-header"><h2>Dokumenty<br></h2></div>
            <div class="documents-button">
                <div class="together">
                    &nbsp;Przejdź do najważniejszych dokumentów&nbsp;<a href="{{ route('documents') }}" class="redirect-arrow"><i class="fas fa-arrow-right"></i></a></div>
            </div>
            <div class="redirect-header"><h2>Ubezpieczenia<br></h2></div>
            <div class="insurance-button">
                <div class="together">
                    &nbsp;Przejdź do szczegółów ubezpieczeń&nbsp;<a href="{{ route('insurance') }}" class="redirect-arrow"><i class="fas fa-arrow-right"></i></a></div>
            </div>

        </div>
        <div class="redirect-decoration-photo"><img src="{{ asset('uploads/131Szlakiem Zamków Krzyżackich.webp') }}" alt="Szlakiem Zamków Krzyżackich"></div>
        </div>
    </div>

    <style>
    .blog.pt_70 .item.pb_70 {
        display: flex;
        flex-direction: column;
        height: 100%;
    }
    .blog.pt_70 .photo {
        flex-shrink: 0;
    }
    .blog.pt_70 .text {
        display: flex;
        flex-direction: column;
        flex: 1 1 auto;
        min-height: 0;
    }
    .blog.pt_70 .short-des {
        flex: 1 1 auto;
        min-height: 0;
        display: flex;
        align-items: flex-start;
    }
    .blog.pt_70 .button-style-2.mt_5 {
        margin-top: auto;
    }

    /* Responsywność: na mobile .item height:auto */
    @media (max-width: 767.98px) {
        .blog.pt_70 .item.pb_70 {
            height: auto;
        }
    }
    </style>


<div class="banner" style="position: relative; width: 100vw; padding-top: 0 !important;">
    <div class="home-banner-bg"></div>
    <div class="home-banner-overlay"></div>
    <div class="container" style="margin-top: 70px; position: relative; z-index: 2;">
        <div class="details">
            <h2>Wycieczki szkolne, które tworzą wspomnienia na całe życie!</h2>
            <p>Biuro Podroży RAFA specjalizuje się w organizacji wycieczek szkolnych, które łączą przygodę, naukę i rozwój. Niezależnie od tego, czy wybierasz wyjazd krajowy, czy zagraniczny - zapewniamy profesjonalną obsługę, bezpieczeństwo oraz niezapomniane wrażenia. Z nami każda podróż to krok ku nowym doświadczeniom!</p>
        </div>
        <div class="buttons">
            <a href="{{ route('packages') }}" class="link_button">Sprawdź ofertę</a>
        </div>
    </div>
</div>
    </div>

    <div class="blog pt_70">
        <div class="container ">
            <div class="row">
                <div class="col-md-12">
                    <div class="heading">
                        <h2>Aktualności</h2>
                        <p>
                            Ostatnie wpisy i aktualności z naszego bloga
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($blogPosts->count() > 0)
                    @foreach($blogPosts as $index => $post)
                        <div class="col-lg-4 col-md-6 {{ $index >= 2 ? 'd-none d-lg-block' : '' }}">
                            <div class="item pb_70">
                                <div class="photo">
                                    @if($post->featured_image)
                                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" />
                                    @else
                                        <img src="{{ asset('uploads/blog-placeholder.jpg') }}" alt="{{ $post->title }}" />
                                    @endif
                                </div>
                                <div class="text">
                                    <h2>
                                        <a href="{{ route('blog.post', $post->slug) }}">{{ $post->title }}</a>
                                    </h2>
                                    <div class="short-des">
                                        <p>
                                            @if($post->excerpt)
                                                {{ $post->excerpt }}
                                            @else
                                                {{ Str::limit(strip_tags($post->content), 150) }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="button-style-2 mt_5">
                                        <a href="{{ route('blog.post', $post->slug) }}">Czytaj dalej</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-lg-12">
                        <p class="text-center">Brak aktualności do wyświetlenia.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="container pt_70">
    <div class="description">
        <div class="first-illustration">
            <div class="first-box">
                <div class="title"><h2 style="font-weight: 700">Biuro Podróży RAFA</h2></div>
                <div class="intro">
                    <div class="intro-1"> Wycieczki Szkolne i Wyjazdy Grupowe</div><div class="intro-2">&nbsp;z całej Polski</div>
                </div>
                <div class="intro-a"><p><div style="font-size: larger"><b>Witamy na stronie Biura Podróży RAFA – profesjonalnego organizatora wycieczek szkolnych, wyjazdów integracyjnych i wycieczek edukacyjnych w Polsce i za granicą.</b></div><p><br> Jako doświadczony lider w branży turystycznej, oferujemy kompleksową obsługę wycieczek ze wszystkich województw.<br>Z nami każda podróż staje się niezapomnianą przygodą!</p></div>
            </div>
            <div class="illustration" >
                <img src="{{ asset('uploads/description-illustration.svg')}}" alt=""> </div>
            </div>


        <div class="second-box">
            <div class="offer"><p><div style="font-size: larger"><b>Nasza oferta obejmuje szeroką gamę wyjazdów szkolnych, które łączą edukację z rozrywką.</b></div><p><br> Proponujemy wycieczki <b>1-dniowe, 2-dniowe, 3-dniowe oraz 5-dniowe</b>, a także <b>zagraniczne wycieczki szkolne</b> do popularnych europejskich destynacji, takich jak <b>Praga, Berlin, Wiedeń</b> czy <b>Paryż</b>. Organizujemy wyjazdy dla grup <b>z całej Polski.</b></p>
                <ul><b>Nasza oferta</b> <li><b>Wycieczki szkolne w Polsce</b> – odkryj Polskę z Biurem Podróży RAFA! Organizujemy wyjazdy do najpiękniejszych polskich miast, takich jak Kraków, Zakopane, Gdańsk czy Wrocław.</li>
                    <li><b>Wycieczki zagraniczne</b> – planujesz wyjazd do Europy? Wybierz wycieczkę do Pragi, Berlina, Paryża, Londynu, czy Rzymu. Z nami zwiedzisz najlepsze miejsca i poznasz ciekawe historie.</li>
                    <li><b>Wycieczki tematyczne</b> – organizujemy również wyjazdy tematyczne, takie jak wycieczki edukacyjne, wyjazdy integracyjne, czy obozy językowe. Z nami uczniowie poszerzą swoją wiedzę i zdobędą nowe umiejętności.</li></ul>
            <div class="link"><a href="{{ route('packages') }}"> <i class="fas fa-arrow-circle-right"></i></a></div>
            </div>
            <div class="why"><p></p><div style="font-size: larger">
                    <b>Dlaczego warto wybrać Biuro Podróży RAFA?</b></div><br><ul>
                    <li><b>Kompleksowa organizacja wycieczek</b> – zapewniamy transport, zakwaterowanie oraz profesjonalnych przewodników.</li>
                    <li><b>Bezpieczeństwo i opieka</b> – dbamy o komfort i bezpieczeństwo uczestników wyjazdów, oferując stałą opiekę doświadczonych nauczycieli i przewoźników.</li>
                    <li><b>Atrakcyjne ceny</b> – nasze wycieczki są dostosowane do różnych budżetów, zapewniając wyjątkową wartość w porównaniu do konkurencji.</li>
                    <li><b>Indywidualne podejście</b> – każda wycieczka jest dostosowywana do potrzeb i oczekiwań grupy, dzięki czemu zapewniamy niezapomniane wspomnienia z podróży.</li></ul><br>
                <ul><h6><b>Główne korzyści:</b></h6>
                    <li><b>Edukacyjne i rozrywkowe</b> – każda wycieczka to połączenie nauki i zabawy.</li>
                    <li><b>Doświadczenie i pasja</b> – od lat organizujemy niezapomniane wycieczki, a nasz zespół jest pełen pasji do podróży i turystyki.</li>
                    <li><b>Prosta rezerwacja</b> – szybko i łatwo zarezerwujesz wycieczkę online lub telefonicznie.</li>
                    <li><b>Prosta rezerwacja</b> – szybko i łatwo zarezerwujesz wycieczkę online lub telefonicznie.</li></ul></div>
        </div>

        <div class="third-box">
            <div class="outro"><p><div style="font-size: larger"><b>Skontaktuj się z nami!</b></div><p><br>
                    Zapraszamy do kontaktu z Biurem Podróży RAFA. Nasz zespół z chęcią pomoże w zaplanowaniu Twojej wymarzonej wycieczki szkolnej! Zadzwoń lub wyślij zapytanie, a my przygotujemy ofertę dopasowaną do Twoich potrzeb.<br><br><b>Zarezerwuj wycieczkę już dziś i twórz wspomnienia na całe życie!</b></p>
                <div class="link"><a href="{{ route('contact') }}"> <i class="fas fa-arrow-circle-right"></i></a></div></div>
        </div>
    </div>
    </div>
@endsection
