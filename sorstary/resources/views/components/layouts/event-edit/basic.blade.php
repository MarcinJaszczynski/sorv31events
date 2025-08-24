<div class="invoice p-3 mb-3">
        <div class="row">
            <div class="col-12">
                <h4>
                    <i class="fas fa-globe"></i> {!! $event->eventName !!}
                    <small class="float-right">Termin: {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}</small>
                </h4>
            </div>
        </div>

        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <strong>Dla:</strong>
                <address>
                    @if(!$event->purchaser_id)
                        <div class="form-group">
                            <b>Nazwa firmy/szkoły:</b>
                            {!! Form::text('eventPurchaserName', $event->eventPurchaserName, array('placeholder' => 'Nazwa','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <b>Ulica/nr posesji:</b>
                            {!! Form::text('eventPurchaserStreet', $event->eventPurchaserStreet, array('placeholder' => 'Ulica','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <b>Miejscowośś:</b>
                            {!! Form::text('eventPurchaserCity', $event->eventPurchaserCity, array('placeholder' => 'miejscowość','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <b>NIP:</b>
                            {!! Form::text('eventPurchaserNip', $event->eventPurchaserNip, array('placeholder' => 'Nip','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <b>Osoba kontaktowa:</b>
                            {!! Form::text('eventPurchaserContactPerson', $event->eventPurchaserContactPerson, array('placeholder' => 'Imię i nazwisko','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <b>telefon kontaktowy:</b>
                            {!! Form::text('eventPurchaserTel', $event->eventPurchaserTel, array('placeholder' => '0000','class' => 'form-control')) !!}
                        </div>
                        <div class="form-group">
                            <b>email:</b>
                            {!! Form::email('eventPurchaserEmail', $event->eventPurchaserEmail, array('placeholder' => 'email@test.pl','class' => 'form-control')) !!}
                        </div>
                    @else
                        @php
                            $purchaser = \App\Models\Contractor::where('id', $event->purchaser_id)->get();
                        @endphp
                        {{-- {{ $purchaser->name }} --}}
                        @foreach($purchaser as $pur)
                        <div><b>Nazwa:</b> {{$pur->name}}</div>
                        <div><b>Kontakt:</b> {{$pur->firstname}} {{$pur->surnamename}}</div>
                        <div><b>Adres:</b> {{$pur->street}}, {{$pur->city}}</div>
                        <div><b>email:</b> {{$pur->email}} </div>
                        <div><b>telefon:</b> {{$pur->phone}}</div>
                        @endforeach    
                    @endif
                </address>
            </div>

            <div class="col-sm-4 invoice-col">
            <b>Przewoźnik:</b><br>
            <address>
                @php
                    $drivers = DB::table('event_driver')->where('event_id','=',$event->id)->get();
                    foreach($drivers as $driver){
                    // $single_driver = DB::table('contrators')->where('id','=', $driver->name)->get();
                    $one_driver = \App\Models\Contractor::where('id','=',$driver->contractor_id)->get();
                    foreach($one_driver as $one){
                    echo('<b>Nazwa:</b> '.$one->name.'<br>');
                    echo('<b>Imię: </b> '.$one->firstname.' <b>Nazwisko: </b>'.$one->surname.'<br>');
                    echo('<b>Ulica: </b> '.$one->street.' <b>Miasto: </b>'.$one->city.'<br>');
                    echo('<b>tel.: </b> '.$one->phone.'</br>');
                    echo('<b>email: </b>'.$one->email.'<br>');
                    }
                    }
                @endphp
            <br>
            DODAĆ WYBÓR:::
        </div>
    </div>
</div>

