@extends('layouts.app')
@section('content')
<div class="container">

<h1> Kontrahenci - dodaj nowego </h1>

@php
  $contractorTypes =  \App\Models\ContractorType::get();
@endphp

<form action="/contractors" method="POST">
  @csrf


  <div class="m-3">
        <div class="row">
            <div class="col-md-6">
              <label>Dane kontrahenta</label>
              <div class="form-group">
              <input type="text" class="form-control form-control-border" name="name" placeholder="Imię i nazwisko/Nazwa kontrahenta">
              </div>
              

              <div class="form-group">
              <input type="text" class="form-control form-control-border" name="firstname" placeholder="Imię"> 
              </div>

              <div class="form-group">        
              <input type="text" class="form-control form-control-border" name="surname" placeholder="Nazwisko">  
              </div>

              <div class="form-group ">               
              <input type="text" class="form-control form-control-border" name="street" placeholder="Ulica"> 
              </div>
              <div class="form-group">             
              <input type="text" name="city" class="form-control form-control-border" placeholder="Miasto">
              </div>                  

              <div class="form-group">
              <input type="text" class="form-control form-control-border" name="nip" placeholder="nip">
              </div>
              <label>Kontakt</label>
              <div class="form-group">
              <input type="text" class="form-control form-control-border" name="phone" placeholder="telefon">
              </div>
              <div class="form-group">
              <input type="email" class="form-control form-control-border" name="email" placeholder="email">
              </div>
              <div class="form-group">
              <input type="text" class="form-control form-control-border" name="www" placeholder="www">
              </div>                  
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h4>Rodzaj kontrahenta</h4>
                
                  @foreach($contractorTypes as $type)
                  <div>
                  <input class="orm-check-input" type="checkbox" id="{{$type->name}}"" name="contractortype[]" value="{{$type->id}}" />
                  <label class="form-check-label" for="{{$type->name}}">{{$type->name}}</label>
                  </div>   
                  {{-- <option value="{{$type->id}}">{{$type->name}}</option> --}}
                  @endforeach
              </div>
                              
              <label for="name">Komentarz:</label>
              <textarea class="summernoteeditor m-3" name="description"></textarea>
            </div>
        </div>
      </div>
        <button type="submit" class="btn btn-primary">Zapisz</button>
    </form>
</div>

@endsection