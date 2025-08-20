@extends('layouts.app')

@section('content')

<main>

<section class="py-5 text-center container">
    <div class="row landing__page__top">
        <div class="col-sm-0 col-md-4 landing__page__top-left">
        </div>
      <div class="col-sm-12 col-md-8 landing__page__top-right">
        <div class="mx-auto ">
        <h1 class="fw-light">Biuro Podróży RAFA</h1>
        <p class="lead text-muted">Witamy na naszej stronie. Zapraszamy do zapoznania się z ofertą naszego biura</p>
          <p><a href="https://bprafa.pl" class="btn btn-lg btn-primary my-2">Oferta wycieczek</a></p>
          <p class="lead text-muted">Jeżeli jesteś naszym klientem lub współpracownikiem<br> zapraszamy do Wirtualnego Biura Obsługi</p>
        </div>
      </div>
    </div>
</section>

  <div class="album py-5 bg-light">
    <div class="container">

      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
    

        <div class="col">
        
        <div class="card card__frontpage">
            <img src="/img/luggage.svg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Strefa klienta</h5>
              <p class="card-text">Tu prześlesz umowę, sprwadzisz program, </p>
              <a href="#" class="btn btn-primary">Umowy</a>
            </div>
          </div>
        </div>

          <div class="col">
          <div class="card card__frontpage">
            <img src="/img/travelingcharacter.svg" class="card-img-top" alt="...">
            <div class="card-body">
              <h5 class="card-title">Strefa pilota</h5>
              <p class="card-text">Pobierz odprawę, rozlicz imprezę</p>
              <a href="#" class="btn btn-primary">Piloci</a>
            </div>
          </div>
          </div>

          <div class="col">
            <div class="card card__frontpage">
              <img src="/img/woman_at_office.svg" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Strefa dla pracowników</h5>
                <p class="card-text">Jeżeli jesteś naszym pracownikiem zaloguj się</p>
                <a href="/login" class="btn btn-primary">Logowanie</a>
              </div>
            </div>
      </div>
    </main>
    <footer class="page-footer">
        <div class="container ">
            <div class="row">
                <div class="col col-md-3">
                    <div>
                        <p>Biuro Podróży RAFA z Warszawy profesjonalnie organizuje imprezy turystyczne na terenie Polski i Europy. Jesteśmy organizatorem wycieczek szkolnych, zielonych szkół i wyjazdów dla firm.</p>
                        <p> Organizujemy szkolenia i eventy.</p>
                        <p> Zapraszamy.</p>
                    
                    </div>
                </div>
                <div class="col col-md-5">
                </div>
                <div class="col col-md-4">
                    <div>Kontakt:</div>
                    <div>Biuro Podróży RAFA</div>

                    <div>Nowogrodzka 42 lok. 501</div>
                    <div>00-695 Warszawa</div>
                    <div>tel: + 48 606 102 243</div>
                    <div>mail: rafa@bprafa.pl</div>

                    <div>Konto: Bank Millenium SA</div>
                    <div>10 1160 2202 0000 0002 0065 6958</div>
                </div>
            </div>
            <a href="https://www.vecteezy.com/free-vector/travel">Travel Vectors by Vecteezy</a>

        </div>
    </footer>




   


@endsection

@section('scripts')
<script>
</script>

@endsection

