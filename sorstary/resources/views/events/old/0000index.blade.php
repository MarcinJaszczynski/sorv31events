@extends('layouts.app')
@section('content')

@php
$eventpurchasers = \App\Models\EventContractor::where('contractortype_id', '4')->get();
@endphp
{{-- TODO - zrobić podświetlanie wysłanych ofert po 7 dniach --}}
<x-modals.event-info-modal />
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Imprezy</h4> 
            </div>
            <div class="card-body">
                <table class="table table-hover table-head-fixed">
                    <thead class="thead-dark">
                        <tr>
                            <th class="col-md-3">Zmiana</th>
                            <th class="col-md-3">Start</th>
                            <th class="col-md-6">Nazwa</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                <table class="table table-hover">
                    @if($data->count())
                        @foreach($data as $event)
                            <x-layout-elements.events-list-row :event=$event />
                        @endforeach
                    @endif
                </table>
    {!! $data->appends(\Request::except('page'))->render() !!}
</div>
        </div>
    </div>
</div>

<script>
    // var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="popover"]'))
    // var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
    //     return new bootstrap.Popover(popoverTriggerEl)
    // })

    function eventsList(){
        let eventslist = document.querySelectorAll('.event-more');
        for(let i=0; i<eventslist.length; i++){
            let event = eventslist[i];
            event.addEventListener('click', function(){
                getEvent(event.getAttribute('data-event-id'))
            })
        }
    }

    function getEvent(eventId){
        let http = new XMLHttpRequest();
        http.open('GET', '/events/' + eventId);
        http.onload = function(){
            const data = (JSON.parse(this.response));
            showEvent(data)
            }
            http.send();
        }

    function showEvent(event){
        console.log(event);
    }
    eventsList();
</script>





@endsection