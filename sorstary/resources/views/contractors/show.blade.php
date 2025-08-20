@extends('layouts.app')
@section('content')
<div class="container">
    <h1> Kontrahenci - show </h1>
    <div class='row'>
        <div class='col'>
            <button type="button" id="rezerwacje" class="btn btn-success">Rezerwacje</buton>
            <button type="button" id="imprezy" class="btn btn-success">Imprezy</button>
            @php
            $contractorEvents = $contractor->contractorevents;
            $contractorEvents=$contractorEvents->sortBy('eventStartDateTime');
            @endphp

            @foreach($contractorEvents as $cevent)
            <div>{{$cevent->eventStartDateTime}} - {{$cevent->eventName}}</div>
            @endforeach
            {{-- @foreach($contractor->event as $event)
            <div>{{$event->eventName}}</div>
            @foreach --}}
        </div>
    </div>
    <div class="card">
        <h5 class="card-header">{{ $contractor->name }}</h5>
        <div class="card-body">
        <h5 class="card-title">{{ $contractor->street}}, {{ $contractor->city}}</h5>
        <p class="card-text">{{ $contractor->region}}, {{ $contractor->country}}</p>
        <p class="card-text">nip: {{ $contractor->nip }}</p>
        <hr>
        <p class="card-text">tel.: <a href="tel:{{ $contractor->phone}}">{{ $contractor->phone}}</a></p>
        <p class="card-text">email.: <a href="mailto:{{ $contractor->email}}">{{ $contractor->email}}</a></p>
        <p class="card-text">www: <a href="http://{{ $contractor->www }}">{{ $contractor->www}}</a></p>
        <hr>
        <p class="card-text">notatki: {{ $contractor->description }}</a></p>        
        <a href="{{ route('contractors.index') }}" class="btn btn-primary">Powrót</a>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script></div>
<script>
    
</script>
@endsection