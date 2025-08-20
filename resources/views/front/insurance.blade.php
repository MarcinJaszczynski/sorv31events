<!-- Style przeniesione do public/dist-front/css/style.css -->
@extends('front.layout.master')

@section('main_content')
    <div class="page-top">
        <div class="container">
            <div class="breadcrumb-container">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Start</a></li>
                    <li class="breadcrumb-item active">Ubezpieczenia</li>
                </ol>
            </div>
        </div>
    </div>
    <div class="container">
    <div class="insurance pt_50 pb_70">
        <div class="top-section">
        <div class="box-for-picture pb_10">
            <div class="insurance-picture" style="background-image:url({{ asset('uploads/insurance_photo.jpg') }});">
                <div class="insurance-picture-space">
                    <div class="insurance-text-ad">
            Planujesz wycieczkę szkolną?<br>
            <div class="hide-mobile">Dobierz swoje ulubione ubezpieczenie.</div>
                    </div>
                    <div class="buy-button">
                        Wykup ubezpieczenie
                    </div>
                </div>
            </div>
        </div>
        </div>
        <div class="price-cards pt_70">
            <div class="card">
                <div class="icon-ball">
                <div class="icon">NNW</div></div>
                <h4><b>NNW RP</b><br>Ubezpieczenie podczas wyjazdów krajowych</h4>
                <div class="included"><div class="incl">wliczone w cenę wycieczki</div></div>
                <ul class="price-cards-details">
                    <h6>Zakres ubezpieczenia:</h6>
                    <li><i class="fas fa-check"></i> Ubezpieczenie NNW do kwoty 30 000 zł/osoba</li>
                    <li><i class="fas fa-check"></i> Ubezpieczenie Assistance</li>
                </ul>
                <div class="buttons">
                <div class="check-insurance">Zakres ubezpieczenia</div>
                <div class="pdf">Ogólne warunki (PDF)</div>
                </div>
            </div>
            <div class="card">
                <div class="icon-ball"><div class="icon">KL</div></div>
                <h4><b>Bezpieczne Podróże</b><br>Ubezpieczenie podczas wyjazdów zagranicznych</h4>
                <div class="included" ><div class="incl">wliczone w cenę wycieczki</div></div>
                <ul class="price-cards-details">
                    <h6>Zakres ubezpieczenia:</h6>
                    <li><i class="fas fa-check"></i> Ubezpieczenie KL i Asistatanse do kwoty 70 000 euro/osoba</li>
                    <li><i class="fas fa-check"></i> Ubezpieczenie NNW do kwoty 35 000 zł/osoba</li>
                    <li><i class="fas fa-check"></i> Ubezpieczenie OC do kwoty 60 000 euro/osoba </li>
                    <li><i class="fas fa-check"></i> Ubezpieczenie bagażu podróżnego do kwoty 2 500 zł</li>
                </ul>
                <div class="buttons">
                <div class="check-insurance">Zakres ubezpieczenia</div>
                <div class="pdf">Ogólne warunki (PDF)</div>
                </div>
            </div>
            <div class="card">
                <div class="icon-ball"><div class="icon">KR</div></div>
                <h4><b>Bezpieczne Rezerwacje</b><br>Ubezpieczenie kosztów rezygnacji</h4>
                <div class="not-included"><div class="notincl">opcja płatna dodatkowo 3,2% ceny wycieczki</div></div>
                <ul class="price-cards-details">
                    <h6>Zakres ubezpieczenia:</h6>
                    <li><i class="fas fa-check"></i> Ubezpieczenie całej ceny rezerwacji
                    </li>
                    <li><i class="fas fa-check"></i> Zwrot 100% poniesionych kosztów w przypadku rezygnacji
                    </li>
                </ul>
                <div class="buttons">
                <div class="check-insurance">Zakres ubezpieczenia</div>
                <div class="pdf">Ogólne warunki (PDF)</div>
                </div>
            </div>
        </div>

        <div class="insurance-table pt_40">
            <div class="table-box">
                <div class="insurance-name"><h4 style="text-align: left">Ubezpieczenie NNW RP</h4><br>
                </div>
                <div class="insurance-details">
                    <b><p>Ubezpieczenie Następstw Nieszczęśliwych Wypadków</b> oraz <b>Ubezpieczenie Assistance</b>.<br><br></p>
                    <ul class="insurance-list"><b>Zakres działania ubezpieczenia NNW RP:</b>
                        <li>wypłata świadczenia z tytułu uszczerbku na zdrowiu</li>
                        <li>wypłata świadczenia z tytułu śmierci</li>
                        <li>zwrot kosztów wizyty lekarza</li>
                        <li>transport medyczny na terenie Polski</li>
                        <li>refundacja kosztów wiztyty osoby bliskiej w przypadku hospitalizacji (na okres do 7 dni)</li>
                        <li>refundacja kosztów transportu zwłok ubezpieczonego</li></ul>
                        <br></div>
            </div>
            <div class="table-box">
                <div class="insurance-name"><h4 style="text-align: left">Ubezpieczenie Bezpieczne Podróże</h4><br>
                </div>
                <div class="insurance-details">
                    <p><b>Bezpieczne Podróże</b> to kompleksowa ochrona ubezpieczeniowa dla osób wyjeżdżających za granicę w celach wypoczynkowych, turystycznych, edukacyjnych i biznesowych.
                    <br><br><ul class="insurance-list"><b>Ubezpieczenie KL zadziała bez dopłat w przypadku:</b>
                    <li>uprawiania sportów amatorskich,</li>
                    <li>zaostrzenia choroby przewlekłej</li>
                    <li>ataku terrorystycznego</li>
                    <li>w zakresie szkód po spożyciu alkoholu (z wyłączeniem OC i wypadku komunikacyjnego),</li>
                    <li>nagłego zachorowania spowodowanego Sars-Cov-1 lub Sars-Cov-2 z ich mutacjami</li></ul><p>
                    <br><b>Ubezpieczenie Assistance</b> obejmuje transport medyczny bez limitu kosztów i bez zmniejszenia sumy ubezpieczenia na koszty leczenia
                    </p></div>
            </div>
            <div class="table-box">
                <div class="insurance-name"><h4 style="text-align: left">Ubezpieczenie Bezpieczne Rezerwacje</h4><br>
                </div>
                <div class="insurance-details">
                    <p><b>Bezpieczne rezerwacje</b> to sposób na ubezpieczenie kosztów rezygnacji. Ubezpieczamy <b>100% ceny</b> wycieczki.
                        <br><br></p>
                    <ul class="insurance-list"><b>Powody z których można zrezygnować z udziału w wycieczce, aby ubezpieczenie zadziałało:</b>
                        <li>nagłe zachorowanie Ubezpieczonego, Współuczestnika podróży lub Osób im bliskich skutkujące leczeniem ambulatoryjnym lub hospitalizacją (w tym COVID, choroby zakaźne),</li>
                        <li>śmierć Ubezpieczonego, Współuczestnika podróży lub Osób im bliskich (w tym w wyniku zaostrzenia choroby przewlekłej, COVID),</li>
                        <li>wyznaczenie terminu porodu na czas trwania wycieczki,</li>
                        <li>rozpoczęcie procesu pobierania krwiotwórczych komórek,</li>
                        <li>reakcja alergiczna na szczepienia, które były niezbędne do uczestnictwa w podróży,</li>
                        <li>szkoda w mieniu,</li>
                        <li>kradzież samochodu,</li>
                        <li>kradzież dokumentów niezbędnych w podroży,</li>
                        <li>oszustwo na rachunku bankowym lub karcie kredytowej (kradzież środków),</li>
                        <li>szkoda w mieniu pracodawcy,</li>
                        <li>nieszczęśliwy wypadek w pracy powodujacy wykonanie czynności prawnych w trakcie trwania podróży,</li>
                        <li>wyznaczenie daty rozpoczęcia pracy,</li>
                        <li>wypowiedzenie umowy o pracę,</li>
                        <li>unieruchomienie na 24 godziny przed podróżą pojadu Ubezpieczonego lub Współuczestnika podróży,</li>
                        <li>wezwanie do stawiennictwa w sądzie,</li>
                        <li>otrzymanie propozycji adopcji dziecka,</li>
                        <li>otrzymanie powołania do rozgrywek sportowych o randze międzynarodowej,</li>
                        <li>otrzymanie wezwania do służby wojskowej,</li>
                        <li>rozpoczęcie leczenia uzdrowiskowego,</li>
                        <li>wyznaczenie na czas trwania podroży egzaminu poprawkowego którego niezaliczenie spowoduje usunięcie ubezpieczonego z listy uczniów/studentów,</li>
                        <li>uczestnictwo w olimpiadzie międzyszkolnej organizowanej przez MEN,</li>
                        <li>wyznaczenie obrony pracy dyplomowej na uczelni wyższej,</li>
                        <li>wystąpienie aktu terroru,</li>
                        <li>nagłe zachorowanie (lub nieszczęśliwy wypadek) zwierzęcia którego właścicielem jest ubezpieczony,</li>
                        <li>odwołanie konferencji przez organizatora konferencji.</li></ul></div>
            </div>
        </div>
    </div>
    </div>
@endsection
