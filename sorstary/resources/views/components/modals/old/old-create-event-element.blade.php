@php
    $contractorTypes =  \App\Models\ContractorType::get();
    $currencyTypes = \App\Models\Currency::get();
@endphp
<div class="modal fade" id="createEventElementModal" role="dialog" aria-labbeledby="createEventElementLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="/eventelements" method="POST">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5>Dodaj nowy punkt programu:</h5>
                </div>

                <div class="modal-body">
                        <input type="hidden" name="eventIdinEventElements" value="{{ $event->id }}">
                        <input type="hidden" name="last_change_user_id" value="{{ Auth::user()->id }}">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <label for="element_name" class="awesome">Punkt programu</label>
                                <input type="text" name="element_name" id="element_name_field" class="form-control form-control-border" placeholder="Nazwa">                                
                            </div>
                            <div class="col-md-3">
                                <label for="booking">rezerwacja:</label>
                                <select name="booking" class="form-select form-control-border">
                                    <option value="brak rezerwacji">brak rezerwacji</option>
                                    <option value="rezerwacja">rezerwacja</option>
                                    <option value="do anulacji">do anulacji</option>
                                    <option value="anulowany">anulowany</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-3">                        
                                <label for="eventElementStart" class="awesome">Start</label>
                                <input type="datetime-local" name="eventElementStart" id="elementStart" class="form-control" value={{date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime))}}>
                            </div> 
                            <div class="col-md-2">
                                <label for="elementduration" class="awesome">Długość(godz./min)>
                                <input type="time" name="elementduration" id="elementduration" class="form-control" value="00:00">
                            </div>              
                            <div class="col-md-3">
                                <label for="eventElementEnd" class="awesome">Koniec</label>
                                <input type="datetime-local" name="eventElementEnd" id="elementEnd" class="form-control" data-time-start={{$event->eventStartDateTime}} data-time-end={{$event->eventEndDateTime}}>
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('eventElementPilotPrint', 'Druk pilot', array('class' => 'awesome')) }}
                                {{ Form::select('eventElementPilotPrint', [ 'tak' => 'tak', 'nie' => 'nie'], null, ['class'=>'form-select']) }}
                            </div>
                            <div class="col-md-2">
                                {{ Form::label('eventElementHotelPrint', 'Druk hotel', array('class' => 'awesome')) }}
                                {{ Form::select('eventElementHotelPrint', ['nie' => 'nie', 'tak' => 'tak'], null, ['class'=>'form-select ']) }}
                            </div>
                        </div>
                        <div class="row mb-3">                                                    
                            <div class="col-md-6">
                                <label for="eventElementDescription" class="awesome">Opis do programu</label>
                                <textarea name="eventElementDescription" id="elementDescriptionField" class="form-control summernoteeditor"></textarea>

                                <label for="eventElementNote" class="awesome">Notatki dla biura(niewidoczne dla hotelu i pilota</label>
                                <textarea name="eventElementNote" id="elementNoteField" class="form-control summernoteeditor"></textarea>                   
                            </div>
                            <div class="col-md-6">
                                <label for="eventElementContact" class="awesome">Kontakt/miejsce</label>
                                <textarea name="eventElementContact" id="elementContactField" class="form-control summernoteeditor"></textarea> 

                                <label for="eventElementReservationt" class="awesome">Rezerwacje/ustalenia</label>
                                <textarea name="eventElementReservation" id="elementReservationField" class="form-control summernoteeditor"></textarea>                            
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Zapisz</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                    </div>
            </form>
        </div>
    </div>
</div>
    
