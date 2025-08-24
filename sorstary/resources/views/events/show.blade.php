@extends('layouts.app')
@section('content')
<div class="eventview">
<div class="container">
    <div class="justify-content-center">
        @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                    <h4><strong>PROGRAM IMPREZY </strong></h4>
                        <h5><strong>{{ $event->eventOfficeId}} - {{ $event->eventName }}: </strong> {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</h5>
                        <h5>Imię i nazwisko pilota: {{ $event->eventPilotName }}</h5>
                    </div>
                    @can('role-list')

                    <div class="col-6 float-end btn-group" role="group">

                            {{ Form::open(array('route' => array('pilotpdf'), 'method'=>'get')) }}
                            <input type="hidden" name="eventId" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-success "><i class="bi bi-person-lines-fill"></i> Teczka pilota                            
                            </button>
                            {!! Form::close() !!}

                            {{ Form::open(array('route' => array('hotelpdf'), 'method'=>'get')) }}
                            <input type="hidden" name="eventId" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-house-door"></i> Agenda dla hotelu
                                
                            </button>
                            {!! Form::close() !!}   
                            
                            {{ Form::open(array('route' => array('events.index'), 'method'=>'get')) }}
                            <button type="submit" class="btn btn-outline-primary "><i class="bi bi-skip-backward-fill"></i> wszystkie imprezy                         
                            </button>
                            {!! Form::close() !!}
                            


                            <!-- <a class="btn btn-outline-primary" href="{{ route('events.index') }}" role="button"><i class="bi bi-skip-backward-fill"></i> wszystkie imprezy</a> -->
                    </div>

                    @endcan
                </div>
                </div>
            </div>
                
            
            <div class="card-body">
                <div class="card-text">
                    <div class="justify-content-center">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Ups!</strong> Coś poszło nie tak. Sprawdź błędy poniżej!<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    
                        
<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Opps!</strong> Coś poszło nie tak, sprawdź błędy!!!<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        

                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Podstawowe dane imprezy</h4>
                            </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                            <strong>Nazwa:</strong>
                                            {!! $event->eventName !!}
                                        </li>
                                        <li class="list-group-item">
                                            <strong>Kod imprezy:</strong>
                                            {!! $event->eventOfficeId !!}
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Zaliczka dla pilota:</strong>
                                            {!! $event->eventAdvancePayment !!}
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Status imprezy:</strong>
                                            {!! $event->eventStatus !!}
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Kierowca:</strong>
                                            <div>{!! $event->eventDriverName !!}</div>
                                            <div>{!! $event->eventDriverContact !!}</div>
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Pilot:</strong>
                                            <div>{!! $event->eventPilotName !!}</div>
                                            <div>{!! $event->eventPilotContact !!}</div>
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Odjazd:</strong>
                                            <div>{!! date('H:m d.m.Y',  strtotime($event->eventStartDateTime)) !!}</div>
                                            <div><pre>{!! $event->eventStartDescription !!}</pre></div>
                                        </li>

                                        <li class="list-group-item">
                                            <strong>Powrót:</strong>
                                            <div>{!! date('H:m d.m.Y',  strtotime($event->eventEndDateTime)) !!}</div>
                                            <div><pre>{!! $event->eventEndDescription !!}</pre></div>
                                        </li>

                                        </ul>
                                    </div>
                                </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Zamawiający</h4>
                            </div>
                            <div class="card-body">
                                <div class="card-text">
                                <ul class="list-group list-group-flush">
                                        <li class="list-group-item">
                                        <strong>Łączna ilość uczestników:</strong>
                                        {!! $event->eventTotalQty !!}
                                        </li>
                                        <li class="list-group-item">
                                        <strong>Opiekunowie:</strong>
                                        {!! $event->eventGuardiansQty !!}
                                        </li>
                                        <li class="list-group-item">
                                        <strong>Gratisy:</strong>
                                        {!! $event->eventFreeQty !!}
                                        </li>
                                        <li class="list-group-item">
                                        <strong>Dieta:</strong>
                                        <pre>{!! $event->eventDietAlert !!}</pre>
                                        </li>
                                        <li class="list-group-item">
                                        <strong>Zamawiający:</strong>
                                        <div>{!! $event->eventPurchaserName !!}</div>
                                        <div>{!! $event->eventPurchaserStreet !!}</div>
                                        <div>{!! $event->eventPurchaserCity !!}</div>
                                        <div>nip: {!! $event->eventPurchaserNip !!}</div>
                                        </li>
                                        <li class="list-group-item">
                                        <strong>Kontakt:</strong>
                                        <div>{!! $event->eventPurchaserContactPerson !!}</div>
                                        <div>tel.: {!! $event->eventPurchaserTel !!}</div>
                                        <div>email: {!! $event->eventPurchaserEmail !!}</div>
                                        </li>
                                </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-4">
                    <div class="card">
                            <div class="card-header"<h4>Wydatki</h4></div>
                            <div class="card-body">
                                <div class="card-text">
                                <div><strong>Wydatki łącznie: </strong> {{ $event->totalSum($event->id) }}</div>
                                <div><strong>Zapłacone: </strong>{{ $event->paidSum($event->id) }} </div>
                                <div><strong>Do zapłaty biuro: </strong> {{ $event->toPaySum($event->id) - $event->pilotSum($event->id) }} </div>
                                <div><strong>Wydatki pilota: </strong>{{ $event->pilotSum($event->id) }} </div>
                                </div>
                            </div>
                    </div>

                    <div class="card">
                        <div class="card-header"><h4>Notatki</h4></div>
                        <div class="card-body">
                            <div class="card-text">
                                <pre>
                                {!! $event->eventNote !!}
                                </pre>
                            </div>
                        </div>
                    </div>
                            
                        </div>

                    </div>
    </div>



            <!--Start moduł hotelowy i obsługa-->
            <hr>

            <div class="row justify-content-between">
                <!-- Start moduł hotel -->
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col-md-12">
                                    <h4>Noclegi</h4>
                                </div>
                               
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <th class="d-none">HotelId</th>
                                        <th>Początek</th>
                                        <th>Koniec</th>
                                        <th>Hotel</th>
                                        <th>Struktura<br>pokojów</th>
                                        <th>Notatki</th>
                                    </thead>
                                    
                                    @foreach($event->hotels as $hotel)
                                    <tr>
                                        <td class="d-none">{{ $hotel->id }} </td>
                                        <td>{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelStartDate)) }}</td>
                                        <td>{{ date('d.m.Y',  strtotime($hotel->pivot->eventHotelEndDate)) }}</td>
                                        <td> <div><strong>{{ $hotel->hotelName }} </strong></div>
                                        <div> {{ $hotel->hotelStreet }} </div>
                                        <div> {{ $hotel->hotelCity }} </div>
                                        <div> {{ $hotel->hotelRegion }} </div></td>
                                        <td><pre>{{ $hotel->pivot->eventHotelRooms }}</pre></td>
                                        <td> {{ $hotel->pivot->eventHotelNote }} </td>
                                    </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

            <hr>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">  
                                <h4>Program imprezy</h4>
                            </div> 
                    <div class="card-body">
                        <div class="card-text">
                            <table class="table table-responsive table-hover" width="100%">
                                <thead>
                                <tr>
                                    <th class="d-none">idn_to_utf8</th>
                                    <th >Czas</th>
                                    <th >Program</th>
                                    <th>Miejsce/rezerwacje/ustalenia/notatki</th>                                
                                    <th >Druk</th>
                                    <th>Wydatki</th>
                                    <th>Płatność</th>
                                </tr>

                                </thead>
                            @foreach($event->eventElements->sortBy('eventElementStart') as $element)
                                <tr>
                                    <td class="d-none">{{ $element->id }} </td>
                                    <td><div>{{ date('H:m',  strtotime($element->eventElementStart)) }}|{{ date('H:m',  strtotime($element->eventElementEnd)) }}</div><div>
                                    {{ date('d.m.Y',  strtotime($element->eventElementStart)) }}</div>
                                    </td>
                                    <td><div><strong>Program: </strong></div><div>{!! $element->element_name !!}</div>
                                    <div><strong>Opis: </strong><pre>{{ $element->eventElementDescription }}</pre></div></td>
                                    <td><div><strong>Kontakt: </strong><pre>{{ $element->eventElementContact }},</pre></div>
                                    <div><strong>Rezerwacja</strong><pre>{{ $element->eventElementReservation }}</pre></div>
                                    <td><div><strong>H:</strong>{{ $element->eventElementHotelPrint }}</div>
                                        <div><strong>P:</strong>{{ $element->eventElementPilotPrint }}</div></td>
                                    <td><div>c.jedn:{{ $element->eventElementCost }}</div>
                                    <div>szt:{{ $element->eventElementCostQty }}</div>
                                    <div> łącznie:{{ $element->eventElementCost * $element->eventElementCostQty}}</div></td>
                                    <td><div><strong>Zapłacono:</strong> {{ $element->eventElementCostStatus }}</div>
                                    <div><strong>Płatnik:</strong> {{ $element->eventElementCostPayer }}</div></td>
                                    <td>
                                    <div><strong>Notatki: </strong><pre>{{ $element->eventElementNote }}</pre></td>
                                    </tr>

                            
                            @endforeach
                            </table>
                        </div>
                    </div>
</div>
<hr>



        <div class="row">

        
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"><h4>Pliki</h4></div>
                    <div class="card-body">
                        <div class="card-text">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>nazwa</th><th>notatki</th><th>pilot</th><th>hotel</th>
                            </thead>
                            
                        @foreach($event->files as $file)
                            <tr>
                                <td>
                                    <a href="/storage/{{ $file->fileName }}" download>{{ $file->fileName }}</a>
                                </td>
                                <td>{{ $file->FileNote }}</td>
                                <td>{{ $file->filePilotSet }}</td>
                                <td>{{ $file->fileHotelSet }}</td>

                                
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

        

        


        </div>
    </div>
</div>
                    
                </div>
            </div>
        </div>
</div>
    </div>
@endsection