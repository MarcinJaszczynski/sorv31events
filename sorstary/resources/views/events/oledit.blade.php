@extends('layouts.app')
@section('content')

    <!-- ///////////////////////////// StartContractModal ////////////////////////////////////////// -->

    <div class="modal fade" id="contractModal" role="dialog" aria-labelledby="contractLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Umowa</h4>
                </div>

                {{ Form::open(array('url' => '/reports/contractPdf', 'method' => 'post')) }}
                @csrf

                <div class="modal-body">

                    <input type="hidden" name="eventId" value="{{ $event->id }}">

                    {{ Form::label('eventOfficeId', 'Nr imprezy:', array('class' => 'awesome')) }}
                    {{ Form::text('eventOfficeId', $event->eventOfficeId, ['class' => 'form-control']) }}

                    {{ Form::label('contractDate', 'Data zawarcia umowy:', array('class' => 'awesome')) }}<br />
                    <input type="date" name='contractDate' value="<?php echo date('Y-m-d'); ?>" />
                    <br />

                    {{ Form::label('eventPurchaserPerson', 'Zamawiający:', array('class' => 'awesome')) }}
                    {{ Form::text('eventPurchaserContactPerson', $event->eventPurchaserContactPerson, ['class' => 'form-control']) }}

                    {{ Form::label('eventType', 'Rodzaj imprezy:', array('class' => 'awesome')) }}
                    {{ Form::text('eventType', 'Wycieczka szkolna', ['class' => 'form-control']) }}

                    {{ Form::label('eventName', 'Nazwa imprezy:', array('class' => 'awesome')) }}
                    {{ Form::text('eventName', $event->eventName, ['class' => 'form-control']) }}

                    {{ Form::label('coach', 'Środek transportu:', array('class' => 'awesome')) }}
                    {{ Form::text('coach', 'Autokar turystyczny', ['class' => 'form-control']) }}

                    {{ Form::label('busBoardTime', 'Godzina podstawienia:', array('class' => 'awesome')) }}
                    {{ Form::text('busBoardTime', date('Y-m-d\  H:i', strtotime($event->busBoardTime)), ['class' => 'form-control']) }}



                    {{ Form::label('eventStartDescription', 'Miejsce podstawienia:', array('class' => 'awesome')) }}<br>
                    <textarea rows="4" , cols="54" name="eventStartDescription" style="resize:none, ">{{ $event->eventStartDescription }}
                            </textarea><br />


                    {{ Form::label('eventStartDateTime', 'Początek wycieczki:', array('class' => 'awesome')) }}
                    {{ Form::input('dateTime-local', 'eventStartDateTime', date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), ['class' => 'form-control']) }}

                    {{ Form::label('eventEndDateTime', 'Koniec wycieczki:', array('class' => 'awesome')) }}
                    {{ Form::input('dateTime-local', 'eventEndDateTime', date('Y-m-d\TH:i', strtotime($event->eventEndDateTime)), ['class' => 'form-control']) }}

                    {{ Form::label('eventTotalQty', 'Ilość uczestników:', array('class' => 'awesome')) }}
                    {{ Form::text('eventTotalQty', $event->eventTotalQty, ['class' => 'form-control']) }}

                    {{ Form::label('eventGuardiansQty', 'w tym opiekunów:', array('class' => 'awesome')) }}
                    {{ Form::text('eventGuardiansQty', $event->eventGuardiansQty, ['class' => 'form-control']) }}

                    {{ Form::label('eventHotel', 'Obiekt noclegowy:', array('class' => 'awesome')) }}<br />
                    <textarea rows="4" , cols="54" name="eventHotel">
                            @foreach($event->hotels->sortBy('eventHotelStartDate') as $hotel)
                                &#13; <br />{{ $hotel->hotelName}}, {{ $hotel->hotelStreet}}, {{ $hotel->hotelCity}},

                            @endforeach        
                        </textarea>
                    <br>

                    {{ Form::label('eventFood', 'wyżywienie:', array('class' => 'awesome')) }}
                    {{ Form::text('eventFood', 'zgodnie z programem', ['class' => 'form-control']) }}

                    {{ Form::label('eventInsurance', 'Ubezpieczenie:', array('class' => 'awesome')) }}
                    {{ Form::text('eventInsurance', 'NNW Signal Iduna do kwoty 30 000 zł/os. w wersji Standard Plus', ['class' => 'form-control']) }}

                    {{ Form::label('eventAddInfo', 'Dodatkowe informacje:', array('class' => 'awesome')) }}<br>
                    <textarea rows="4" , cols="54" name="eventAddInfo" style="resize:none, ">
                            &#13; Opiekę nad małoletnimi dziećmi będą sprawowali nauczyciele szkolni&#13;&#10;
                        </textarea><br />

                    {{ Form::label('eventPriceBrutto', 'Cena brutto:', array('class' => 'awesome')) }}
                    {{ Form::text('eventPriceBrutto', 'xx zł x xx osób = xxxx zł brutto', ['class' => 'form-control']) }}

                    {{ Form::label('eventPrice', 'Cena brutto słownie:', array('class' => 'awesome')) }}
                    {{ Form::text('eventPrice', 'xxx złotych brutto', ['class' => 'form-control']) }}

                    {{ Form::label('eventPriceInclude', 'Cena obejmuje:', array('class' => 'awesome')) }}<br>
                    <textarea rows="4" , cols="54" name="eventPriceInclude" style="resize:none, ">
                            &#13; przejazd autokarem, opiekę pilota, przewodników lokalnych, bilety wstępu na realizacje programu, ubezpieczenie NNW do kwoty 30 000 zł w wersji Standard Plus, podatek VAT, miejsca gratis dla opiekunów &#13;&#10;
                        </textarea><br /><br />

                    {{ Form::label('eventPriceType', 'Forma płatności:', array('class' => 'awesome')) }}
                    {{ Form::text('eventPriceType', 'przelew', ['class' => 'form-control']) }}

                    {{ Form::label('eventAdvance', 'Zaliczka:', array('class' => 'awesome')) }}
                    {{ Form::text('eventAdvance', 'xxx złotych brutto', ['class' => 'form-control']) }}

                    {{ Form::label('eventAdvanceTime', 'Data płatności zaliczki:', array('class' => 'awesome')) }}<br />
                    <input type="date" name='eventAdvanceTime' value="<?php echo date('Y-m-d'); ?>" />
                    <br />

                    {{ Form::label('eventSupplement', 'Dopłata:', array('class' => 'awesome')) }}
                    {{ Form::text('eventSupplement', 'xxx złotych brutto', ['class' => 'form-control']) }}

                    {{ Form::label('eventSupplementTime', 'Data dopłaty całości:', array('class' => 'awesome')) }}<br />
                    <input type="date" name='eventSupplementTime' value="<?php echo date('Y-m-d'); ?>" />
                    <br />

                    {{ Form::label('eventPaymentName', 'Tytuł wpłaty:', array('class' => 'awesome')) }}
                    <input type="text" name="'eventPaymentName" class="form-control"
                        value="{{ $event->eventName }} rezerwacja nr. {{ $event->eventOfficeId }}" </div>


                    <div class="modal-bottom">
                        <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Generuj
                                umowę</button>
                            <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                    class="bi bi-trash3"></i> Wyjdź</button>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>


    <!-- ///////////////////////////// EndContractModal ////////////////////////////////////////// -->



    <!-- ///////////////////////////// StartCreateHotelModal ////////////////////////////////////////// -->

    <div class="modal fade" id="createHotelModal" role="dialog" aria-labelledby="createHotelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Nowy hotel</h4>
                </div>

                {{ Form::open(array('url' => 'hotels/store', 'method' => 'post')) }}
                @csrf

                <div class="modal-body">

                    {{ Form::label('hotelName', 'Nazwa hotelu:', array('class' => 'awesome')) }}
                    {{ Form::text('hotelName', 'Nazwa', ['class' => 'form-control']) }}

                    {{ Form::label('hotelStreet', 'Ulica/nr:', array('class' => 'awesome')) }}
                    {{ Form::text('hotelStreet', null, ['class' => 'form-control']) }}

                    {{ Form::label('hotelCity', 'miejscowość:', array('class' => 'awesome')) }}
                    {{ Form::text('hotelCity', null, ['class' => 'form-control']) }}

                    {{ Form::label('hotelRegion', 'region:', array('class' => 'awesome')) }}
                    {{ Form::text('hotelRegion', null, ['class' => 'form-control']) }}

                    {{ Form::label('hotelContact', 'imię/nazwisko osoby kontaktowej:', array('class' => 'awesome')) }}
                    {{ Form::text('hotelContact', null, ['class' => 'form-control']) }}

                    {{ Form::label('hotelPhone', 'tel:', array('class' => 'awesome')) }}
                    {{ Form::text('hotelPhone', null, ['class' => 'form-control']) }}

                    {{ Form::label('hotelEmail', 'email:', array('class' => 'awesome')) }}
                    {{ Form::email('hotelEmail', null, ['class' => 'form-control']) }}

                    {{ Form::label('hotelNote', 'notatki:', array('class' => 'awesome')) }}
                    {{ Form::textarea('hotelNote', null, ['class' => 'form-control', 'rows' => 4,]) }}



                </div>
                <div class="modal-bottom">
                    <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class="bi bi-trash3"></i> Wyjdź</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>

    <!-- ///////////////////////////// EndCreateHotelModal ////////////////////////////////////////// -->

    <!-- ///////////////////////////// StartAddEventHotelModal ////////////////////////////////////////// -->

    <div class="modal fade" id="addEventHotelModal" role="dialog" aria-labelledby="addEventHotelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4>Dodaj nocleg</h4>
                </div>
                {{ Form::open(array('url' => 'eventhotel/store', 'method' => 'post')) }}
                @csrf
                <div class="modal-body">

                    <input type="hidden" name="event_id" value="{{ $event->id }}">


                    <select name="hotel_id" class="form-select form-select">

                        @foreach($allHotels as $hotel)

                            <option value="{{ $hotel->id }}">{{ $hotel->hotelName }}, {{ $hotel->hotelStreet }}
                                {{ $hotel->hotelCity }}, {{ $hotel->hotelRegion }}
                            </option>
                        @endforeach
                    </select>


                    {{ Form::label('eventHotelStartDate', 'Początek rezerwacji', array('class' => 'awesome')) }}
                    {{ Form::input('dateTime-local', 'eventHotelStartDate', date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), ['class' => 'form-control', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}

                    {{ Form::label('eventHotelEndDate', 'koniec rezerwacji', array('class' => 'awesome')) }}
                    {{ Form::input('dateTime-local', 'eventHotelEndDate', date('Y-m-d\TH:i', strtotime($event->eventEndDateTime)), ['class' => 'form-control', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}

                    {{ Form::label('eventHotelRooms', 'struktura pokojów', array('class' => 'awesome')) }}
                    {!! Form::textarea('eventHotelRooms', null, ['rows' => 4, 'class' => 'form-control']) !!}

                    {{ Form::label('eventHotelNote', 'notatki:', array('class' => 'awesome')) }}
                    {{ Form::text('eventHotelNote', 'notatki', ['class' => 'form-control']) }}

                </div>
                <div class="modal-bottom">
                    <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class="bi bi-trash3"></i> Wyjdź</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    </div>

    <!-- ///////////////////////////// EndAddEventHotelModal ////////////////////////////////////////// -->


    <!-- ///////////////////////////// StartEditEventHotelModal ////////////////////////////////////////// -->

    <div class="modal fade" id="eventHotelEditModal" role="dialog" aria-labelledby="eventHotelEditModal" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                {{ Form::open(array('url' => 'eventhotel/update', 'method' => 'put')) }}
                @csrf
                <div class="modal-header">
                    <h5>Edytuj noclegi</h5>
                </div>

                <div class="modal-body">

                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" name="hotel_id" id="eHotelId" value="">


                    <div id="eHotelName"></div>


                    {{ Form::label('eventHotelStartDate', 'Początek rezerwacji', array('class' => 'awesome')) }}
                    {{ Form::input('dateTime-local', 'eventHotelStartDate', date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), ['class' => 'form-control', 'id' => 'eHotelStart', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}

                    {{ Form::label('eventHotelEndDate', 'koniec rezerwacji', array('class' => 'awesome')) }}
                    {{ Form::input('dateTime-local', 'eventHotelEndDate', null, ['class' => 'form-control', 'id' => 'eHotelEnd']) }}

                    {{ Form::label('eventHotelRooms', 'struktura pokojów', array('class' => 'awesome')) }}
                    {!! Form::textarea('eventHotelRooms', null, ['rows' => 4, 'class' => 'form-control', 'id' => 'eHotelRooms']) !!}

                    {{ Form::label('eventHotelNote', 'notatki:', array('class' => 'awesome')) }}
                    {!! Form::textarea('eventHotelNote', null, ['rows' => 4, 'class' => 'form-control', 'id' => 'eHotelNote']) !!}

                    <!-- {{ Form::text('eventHotelNote', 'notatki', ['class'=>'form-control', 'id'=>'eHotelNote']) }} -->

                </div>

                <div class="modal-bottom">
                    <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class="bi bi-trash3"></i> Wyjdź</button>
                    </div>

                </div>
                {{ Form::close() }}

            </div>
        </div>
    </div>


    <!-- ///////////////////////////// EndEditEventHotelModal ////////////////////////////////////////// -->


    <!-- ///////////////////////////// StartCreateEventElementModal ////////////////////////////////////////// -->


    <div class="modal fade" id="createEventElementModal" role="dialog" aria-labbeledby="createEventElementLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Dodaj nowy punkt programu:</h5>
                </div>

                <div class="modal-body">
                    {{ Form::open(array('url' => 'events/elementCreate', 'method' => 'post')) }}

                    <input type="hidden" name="eventIdinEventElements" value="{{ $event->id }}">


                    {{ Form::label('element_name', 'Punkt programu', array('class' => 'awesome')) }}
                    {{ Form::text('element_name', 'Nazwa', ['class' => 'form-control']) }}
                    <div class="row">
                        <div class="col-md-6">


                            {{ Form::label('eventElementStart', 'Początek aktywności', array('class' => 'awesome')) }}
                            {{ Form::input('dateTime-local', 'eventElementStart', date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), ['class' => 'form-control', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}
                        </div>
                        <div class="col-md-6">

                            {{ Form::label('eventElementEnd', 'Koniec aktywności', array('class' => 'awesome')) }}
                            {{ Form::input('dateTime-local', 'eventElementEnd', date('Y-m-d\TH:i', strtotime($event->eventEndDateTime)), ['class' => 'form-control', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('eventElementDescription', 'Opis do programu', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementDescription', 'opis do programu', ['rows' => 4, 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('eventElementNote', 'Notatki dla biura(niewidoczne dla hotelu i pilota)', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementNote', null, ['rows' => 4, 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('eventElementContact', 'kontakt/miejsce', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementContact', null, ['rows' => 4, 'class' => 'form-control']) !!}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('eventElementReservation', 'rezerwacje/ustalenia', array('class' => 'awesome')) }}
                            {!! Form::textarea('eventElementReservation', null, ['rows' => 4, 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('eventElementPilotPrint', 'Wydruk dla pilota', array('class' => 'awesome')) }}


                            {{ Form::select('eventElementPilotPrint', ['tak' => 'tak', 'nie' => 'nie'], null, ['class' => 'form-control']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('eventElementHotelPrint', 'Wydruk dla hotelu', array('class' => 'awesome')) }}
                            {{ Form::select('eventElementHotelPrint', ['nie' => 'nie', 'tak' => 'tak'], null, ['class' => 'form-control']) }}
                        </div>
                    </div>





                </div>

                <div class="modal-bottom">
                    <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class="bi bi-trash3"></i> Wyjdź</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>


    <!-- ///////////////////////////// EndCreateEventElementModal ////////////////////////////////////////// -->





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

                        {{ Form::label('element_name', 'Punkt programu', array('class' => 'awesome')) }}
                        {{ Form::text('element_name', 'Nazwa', ['class' => 'form-control', 'id' => 'elementName']) }}

                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::label('eventElementStart', 'Początek aktywności', array('class' => 'awesome')) }}
                                {{ Form::input('dateTime-local', 'eventElementStart', null, ['class' => 'form-control', 'id' => 'elementStart', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}
                            </div>

                            <div class="col-md-6">
                                {{ Form::label('eventElementEnd', 'Koniec aktywności', array('class' => 'awesome')) }}
                                {{ Form::input('dateTime-local', 'eventElementEnd', null, ['class' => 'form-control', 'id' => 'elementEnd', 'min' => date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i', strtotime($event->eventEndDateTime))]) }}

                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::label('eventElementDescription', 'Opis do programu', array('class' => 'awesome')) }}
                                {!! Form::textarea('eventElementDescription', null, ['rows' => 4, 'class' => 'form-control', 'id' => 'elementDescription']) !!}
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('eventElementNote', 'Notatki', array('class' => 'awesome')) }}
                                {!! Form::textarea('eventElementNote', null, ['rows' => 4, 'class' => 'form-control', 'id' => 'elementNote']) !!}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                {{ Form::label('eventElementContact', 'kontakt/miejsce', array('class' => 'awesome')) }}
                                {!! Form::textarea('eventElementContact', null, ['rows' => 4, 'class' => 'form-control', 'id' => 'elementContact']) !!}
                            </div>
                            <div class="col-md-6">
                                {{ Form::label('eventElementReservation', 'rezerwacja/ustalenia', array('class' => 'awesome')) }}
                                {!! Form::textarea('eventElementReservation', null, ['rows' => 4, 'class' => 'form-control', 'id' => 'elementReservation']) !!}
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-6">
                                <label for="eventElementHotelPrint">Wydruk dla hotelu:</label>
                                <select name="eventElementHotelPrint" class="form-control">
                                    <option value="none" id="elementHotelPrint" selected disabled hidden>Wybierz opcję:
                                    </option>
                                    <option value="nie">nie</option>
                                    <option value="tak">tak</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="eventElementPilotPrint">Wydruk dla pilota:</label>
                                <select name="eventElementPilotPrint" class="form-control">
                                    <option value="none" id="elementPilotPrint" selected disabled hidden>Wybierz opcję:
                                    </option>
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
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class="bi bi-trash3"></i> Wyjdź</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
    </div>




    <!-- ///////////////////////////// EndEditEventElementModal ////////////////////////////////////////// -->


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

            <div class="row justify-content-between">
                <div class="col-md-6">

                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    {{ Form::open(array('route' => array('events.index'), 'method' => 'get')) }}
                    <button type="submit" class="btn btn-outline-primary "><i class="bi bi-skip-backward-fill"></i> Powrót -
                        wszystkie imprezy
                    </button>
                    {!! Form::close() !!}

                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="row justify-content-between">
                        <div class="col-6">
                            <h3>Edytuj imprezę:</h3>
                        </div>
                        <div class="col-6 d-flex justify-content-end btn-group" role="group">
                            {{ Form::open(array('route' => array('eventPaymentsIndex'), 'method' => 'get')) }}
                            <input type="hidden" name="event_id" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-primary "><i class="bi bi-currency-euro"></i>
                                Wydatki
                            </button>
                            {!! Form::close() !!}

                            {{ Form::open(array('route' => array('pilotpdf'), 'method' => 'get')) }}
                            <input type="hidden" name="eventId" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-success "><i class="bi bi-filetype-pdf"></i><i
                                    class="bi bi-person-lines-fill"></i> pilot
                            </button>
                            {!! Form::close() !!}

                            {{ Form::open(array('route' => array('hotelpdf'), 'method' => 'get')) }}
                            <input type="hidden" name="eventId" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i
                                    class="bi bi-house-door"></i> hotel

                            </button>
                            {!! Form::close() !!}

                            {{ Form::open(array('route' => array('driverpdf'), 'method' => 'get')) }}
                            <input type="hidden" name="eventId" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i
                                    class="bi bi-globe"></i> kierowca

                            </button>
                            {!! Form::close() !!}

                            {{ Form::open(array('route' => array('briefcasepdf'), 'method' => 'get')) }}
                            <input type="hidden" name="eventId" value="{{ $event->id }}">
                            <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i
                                    class="bi bi-briefcase"></i> teczka imprezy

                            </button>
                            {!! Form::close() !!}

                            <button type="submit" id="contractButton" class="btn btn-outline-success"><i
                                    class="bi bi-briefcase"></i> umowa

                            </button>





                            <!-- <a class="btn btn-outline-primary float-end " href="{{ route('events.index') }}"><i class="bi bi-skip-backward-fill"></i> wszystkie imprezy</a> -->
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    {!! Form::model($event, ['route' => ['events.update', $event->id], 'method' => 'PATCH', 'files' => true]) !!}



                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3>Podstawowe dane imprezy</h3>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <div class="form-group">
                                            <strong>Nazwa:</strong>
                                            {!! Form::text('eventName', null, array('placeholder' => 'Nazwa', 'class' => 'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            <strong>Kod imprezy:</strong>
                                            {!! Form::text('eventOfficeId', null, array('placeholder' => 'Kod imprezy', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>Status imprezy: {{ $event->eventStatus }}</strong>

                                            <select name="eventStatus" id="eventStatus" class="form-select">
                                                <option value="{{ $event->eventStatus }}">{{ $event->eventStatus }}</option>
                                                <option value="Zapytanie">Zapytanie</option>
                                                <option value="Planowana">Planowane</option>
                                                <option value="oferta">Oferta</option>
                                                <option value="Potwierdzona">Potwierdzona</option>
                                                <option value="OdprawaOK">Odprawa</option>
                                                <option value="DoRozliczenia">Do Rozliczenia</option>
                                                <option value="Zakończona">Rozliczona</option>
                                                <option value="doanulacji">DO ANULOWANIA</option>
                                                <option value="Anulowana">Anulowana</option>
                                                <option value="Archiwum">Archiwum</option>
                                            </select>
                                        </div>

                                        <hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Kierowcy/Piloci</div>
                                                    <div class="card-body">
                                                        <div class="card-text">
                                                            <div class="form-group">
                                                                {{ Form::label('eventDriver', 'Kierowcy: imię/nazwisko nr telefonu', array('class' => 'awesome')) }}
                                                                {!! Form::textarea('eventDriver', null, ['rows' => 2, 'class' => 'form-control']) !!}

                                                                {{ Form::label('eventPilot', 'Piloci: imię/nazwisko nr telefonu', array('class' => 'awesome')) }}
                                                                {!! Form::textarea('eventPilot', null, ['rows' => 2, 'class' => 'form-control']) !!}
                                                                <!-- <strong>Imie i nazwisko:</strong>

                                                                        {!! Form::text('eventDriverName', null, array('placeholder' => 'imię i nazwisko:','class' => 'form-control')) !!} -->
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Koszty:</div>
                                                    <div class="card-body">
                                                        <div class="card-text">
                                                            <div><strong>Łącznie:
                                                                </strong>{{ $event->totalSum($event->id) }}</div>
                                                            <div><strong>Zapłacono: </strong>
                                                                {{ $event->paidSum($event->id) }}</div>
                                                            <hr>

                                                            <div><strong>Wydatki pilota:
                                                                </strong>{{ $event->pilotSum($event->id) }}</div>

                                                            <div class="form-group">
                                                                <strong>Zaliczka dla pilota:</strong>
                                                                {!! Form::text('eventAdvancePayment', null, array('placeholder' => '0', 'class' => 'form-control')) !!}
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

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Notatki biurowe</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <div class="form-group">
                                            <textarea id="editEventNote" name="eventNote" rows="6" class="form-control">
                                                    {!! $event->eventNote !!}
                                                    </textarea>


                                            <!-- {!! Form::textarea('eventNote', $event->eventNote, array('placeholder' => 'Notatki','class' => 'form-control', 'id'=>'editEventNote')) !!} -->
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


                                            <!-- {!! Form::textarea('eventNote', $event->eventNote, array('placeholder' => 'Notatki','class' => 'form-control', 'id'=>'editEventNote')) !!} -->
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>





                    </div>
                </div>

                <div class="container">

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4> Dane zamawiającego:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">
                                        <div class="form-group">
                                            <strong>Nazwa firmy/szkoły:</strong>
                                            {!! Form::text('eventPurchaserName', null, array('placeholder' => 'Nazwa', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>Ulica/nr posesji:</strong>
                                            {!! Form::text('eventPurchaserStreet', null, array('placeholder' => 'Ulica', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>Miejscowośś:</strong>
                                            {!! Form::text('eventPurchaserCity', null, array('placeholder' => 'miejscowość', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>NIP:</strong>
                                            {!! Form::text('eventPurchaserNip', null, array('placeholder' => 'Nip', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>Osoba kontaktowa:</strong>
                                            {!! Form::text('eventPurchaserContactPerson', null, array('placeholder' => 'Imię i nazwisko', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>telefon kontaktowy:</strong>
                                            {!! Form::text('eventPurchaserTel', null, array('placeholder' => '0000', 'class' => 'form-control')) !!}
                                        </div>
                                        <div class="form-group">
                                            <strong>email:</strong>
                                            {!! Form::email('eventPurchaserEmail', null, array('placeholder' => 'email@test.pl', 'class' => 'form-control')) !!}
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Uczestnicy</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-text">

                                        <div class="form-group">
                                            <strong>Łączna ilość uczestników:</strong>
                                            {!! Form::text('eventTotalQty', null, array('placeholder' => 'Uczestnicy', 'class' => 'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            <strong>Ilość opiekunów:</strong>
                                            {!! Form::text('eventGuardiansQty', null, array('placeholder' => 'opiekunowie', 'class' => 'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            <strong>Ilość uczestników w gratisie:</strong>
                                            {!! Form::text('eventFreeQty', null, array('placeholder' => 'gratisy', 'class' => 'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                            <strong>Dieta:</strong>
                                            {!! Form::textarea('eventDietAlert', null, array('placeholder' => 'Uwagi odnośnie diety', 'class' => 'form-control')) !!}
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Start</h4>
                                </div>



                                <div class="card-body">

                                    <div class="card-text">
                                        <strong>Godzina wyjazdu</strong>


                                        <div class="form-group">
                                            {{ Form::input('dateTime-local', 'eventStartDateTime', date('Y-m-d\TH:i', strtotime($event->eventStartDateTime)), ['id' => 'eventStartTime', 'class' => 'form-control']) }}
                                        </div>
                                        <hr>

                                        <strong>Godzina podstawienia</strong>


                                        <div class="form-group">
                                            {{ Form::input('dateTime-local', 'busBoardTime', date('Y-m-d\TH:i', strtotime($event->busBoardTime)), ['id' => 'busBoardTime', 'class' => 'form-control']) }}
                                            <strong>Adres podstawienia, uwagi itp.:</strong>


                                        </div>
                                        {!! Form::textarea('eventStartDescription', null, array('placeholder' => 'Uwagi do podstawienia', 'class' => 'form-control')) !!}


                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Koniec:</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <strong>Godzina powrotu</strong>

                                        {{ Form::input('dateTime-local', 'eventEndDateTime', date('Y-m-d\TH:i', strtotime($event->eventEndDateTime)), ['id' => 'eventEndTime', 'class' => 'form-control']) }}

                                    </div>
                                    <strong>Informacje o wycieczce:</strong>

                                    <div class="card-text">
                                        {!! Form::textarea('eventEndDescription', null, array('placeholder' => 'Uwagi do powrotu', 'class' => 'form-control')) !!}


                                    </div>
                                </div>
                            </div>
                        </div>




                    </div>


                </div>





                <button type="submit" class="btn btn-primary "><i class="bi bi-hdd"></i> Zapisz</button>
                {!! Form::close() !!}
            </div>
        </div>

        <hr>

        <!--Start moduł hotelowy i obsługa-->

        <div class="row justify-content-between">
            <!-- Start moduł hotel -->
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-6">
                                <h4>Noclegi</h4>
                            </div>
                            <div class="col-md-6">
                                <div class="btn-group float-end" role="group" aria-label="Basic example">
                                    <button type="button" class="btn btn-outline-primary " id="btnAddHotel"><i
                                            class="bi bi-file-earmark-plus"></i> nowy hotel</button>
                                    <button type="button" class="btn btn-outline-success " id="btnAddEventHotel"><i
                                            class="bi bi-calendar-plus"></i> Dodaj hotel do imprezy</button>
                                </div>
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
                                    <th>Nazwa</th>
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
                                            <pre>{{ $hotel->pivot->eventHotelRooms }}</pre>
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

                                    </tr>
                                @endforeach



                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- Koniec moduł hotel -->
            <!-- Start moduł obsługa -->
            <div class="col-md-6"></div>
            <!-- Koniec moduł hotel -->

        </div>


        <!-- koniec moduł hotel i obsługa -->
        <hr>

        <!-- moduł program imprezy -->

        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-4">
                        <h4>Program imprezy</h4>
                    </div>
                    <div class="col-4 text-right">
                        <button type="button" class="btn btn-outline-primary float-end elementCreateBtn"
                            id="elementCreateBtn"><i class="bi bi-plus"></i>
                            Nowy punkt programu</button>

                    </div>
                </div>



            </div>
            <div class="card-body">
                <div class="card-text">
                    <table class="table table-striped table-hover" width="100%">
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
                                                                                                                <h3><strong>DZIEŃ ' . $timeInterval . '</strong></h3>
                                                                                                            </td>
                                                                                                        </tr>';
                        @endphp


                        <!-- KONIEC - dodanie dnia wycieczki -->
                        @foreach($event->eventElements->sortBy('eventElementStart') as $element)

                                            <!-- START - dodanie dnia wycieczki -->


                                            <?php
                            $last_datetime = new DateTime($element->eventElementStart);
                            $l_datetime = $last_datetime->format("d");
                            if ($f_datetime != $l_datetime) {
                                $timeInterval++;
                                $f_datetime = $l_datetime;
                                echo '<tr><td class="tdbordered" colspan="11"><h3><strong>DZIEŃ ' . $timeInterval . '</strong></h3></td></tr>';
                            }

                                                                                            ?>

                                            <!-- KONIEC - dodanie dnia wycieczki -->

                                            <tr>
                                                <td class="d-none">{{ $element->id }} </td>
                                                <td>{{ $element->eventElementStart }}</td>
                                                <td>{{ $element->eventElementEnd }}</td>
                                                <td>{!! $element->element_name !!}</td>
                                                <td class="tabletextformated">{{ $element->eventElementDescription }}</td>
                                                <td class="tabletextformated">{{ $element->eventElementContact }}</td>
                                                <td class="tabletextformated">{{ $element->eventElementReservation }}</td>
                                                <td class="tabletextformated">{{ $element->eventElementNote }}</td>
                                                <td>{{ $element->eventElementHotelPrint }}</td>
                                                <td>{{ $element->eventElementPilotPrint }}</td>


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
        </div>
        <hr>



        <div class="row">

            <div class="col-md-4">
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
                                    {!! Form::text('fileName', null, array('placeholder' => 'Nazwa pliku', 'class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>Opis pliku</strong>
                                    {!! Form::text('FileNote', null, array('placeholder' => 'opis pliku', 'class' => 'form-control')) !!}
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
                                    <input type="file" name="eventFile" class="form-control"
                                        accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip">
                                </div>

                            </div>
                            <button type="submit" class="btn btn-success form-control"> Wyślij </button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4>Pliki</h4>
                    </div>
                    <div class="card-body">
                        <div class="card-text">
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
                                        {{ Form::open(array('url' => 'eventfileupdate', 'method' => 'put')) }}
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $file->id }}">
                                        <input type="hidden" name="eventId" value="{{ $event->id }}">
                                        <td>
                                            {{ Form::text('FileNote', $file->FileNote, ['class' => 'form-control']) }}
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


                                        <!-- <td>{{ $file->FileNote }}</td>
                                                        <td>{{ $file->filePilotSet }}</td>
                                                        <td>{{ $file->fileHotelSet }}</td> -->



                                        <td>
                                            <div class="btn-group float-end" role="group" aria-label="Basic example">

                                                <button type="submit" class="btn btn-outline-success">
                                                    <i class="bi bi-pencil-square"></i>
                                                </button>
                                                {{ Form::close() }}

                                                {{ Form::open(array('url' => 'filedelete', 'method' => 'post')) }}
                                                <input type="hidden" name="id" value="{{ $file->id }}">

                                                <button type="submit" class="btn btn-outline-danger float-end"><i
                                                        class="bi bi-trash3"></i></button>
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
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#editEventNote").summernote();
            $('.dropdown-toggle').dropdown();
        });
    </script>

    <script>
        $(document).ready(function () {
            $('.elementCreateBtn').on('click', function () {
                $('#createEventElementModal').modal('show');
            })
        })
    </script>
    <script>
        $(document).ready(function () {
            $('#btnAddHotel').on('click', function () {
                $('#createHotelModal').modal('show');
            })
        })
    </script>

    <script>
        $(document).ready(function () {
            $('#contractButton').on('click', function () {
                $('#contractModal').modal('show');
            })
        })
    </script>



    <script>
        const addHotelShow = () => {
            let showAddHotelBtn = document.getElementById('btnAddEventHotel')
            let addHotelModal = document.getElementById('addEventHotelModal')
            console.log(showAddHotelBtn)
            console.log(addHotelModal)

            showAddHotelBtn.addEventListener("click", function () {
                $('#addEventHotelModal').modal('show')
            })
        }


        addHotelShow()



        // $(document).ready(function() {
        //     $('#btnAddEventHotel').on('click', function() {
        //         $('#addEventHotelModal').modal('show');
        //     })
        // })
    </script>


    <!-- /////////////// Start - Obługa edycji hotelu w rezerwacji ///////////////////////////////// -->
    <script>
        $(document).ready(function () {
            $('.eventHotelEditBtn').on('click', function () {
                $('#eventHotelEditModal').modal('show');

                $tr = $(this).closest('tr');

                var eventHotelData = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();

                var eStartTime = new Date(eventHotelData[1]);
                var localHotelTime = eStartTime.getTimezoneOffset() / 60
                eStartTime.setHours(eStartTime.getHours() - localHotelTime);

                eStartTime = eStartTime.toISOString().slice(0, -1);
                console.log(eStartTime);
                var a = document.getElementById(
                    "eHotelStart").defaultValue = eStartTime;


                var eEndTime = new Date(eventHotelData[2]);
                eEndTime.setHours(eEndTime.getHours() - localHotelTime);

                eEndTime = eEndTime.toISOString().slice(0, -1);
                console.log(eventHotelData);
                var b = document.getElementById(
                    "eHotelEnd").defaultValue = eEndTime;

                // $('#eHotelEnd').val(eventHotelData[2]);

                $('#eHotelRooms').val(eventHotelData[7]);

                $('#eHotelNote').val(eventHotelData[8]);

                $('#eHotelId').val(eventHotelData[0]);

                document.getElementById('eHotelName') = eventHotelData[3].innerText;




            })
        })
    </script>






    <!-- /////////////// Koniec - Obługa edycji hotelu w rezerwacji ///////////////////////////////// -->




    <script>
        $(document).ready(function () {

            $('.editbtn').on('click', function () {

                $('#eventElementEditModal').modal('show');

                $tr = $(this).closest('tr');

                var data = $tr.children("td").map(function () {
                    return $(this).text();
                }).get();


                // var data = $tr.children("td").map(function () {
                //     return $(this).text();
                // }).get();


                $('#elementId').val(data[0]);
                // $('#elementStart').val(data[1]);
                var startTime = new Date(data[1]);
                var localTime = startTime.getTimezoneOffset() / 60
                startTime.setHours(startTime.getHours() - localTime);
                console.log(startTime);
                startTime = startTime.toISOString().slice(0, -1);


                var c = document.getElementById(
                    "elementStart").defaultValue = startTime;



                var endTime = new Date(data[2]);
                endTime.setHours(endTime.getHours() - localTime);

                endTime = endTime.toISOString().slice(0, -1);

                var d = document.getElementById(
                    "elementEnd").defaultValue = endTime;

                // $('#elementEnd').val(data[2]);

                $('#elementName').val(data[3]);
                $('#elementDescription').val(data[4]);
                $('#elementContact').val(data[5]);
                $('#elementReservation').val(data[6]);
                $('#elementNote').val(data[7]);

                $('#elementHotelPrint').val(data[8]);
                document.getElementById("elementHotelPrint").innerHTML = data[8];

                $('#elementPilotPrint').val(data[9]);
                document.getElementById("elementPilotPrint").innerHTML = data[9];



            });
        });
    </script>

    <!-- <script>

            </script> -->
@endsection