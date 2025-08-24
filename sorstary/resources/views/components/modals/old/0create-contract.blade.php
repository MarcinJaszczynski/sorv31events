<div>
<div class="container">
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
                {{ Form::text('eventOfficeId', $event->eventOfficeId, ['class'=>'form-control']) }}

                {{ Form::label('contractDate', 'Data zawarcia umowy:', array('class' => 'awesome')) }}<br />
                <input type="date" name='contractDate' value="<?php echo date('Y-m-d'); ?>" />
                <br />

                {{ Form::label('eventPurchaserPerson', 'Zamawiający:', array('class' => 'awesome')) }}
                {{ Form::text('eventPurchaserContactPerson', $event->eventPurchaserContactPerson, ['class'=>'form-control']) }}

                {{ Form::label('eventType', 'Rodzaj imprezy:', array('class' => 'awesome')) }}
                {{ Form::text('eventType', 'Wycieczka szkolna', ['class'=>'form-control']) }}

                {{ Form::label('eventName', 'Nazwa imprezy:', array('class' => 'awesome')) }}
                {{ Form::text('eventName', $event->eventName, ['class'=>'form-control']) }}

                {{ Form::label('coach', 'Środek transportu:', array('class' => 'awesome')) }}
                {{ Form::text('coach', 'Autokar turystyczny', ['class'=>'form-control']) }}

                {{ Form::label('busBoardTime', 'Godzina podstawienia:', array('class' => 'awesome')) }}
                {{ Form::text('busBoardTime', date('Y-m-d\  H:i',  strtotime($event->busBoardTime)), ['class'=>'form-control']) }}



                {{ Form::label('eventStartDescription', 'Miejsce podstawienia:', array('class' => 'awesome')) }}<br>
                <textarea rows="4" , cols="54" name="eventStartDescription" style="resize:none, ">{{ $event->eventStartDescription }}
                </textarea><br />


                {{ Form::label('eventStartDateTime', 'Początek wycieczki:', array('class' => 'awesome')) }}
                {{ Form::input('dateTime-local', 'eventStartDateTime',  date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), ['class' => 'form-control']) }}

                {{ Form::label('eventEndDateTime', 'Koniec wycieczki:', array('class' => 'awesome')) }}
                {{ Form::input('dateTime-local', 'eventEndDateTime',  date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime)), ['class' => 'form-control']) }}

                {{ Form::label('eventTotalQty', 'Ilość uczestników:', array('class' => 'awesome')) }}
                {{ Form::text('eventTotalQty', $event->eventTotalQty, ['class'=>'form-control']) }}

                {{ Form::label('eventGuardiansQty', 'w tym opiekunów:', array('class' => 'awesome')) }}
                {{ Form::text('eventGuardiansQty', $event->eventGuardiansQty, ['class'=>'form-control']) }}

                {{ Form::label('eventHotel', 'Obiekt noclegowy:', array('class' => 'awesome')) }}<br />
                <textarea rows="4" , cols="54" name="eventHotel">
                @foreach($event->hotels->sortBy('eventHotelStartDate') as $hotel)
                &#13; <br />{{ $hotel->hotelName}}, {{ $hotel->hotelStreet}}, {{ $hotel->hotelCity}},

                @endforeach        
            </textarea>
                <br>

                {{ Form::label('eventFood', 'wyżywienie:', array('class' => 'awesome')) }}
                {{ Form::text('eventFood', 'zgodnie z programem', ['class'=>'form-control']) }}

                {{ Form::label('eventInsurance', 'Ubezpieczenie:', array('class' => 'awesome')) }}
                {{ Form::text('eventInsurance', 'NNW Signal Iduna do kwoty 10 000 zł/os. w wersji Standard', ['class'=>'form-control']) }}

                {{ Form::label('eventAddInfo', 'Dodatkowe informacje:', array('class' => 'awesome')) }}<br>
                <textarea rows="4" , cols="54" name="eventAddInfo" style="resize:none, ">
                &#13; Opiekę nad małoletnimi dziećmi będą sprawowali nauczyciele szkolni&#13;&#10;
            </textarea><br />

                {{ Form::label('eventPriceBrutto', 'Cena brutto:', array('class' => 'awesome')) }}
                {{ Form::text('eventPriceBrutto', 'xx zł x xx osób = xxxx zł brutto', ['class'=>'form-control']) }}

                {{ Form::label('eventPrice', 'Cena brutto słownie:', array('class' => 'awesome')) }}
                {{ Form::text('eventPrice', 'xxx złotych brutto', ['class'=>'form-control']) }}

                {{ Form::label('eventPriceInclude', 'Cena obejmuje:', array('class' => 'awesome')) }}<br>
                <textarea rows="4" , cols="54" name="eventPriceInclude" style="resize:none, ">
                &#13; przejazd autokarem, opiekę pilota, przewodników lokalnych, bilety wstępu na realizacje programu, ubezpieczenie NNW do kwoty 10 000 zł w wersji standard, podatek VAT, miejsca gratis dla opiekunów &#13;&#10;
            </textarea><br /><br />

                {{ Form::label('eventPriceType', 'Forma płatności:', array('class' => 'awesome')) }}
                {{ Form::text('eventPriceType', 'przelew', ['class'=>'form-control']) }}

                {{ Form::label('eventAdvance', 'Zaliczka:', array('class' => 'awesome')) }}
                {{ Form::text('eventAdvance', 'xxx złotych brutto', ['class'=>'form-control']) }}

                {{ Form::label('eventAdvanceTime', 'Data płatności zaliczki:', array('class' => 'awesome')) }}<br />
                <input type="date" name='eventAdvanceTime' value="<?php echo date('Y-m-d'); ?>" />
                <br />

                {{ Form::label('eventSupplement', 'Dopłata:', array('class' => 'awesome')) }}
                {{ Form::text('eventSupplement', 'xxx złotych brutto', ['class'=>'form-control']) }}

                {{ Form::label('eventSupplementTime', 'Data dopłaty całości:', array('class' => 'awesome')) }}<br />
                <input type="date" name='eventSupplementTime' value="<?php echo date('Y-m-d'); ?>" />
                <br />

                {{ Form::label('eventPaymentName', 'Tytuł wpłaty:', array('class' => 'awesome')) }}
                <input type="text" name="'eventPaymentName" class="form-control" value="{{ $event->eventName }} rezerwacja nr. {{ $event->eventOfficeId }}" </div>


                <div class="modal-bottom">
                    <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Generuj umowę</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    </div>
                </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
</div>