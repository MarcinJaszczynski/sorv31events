@extends('layouts.app')
@section('content')
<main>
<div class="container">
    <div class = "row">
    
        <div class="card border-primary mb-3" style="max-width: 18rem;">
            <div class="card-header">Imprezy</div>
            <div class="card-body text-primary">
              <h5 class="card-title">Najbliższe wyjazdy</h5>
              <ul class="list-group list-group-flush">
                <li class="list-group-item">An item</li>
                <li class="list-group-item">A second item</li>
                <li class="list-group-item">A third item</li>
              </ul>
              <div class="card-body">
                <a href="/events" class="card-link">Wszystkie</a>
                <a href="#" class="card-link">Another link</a>
              </div>
            </div>

          </div>
          <div class="card border-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">Zadania</div>
            <div class="card-body text-secondary">
              <h5 class="card-title">Najbliższe</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
          <div class="card-header">Rezerwacje</div>
          <div class="card-body text-secondary">
            <h5 class="card-title">Najbliższe</h5>
            <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
          </div>
        </div>
        <div class="card border-secondary mb-3" style="max-width: 18rem;">
            <div class="card-header">Rezerwacje</div>
            <div class="card-body text-secondary">
              <h5 class="card-title">Najbliższe</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
            </div>
          </div>  
        </div>
      </div>
</main>
@endsection