@extends('layouts.app')
@section('content')

@php
$todos = \App\Models\Todo::orderBy('created_at', 'desc')->where('event_id', $event->id)->get();
@endphp

{{-- Start Modals --}}
<x-modals.create-todo-modal :event="$event"/>
<x-modals.create-contract :event="$event"/>
<x-modals.create-event-element :event="$event"/>
<x-modals.create-event-hotel :event="$event"/>
<x-modals.edit-event-hotel :event="$event"/>

<!-- ///////////////////////////// StartEditEventElementModal ////////////////////////////////////////// -->

<div class="modal fade" id="eventElementEditModal" role="dialog" aria-labelledby="fileEditLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="Title">Event Element Edit</h5>
            </div>
            {{ Form::open(array('url' => '/eventElementUpdate', 'method' => 'put')) }}
            @csrf
            <div class="modal-body">

                <div class="form-group">
                    <input type="hidden" name="elementId" id="elementId" value="">
                    <div class="row">
                        <div class="col-md-9">
                            {{ Form::label('element_name', 'Punkt programu', array('class' => 'awesome')) }}
                            {{ Form::text('element_name', 'Nazwa', ['class'=>'form-control', 'id'=>'elementName']) }}
                        </div>
                        
                        <div class="col-md-3">
                            <label for="booking">rezerwacja:</label>
                            <select name="booking" class="form-control">
                                <option value="brak rezerwacji">brak rezerwacji</option>
                                <option value="rezerwacja">rezerwacja</option>
                                <option value="do anulacji">do anulacji</option>
                                <option value="anulowany">anulowany</option>
                            </select>
                        </div>
                    </div>  

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('eventElementStart', 'Początek aktywności', array('class' => 'awesome')) }}
                            {{ Form::input('dateTime-local', 'eventElementStart', null, [ 'class' => 'form-control', 'id'=>'elementStart','min' => date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime))]) }}
                        </div>

                        <div class="col-md-6">
                            {{ Form::label('eventElementEnd', 'Koniec aktywności', array('class' => 'awesome')) }}
                            {{ Form::input('dateTime-local', 'eventElementEnd', null, [ 'class' => 'form-control', 'id'=>'elementEnd','min' => date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime))]) }}

                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('eventElementDescription', 'Opis do programu', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementDescription', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'elementDescription']) !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('eventElementNote', 'Notatki', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementNote', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'elementNote']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('eventElementContact', 'kontakt/miejsce', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementContact', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'elementContact']) !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('eventElementReservation', 'rezerwacja/ustalenia', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementReservation', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'elementReservation']) !!}
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <label for="eventElementHotelPrint">Wydruk dla hotelu:</label>
                            <select name="eventElementHotelPrint" class="form-control">
                                <option value="none" id="elementHotelPrint" selected disabled hidden>Wybierz opcję:</option>
                                <option value="nie">nie</option>
                                <option value="tak">tak</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="eventElementPilotPrint">Wydruk dla pilota:</label>
                            <select name="eventElementPilotPrint" class="form-control">
                                <option value="none" id="elementPilotPrint" selected disabled hidden>Wybierz opcję:</option>
                                <option value="nie">nie</option>
                                <option value="tak">tak</option>
                            </select>
                        </div>
                    </div>
                </div>


            </div>

            <div class="modal-bottom">
                <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-trash3"></i> Wyjdź</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<!-- ///////////////////////////// EndEditEventElementModal ////////////////////////////////////////// -->

<!-- ///////////////////////////// StartCreateTodoModal ////////////////////////////////////////// -->





<!-- ///////////////////////////// EndCreateTodoModal ////////////////////////////////////////// -->


<main>
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
    </div>

        <div class="row justify-content-between">
            <div class="col-md d-flex justify-content-end">
                {{ Form::open(array('route' => array('events.index'), 'method'=>'get')) }}
                <button type="submit" class="btn btn-outline-primary "><i class="bi bi-skip-backward-fill"></i> Powrót - wszystkie imprezy
                </button>
                {!! Form::close() !!}

            </div>
        </div>


        <div class="row justify-content-between">
                           

            <div class="col">
                <h3>Edytuj imprezę:</h3>
            </div>
            <div class="col d-flex justify-content-end btn-group" role="group">
                {{ Form::open(array('route' => array('eventPaymentsIndex'), 'method'=>'get')) }}
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <button type="submit" class="btn btn-outline-primary "><i class="bi bi-currency-euro"></i> Wydatki
                </button>
                {!! Form::close() !!}

                {{ Form::open(array('route' => array('pilotpdf'), 'method'=>'get')) }}
                <input type="hidden" name="eventId" value="{{ $event->id }}">
                <button type="submit" class="btn btn-outline-success "><i class="bi bi-filetype-pdf"></i><i class="bi bi-person-lines-fill"></i> pilot
                </button>
                {!! Form::close() !!}

                {{ Form::open(array('route' => array('hotelpdf'), 'method'=>'get')) }}
                <input type="hidden" name="eventId" value="{{ $event->id }}">
                <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i class="bi bi-house-door"></i> hotel

                </button>
                {!! Form::close() !!}

                {{ Form::open(array('route' => array('driverpdf'), 'method'=>'get')) }}
                <input type="hidden" name="eventId" value="{{ $event->id }}">
                <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i class="bi bi-globe"></i> kierowca

                </button>
                {!! Form::close() !!}

                {{ Form::open(array('route' => array('briefcasepdf'), 'method'=>'get')) }}
                <input type="hidden" name="eventId" value="{{ $event->id }}">
                <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i class="bi bi-briefcase"></i> teczka imprezy

                </button>
                {!! Form::close() !!}

                <button type="submit" id="contractButton" class="btn btn-outline-success"><i class="bi bi-briefcase"></i> umowa

                </button>
               
            </div>
        </div>
</div>
<div class="container">

        {!! Form::model($event, ['route' => ['events.update', $event->id], 'method'=>'PATCH', 'files' => true ]) !!}

            <div class="row">
                <div class="col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            <h3>Podstawowe dane imprezy</h3>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group">
                                    <strong>Nazwa:</strong>
                                    {!! Form::text('eventName', null, array('placeholder' => 'Nazwa','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Kod imprezy:</strong>
                                    {!! Form::text('eventOfficeId', null, array('placeholder' => 'Kod imprezy','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Status imprezy: {{ $event->eventStatus }}</strong>

                                    <select name="eventStatus" id="eventStatus" class="form-select">
                                        <option value="{{ $event->eventStatus }}">{{ $event->eventStatus }}</option>
                                        <option value="Zapytanie">Zapytanie</option>
										<option value="doanulacji">DoAnulacji</option>
                                        <option value="Planowana">Planowana</option>
                                        <option value="Potwierdzona">Potwierdzona</option>
                                        <option value="OdprawaOK">OdprawaOK</option>
                                        <option value="DoRozliczenia">DoRozliczenia</option>
                                        <option value="Zakończona">Zakończona</option>
                                        <option value="Zmiana terminu">Zmiana terminu</option>
                                        <option value="Anulowana">Anulowana</option>
                                        <option value="Archiwum">Archiwum</option>

                                    </select>
                                </div>
                                <div class="card">
                                    <div class="card-header">Kierowcy/Piloci</div>
                            <div class="card-body">
                                <div class="card-text">
                                    <div class="form-group">
                                        {{ Form::label('eventDriver', 'Kierowcy: imię/nazwisko nr telefonu', array('class' => 'awesome')) }}
                                        {!! Form::textarea('eventDriver', null, ['rows' => 2, 'class'=>'form-control']) !!}

                                        {{ Form::label('eventPilot', 'Piloci: imię/nazwisko nr telefonu', array('class' => 'awesome')) }}
                                        {!! Form::textarea('eventPilot', null, ['rows' => 2, 'class'=>'form-control']) !!}
                                        <!-- <strong>Imie i nazwisko:</strong>

                                        {!! Form::text('eventDriverName', null, array('placeholder' => 'imię i nazwisko:','class' => 'form-control')) !!} -->
                                    </div>
                                </div>
                            </div>
                        </div>
                                <div class="card">
                                            <div class="card-header">Koszty:</div>
                                            <div class="card-body">
                                                <div class="card-text">
                                                    <div><strong>Łącznie: </strong>{{ $event->totalSum($event->id) }}</div>
                                                    <div><strong>Zapłacono: </strong> {{ $event->paidSum($event->id) }}</div>
                                                    <hr>

                                                    <div><strong>Wydatki pilota: </strong>{{ $event->pilotSum($event->id) }}</div>

                                                    <div class="form-group">
                                                        <strong>Zaliczka dla pilota:</strong>
                                                        {!! Form::text('eventAdvancePayment', null, array('placeholder' => '0','class' => 'form-control')) !!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            </div>    
                        </div>
                    </div>
                </div>

                <div class="col-md-4 col-lg-4">


                    <div class="card">
                        <div class="card-header">
                            <h4>Uwagi do zamówienia: </h4>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group">
                                    <textarea id="editOrderNote" name="orderNote" rows="6" class="form-control summernote">
                                    {!! $event->orderNote !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            <h4>Notatki biurowe</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group">
                                    <textarea id="editEventNote" name="eventNote" rows="6" class="form-control summernote">
                                    {!! $event->eventNote !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card">
                        <div class="card-header">
                            <h4>Notatki dla pilota</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group">
                                    <textarea name="eventPilotNotes" rows="6" class="form-control">
                                    {!! $event->eventPilotNotes !!}
                                    </textarea>
                                </div>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="col-md-4">                      
                <div class="card">
                    <div class="card-header">
                        <h4>Moje zadania</h4>
                            <button type="button" class="btn btn-primary " id="btnCreateTodoModal"><i class="bi bi-file-earmark-plus"></i> zadanie</button>

                </div> 
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                {{-- <ul class="todo-list ui-sortable" data-widget="todo-list"> --}}
                                @foreach($todos as $todo)

                                @if($todo->executor_id === Auth::user()->id)
                                    <x-todos-list :todo='$todo' />

                                @endif
                                @endforeach

                                
             
                        </div>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-md-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4> Dane zamawiającego:</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group">
                                    <strong>Nazwa firmy/szkoły:</strong>
                                    {!! Form::text('eventPurchaserName', null, array('placeholder' => 'Nazwa','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Ulica/nr posesji:</strong>
                                    {!! Form::text('eventPurchaserStreet', null, array('placeholder' => 'Ulica','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Miejscowośś:</strong>
                                    {!! Form::text('eventPurchaserCity', null, array('placeholder' => 'miejscowość','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>NIP:</strong>
                                    {!! Form::text('eventPurchaserNip', null, array('placeholder' => 'Nip','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Osoba kontaktowa:</strong>
                                    {!! Form::text('eventPurchaserContactPerson', null, array('placeholder' => 'Imię i nazwisko','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>telefon kontaktowy:</strong>
                                    {!! Form::text('eventPurchaserTel', null, array('placeholder' => '0000','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>email:</strong>
                                    {!! Form::email('eventPurchaserEmail', null, array('placeholder' => 'email@test.pl','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Uczestnicy</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group">
                                    <strong>Łączna ilość uczestników:</strong>
                                    {!! Form::text('eventTotalQty', null, array('placeholder' => 'Uczestnicy','class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    <strong>Ilość opiekunów:</strong>
                                    {!! Form::text('eventGuardiansQty', null, array('placeholder' => 'opiekunowie','class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    <strong>Ilość uczestników w gratisie:</strong>
                                    {!! Form::text('eventFreeQty', null, array('placeholder' => 'gratisy','class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    <strong>Dieta:</strong>
                                    {!! Form::textarea('eventDietAlert', null, array('placeholder' => 'Uwagi odnośnie diety','class' => 'form-control')) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Start</h4>
                        </div>
                        <div class="card-body">
                            <div class="card-text">
                                <strong>Godzina wyjazdu</strong>
                                <div class="form-group">
                                    {{ Form::input('dateTime-local', 'eventStartDateTime', date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)) , ['id' => 'eventStartTime', 'class' => 'form-control']) }}
                                </div>
                                <hr>
                                <strong>Godzina podstawienia</strong>
                                <div class="form-group">
                                    {{ Form::input('dateTime-local', 'busBoardTime', date('Y-m-d\TH:i',  strtotime($event->busBoardTime)) , [ 'id'=>'busBoardTime', 'class' => 'form-control']) }}
                                    <strong>Adres podstawienia, uwagi itp.:</strong>
                                </div>
                                {!! Form::textarea('eventStartDescription', null, array('placeholder' => 'Uwagi do podstawienia','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h4>Koniec:</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <strong>Godzina powrotu</strong>
                                {{ Form::input('dateTime-local', 'eventEndDateTime',  date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime)), ['id' => 'eventEndTime', 'class' => 'form-control']) }}
                            </div>
                            <strong>Informacje o wycieczce:</strong>
                            <div class="card-text">
                                {!! Form::textarea('eventEndDescription', null, array('placeholder' => 'Uwagi do powrotu','class' => 'form-control')) !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                <div class="row">
                <button type="submit" class="btn btn-primary "><i class="bi bi-hdd"></i> Zapisz </button>
                {!! Form::close() !!}
                </div>
                </div>
            </div>
        <hr>
</div>



    {{-- <!--Start moduł zadania-->

    <div class="container">
        <div class="row justify-content-between">
                <div class="col-md-6">
                    <h4>Zadania</h4>                    
                </div>
                
                <div class="row">
                    <div class="container">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th class="d-none">todoId</th>
                                <th>Pilne</th>
                                <th>Zadanie</th>
                                <th>Wykonawca</th>
                                <th>Termin</th>
                                <th>Status</th>
                                <th>Akcje</th>
                            </thead>
                            @isset($event->todo)
                            @foreach($event->todo as $todo) 
                            <tr>
                                <td class="d-none">{{ $todo->id }}</td>
                                <td>{{ $todo->urgent }}</td>
                                <td>{{ $todo->name}}<br>{{ $todo->description }}</td>
                                <td>{{ $todo->executor_id }}</td>
                                <td>{{ $todo->deadline }}</td>
                                <td>{{ $todo->status_id }}</td>
                                <td>
                                    <form action="{{ URL::to('notes/createwithrequest/') }}" method="post">
                  <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                  <input type="hidden" name="return_path" value="even"
                  @isset($todo->event_id)
                  <input type="hidden" name="event_id" value="{{ $todo->event_id }}">
                  @endisset
                @csrf
                <button class="btn btn-primary" type="submit"> + Dodaj komentarz
                </button>
                </form></td>
                            </tr>

                            @php
          $notes= \App\Models\Note::orderBy('created_at', 'desc')->where('todo_id', $todo->id)->get();  
        @endphp
        <tr>
          <td colspan="4"> 
            <table class="table table-hover table-striped">
              <tbody>
                @foreach($notes as $note)
                  <tr>
                      <td class="mailbox-date">{{ $note->created_at }}</td>
                      <td class="mailbox-name">{{ $note->author->name }}</td>
                      <td class="mailbox-subject"><b>{{ $note->name }}</b> - {{ $note->description }}
                     </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </td>
        </tr>



                            @endforeach       
                            @endisset
                        </table>
                </div>
            </div>
        </div>
        <hr>
    </div>

   

    <!--End moduł zadania--> --}}

    <!--Start moduł hotelowy i obsługa-->

    <div class="container">
        <div class="row justify-content-between">
                <div class="row justify-content-between">
                    <div class="col-md-6">
                        <h4>Noclegi</h4>
                    </div>
                    <div class="col-md-6">
                        <div class="btn-group float-end" role="group" aria-label="button-add-hotel">
                            <button type="button" class="btn btn-outline-primary " id="btnAddHotel"><i class="bi bi-file-earmark-plus"></i> nowy hotel</button>
                            <button type="button" class="btn btn-outline-success " id="btnAddEventHotel"><i class="bi bi-calendar-plus"></i> Dodaj hotel do imprezy</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-between">
                <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <th class="d-none">HotelId</th>
                        <th>Początek</th>
                        <th>Koniec</th>
                        <th>Hotel</th>
                        <th>Ulica</th>
                        <th>Miejscowość</th>
                        <th>Region</th>
                        <th>Struktura<br>pokojów</th>
                        <th>Notatki</th>
                        <th>Operacje</th>
                    </thead>
                        @foreach($event->hotels->sortBy('eventHotelStartDate') as $hotel)
                        <tr>
                            <td class="d-none">{{ $hotel->id }} </td>
                            <td>{{ $hotel->pivot->eventHotelStartDate }}</td>
                            <td>{{ $hotel->pivot->eventHotelEndDate }}</td>
                            <td> {{ $hotel->hotelName }} </td>
                            <td> {{ $hotel->hotelStreet }} </td>
                            <td> {{ $hotel->hotelCity }} </td>
                            <td> {{ $hotel->hotelRegion }} </td>
                            <td>
                                <span class="word-wrap"> {{ $hotel->pivot->eventHotelRooms }}</span>
                            </td>
                            <td class="tabletextformated"> {{ $hotel->pivot->eventHotelNote }} </td>
                            <td>
                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-success eventHotelEditBtn">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="/eventHotelDelete" method="post">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="event_Id" value="{{ $event->id }}">
                                        <input type="hidden" name="hotel_Id" value="{{ $hotel->id }}">
                                        <button class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                </div>
                
                <hr>
            </div>

    <!-- moduł program imprezy -->

<div class="container">
    <div class="row justify-content-between">
        <div class="col">
            <h1>Program imprezy</h1>
        </div>
        <div class="col text-right">
            <button type="button" class="btn btn-outline-primary float-end elementCreateBtn" id="elementCreateBtn"><i class="bi bi-plus"></i>Nowy punkt programu</button>
        </div>
    </div>
</div>
<div class="container">
    <div class="row justify-content-between">
        <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th class="d-none">idn_to_utf8</th>
                    <th>Start</th>
                    <th>Koniec</th>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th>Kontakt/miejsce</th>
                    <th>Rezerwacje/ustalenia</th>
                    <th>Notatki</th>
                    <th>druk<br>hotel</th>
                    <th>druk<br>pilot</th>
                    <th>rezerwacja</th>
                    <th>operacje</th>
                </tr>
            </thead>

            <!-- START - dodanie dnia wycieczki -->
            @php
            $first_datetime = new DateTime($event->eventStartDateTime);
            $f_datetime = $first_datetime->format("d");
            $timeInterval = 1;
            echo '<tr>
                <td class="tdbordered" colspan="11">
                    <h3><strong>DZIEŃ '.$timeInterval.'</strong></h3>
                </td>
            </tr>';
            @endphp
            <!-- KONIEC - dodanie dnia wycieczki -->
            @foreach($event->eventElements->sortBy('eventElementStart') as $element)

            <!-- START - dodanie dnia wycieczki -->


            @php
            $last_datetime = new DateTime($element->eventElementStart);
            $l_datetime = $last_datetime->format("d");
            if ($f_datetime != $l_datetime) {
                $timeInterval++;
                $f_datetime = $l_datetime;
                echo '<tr><td class="tdbordered" colspan="11"><h3><strong>DZIEŃ ' . $timeInterval . '</strong></h3></td></tr>';
            }
            @endphp

            <!-- KONIEC - dodanie dnia wycieczki -->

            <tr>
                <td class="d-none">{{ $element->id }} </td>
                <td>{{ $element->eventElementStart }}</td>
                <td>{{ $element->eventElementEnd }}</td>
                <td>{!! $element->element_name !!}</td>
                <td class="text-wrap">{{ $element->eventElementDescription }}</td>
                <td class="text-wrap">{{ $element->eventElementContact }}</td>
                <td class="text-wrap">{{ $element->eventElementReservation }}</td>
                <td class="text-wrap">{{ $element->eventElementNote }}</td>
                <td>{{ $element->eventElementHotelPrint }}</td>
                <td>{{ $element->eventElementPilotPrint }}</td>
                <td>{{ $element->booking }}</td>



                <td>
                    <div class="btn-group float-end" role="group" aria-label="Basic example">
                        <button type="button" class="btn btn-outline-success editbtn">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <form action="/elementDelete/{{ $element->id }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button>
                        </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
    </div>
    <hr>
</div>
<div class="container">
    <div class="row justify-content-between">
        <div class="col-xs-12 col-md-4">
            <div class="card">
                <div class="card-header">
                    <h4>Pliki</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('events.fileStore') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-text">
                            <input type="hidden" name="eventId" value={{ $event->id }}>
                            <div class="form-group">
                                <strong>Nazwa pliku</strong>
                                {!! Form::text('fileName', null, array('placeholder' => 'Nazwa pliku','class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Opis pliku</strong>
                                {!! Form::text('FileNote', null, array('placeholder' => 'opis pliku','class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Wydruk dla pilota:</strong>
                                <select name="filePilotSet" id="filePilotPrint" class="form-control">
                                    <option value="nie">Nie</option>
                                    <option value="tak">Tak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <strong>Wydruk dla hotelu:</strong>
                                <select name="fileHotelSet" id="fileHotelPrint" class="form-control">
                                    <option value="nie">Nie</option>
                                    <option value="tak">Tak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <strong>Dodaj plik:</strong><br>
                                <input type="file" name="eventFile" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success form-control"> Wyślij </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pliki</h4>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>nazwa</th>
                                <th>notatki</th>
                                <th>pilot</th>
                                <th>hotel</th>
                                <th>operacje</th>
                            </thead>

                            @foreach($event->files as $file)
                            <tr>
                                <td>
                                    <a href="/storage/{{ $file->fileName }}" download>{{ $file->fileName }}</a>
                                </td>
                                {{ Form::open(array('url'=> 'eventfileupdate', 'method' => 'put')) }}
                                @csrf
                                <input type="hidden" name="id" value="{{ $file->id }}">
                                <input type="hidden" name="eventId" value="{{ $event->id }}">
                                <td>
                                    {{ Form::text('FileNote', $file->FileNote , ['class'=>'form-control']) }}
                                </td>
                                <td>
                                    <select class="form-select" name="filePilotSet">
                                        <option value="{{ $file->filePilotSet }}">{{ $file->filePilotSet }}</option>
                                        <option value="nie">nie</option>
                                        <option value="tak">tak</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select" name="fileHotelSet">
                                        <option value="{{ $file->fileHotelSet }}">{{ $file->fileHotelSet }}</option>
                                        <option value="nie">nie</option>
                                        <option value="tak">tak</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="btn-group float-end" role="group" aria-label="Basic example">

                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        {{ Form::close() }}

                                        {{ Form::open(array('url'=> 'filedelete', 'method' => 'post')) }}
                                        <input type="hidden" name="id" value="{{ $file->id }}">

                                        <button type="submit" class="btn btn-outline-danger float-end"><i class="bi bi-trash3"></i></button>
                                        {{ Form::close() }}
                                    </div>
                                </td>
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


@endsection

@section('scripts')

<script src="{{asset('js/editevent.js')}}"></script>
<script>
    $(document).ready(function() {
        $(".summernoteeditor").summernote();
        $('.dropdown-toggle').dropdown();
    });


</script>
  
@endsection


