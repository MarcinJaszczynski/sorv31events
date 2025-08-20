@extends('layouts.app')
@section('content')
<div class="container">
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
        <div class="card">
            <div class="card-header">Utwórz imprezę
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('events.index') }}">Imprezy</a>
                </span>
            </div>
            <div class="card-body">
                <div class="card-text">
                {!! Form::open(array('route' => 'events.store', 'method'=>'POST')) !!}

                <div class="row">
                    <div class="col-md-8">
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
                                            {!! Form::text('eventOfficeId', now()->format('Ymd/Hi'), array('placeholder' => now()->format('Ymd/Hi'),'class' => 'form-control')) !!}

                                        </div>

                                        <div class="form-group">
                                            <strong>Zaliczka dla pilota:</strong>
                                            {!! Form::text('eventAdvancePayment', null, array('placeholder' => '0','class' => 'form-control')) !!}
                                        </div>

                                        <div class="form-group">
                                        <strong>Status imprezy:</strong>

                                            <select name="eventStatus" id="eventStatus" class="form-select">
                                            <option value="Zapytanie">Zapytanie</option>
                                            <option value="Oferta">Oferta</option>
                                                <option value="Potwierdzona">Potwierdzona</option>
                                                 </select>
                                        </div>
<hr>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Kierowcy: imię nazwisko tel.:</div>
                                                    <div class="card-body">
                                                        <div class="card-text">
                                                            <!-- Start - Dane kierowcy -->

                                    {!! Form::textarea('eventDriver', null, array('class' => 'form-control')) !!}

                                                            <!-- End - Dane kierowcy -->
                                                        
                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                            <div class="col-md-6">
                                            <div class="card">
                                                    <div class="card-header">Piloci: imię nazwisko tel.:</div>
                                                    <div class="card-body">
                                                        <div class="card-text">
                                                            <!-- Start - dane pilota -->

                                                        {!! Form::textarea('eventPilot', null, array('class' => 'form-control', 'rows'=>'2')) !!}
                                                </div>
                                                <!-- End - dane pilota -->
                                            </div>
                                            </div>
                                            <div class="card">
                                                    <div class="card-header">Uwagi dla pilota:</div>
                                                    <div class="card-body">
                                                        <div class="card-text">
                                                            <!-- Start - notatki dla pilota -->

                                                        {!! Form::textarea('eventPilotNotes', null, array('class' => 'form-control', 'rows'=>'4')) !!}

                                                        <!-- End - notatki do pilota -->


                                                </div>
                                            </div>
                                            </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                Dane zamawiającego:
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
                                    <strong>Miejscowość:</strong>
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
                                    {!! Form::text('eventPurchaserTel', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>
                                <div class="form-group">
                                    <strong>email:</strong>
                                    {!! Form::email('eventPurchaserEmail', null, array('placeholder' => '','class' => 'form-control')) !!}
                                </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                    
                </div>
            </div>

                    <div class="container">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">Uczestnicy</div>
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

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">Podstawienie:</div>



                                <div class="card-body">
                                    
                                    <div class="card-text">
                                    <strong>Godzina podstawienia</strong>
                                    <div class="form-group">
                                        {{ Form::input('dateTime-local', 'busBoardTime', null, ['id' => 'game-date-time-text', 'class' => 'form-control']) }}
                                    <strong>Godzina odjazdu</strong>
                                    <div class="form-group">
                                        {{ Form::input('dateTime-local', 'eventStartDateTime', null, ['id' => 'game-date-time-text', 'class' => 'form-control']) }}


                                        <strong>Miejsce podstawienia, uwagi itp.:</strong>


                                        </div>
                                        {!! Form::textarea('eventStartDescription', null, array('placeholder' => 'Uwagi do podstawienia','class' => 'form-control')) !!}
                                        

                                    </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-header">Powrót:</div>
                                <div class="card-body">
                                <div class="form-group">
                                    <strong>Godzina powrotu</strong>

                                        {{ Form::input('dateTime-local', 'eventEndDateTime', null, ['id' => 'game-date-time-text', 'class' => 'form-control']) }}

                                        </div>
                                        <strong>Informacje o wycieczce: </strong>

                                    <div class="card-text">
                                        {!! Form::textarea('eventEndDescription', null, array('placeholder' => 'Uwagi do powrotu','class' => 'form-control')) !!}
                                        

                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>

                        


                    </div>
                    
                    <div class="form-group">
                        <strong>Notatki:</strong>
                        {!! Form::textarea('eventNote', null, array('placeholder' => 'Notatki','class' => 'form-control', 'id'=>'editEventNote')) !!}
                    </div>



                    <div class="form-group">
                        
                    </div>

                    <div class="form-group">
                        
                    </div>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
    

    <script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script></div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



<script>
    $(document).ready(function() {
        $(".editEventNote").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script>
@endsection


