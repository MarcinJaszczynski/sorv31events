@extends('layouts.app')
@section('content')
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
        <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h4>Imprezy</h4> |
                <a href="{{route('events.inquiry')}}">Zapytania1</a> |
                <a href="?eventStatus=Planowana">Planowane</a> |
                <a href="?eventStatus=oferta">Oferta</a> |
                <a href="?eventStatus=Potwierdzona">Potwierdzone</a> |
                <a href="?eventStatus=OdprawaOK">Odprawa</a> |
                <a href="?eventStatus=DoRozliczenia">Do Rozliczenia</a> |
                <a href="?eventStatus=Zakończona">Rozliczone</a> |
                <a href="?eventStatus=doanulacji">DO ANULOWANIA</a> |
                <a href="?eventStatus=Anulowana">Anulowane</a> |
                <a href="?eventStatus=Archiwum">Archiwum</a> |
                <a href="?createTime=True">Najnowsze</a> | |
                <a href="?">Reset</a> |



                <form action='events'>
                    <input type="hidden" name="search" value="search">
                    Szukaj:
                    <input type="text" name="searchText">
                    w
                    <select name="searchColumn">
                        <option value="eventName">nazwa imprezy</option>
                        <option value="eventOfficeId">kod imprezy</option>
                        <option value="eventPurchaserName">nazwa zamawiającego</option>
                        <option value="eventPurchaserContactPerson">osoba zamawiająca</option>
                        <option value="eventPilot">pilot</option>
                        <option value="eventDriver">kierowca</option>

                    </select>

                    <input type="submit" value="Szukaj">
                </form>

                @can('role-create')
                <span class="float-right d-flex justify-content-end">
                    <a class="btn btn-primary" href="{{ route('events.create') }}">Nowa impreza</a>
                </span>
                @endcan
            </div>

            <div class="container">
    <div class="row">
        <div class="col-sm-12 pt-3">
            <h1>Zapytania/oferty</h1>
        </div>

        <div class="clearfix"></div>
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
        @if($data->count())
            @foreach($data as $event)
                <tr>
                    <td >{{ $event->created_at->format('d.m.Y') }}</td>
                    <td>{{ date('d.m.Y',  strtotime($event->statusChangeDatetime)) }}</td>
                     
                    @if($event->todo->where('status_id',2)->count() >= $event->todo->count() and $event->todo->count()!=0)
                     <td><i class="font-weight-bold text-success fas fa-check-square"></i>
                        <a href = "/events/{!!$event->id!!}/edit" class="link-success font-weight-bold">{{ $event->eventName }}</a> ({{$event->todo->where('status_id',2)->count()}}/{{$event->todo->count()}})
                    @else
                        <td>
                        <a href = "/events/{!!$event->id!!}/edit" class="link-secondary font-weight-bold">{{ $event->eventName }}</a> ({{$event->todo->where('status_id',2)->count()}}/{{$event->todo->count()}})                          
                    @endif
                    @if(Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) >=7)
                        <div class="text-danger text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni </div>                
                    @elseif($event->statusChangeDatetime)
                        <div>{{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni  </div> 
                    @elseif(Carbon\Carbon::now()->diffInDays($event->created_at)>=7)
                        <div class="text-danger text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->created_at) }} dni </div>                
                    @else
                        <div>{{ $event->eventStatus }}</div>
                    @endif

                    @if($event->purchaser_id!=null)
                    @php
                    $purchasers = \App\Models\Contractor::where('id', $event->purchaser_id)->get();                 
                    @endphp
                    @foreach($purchasers as $purchaser)
                        <div class="text-muted sm">{{$purchaser->name}}</div>
                        <div class="text-muted sm">{{$purchaser->street}}, {{$purchaser->city}}</div>
                        <div class="text-muted sm">{{$purchaser->firstname}} {{$purchaser->surname}}</div>
                    @endforeach
                    @else
                    <div class="text-muted sm">{{$event->eventPurchaserName}}</div>
                    <div class="text-muted sm">{{$event->eventPurchaserStreet}}, {{$event->eventPurchaserCity}}</div>
                    <div class="text-muted sm">{{$event->eventPurchaserContactPerson}}</div>
                    @endif
            </td>
                    

                </tr>
            @endforeach
        @endif
    </table>
    {!! $data->appends(\Request::except('page'))->render() !!}
</div>


            
        </div>
    </div>
</div>

<script>
    var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="popover"]'))
    var popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl)
    })
</script>





@endsection




