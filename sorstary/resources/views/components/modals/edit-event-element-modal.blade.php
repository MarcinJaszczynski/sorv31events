@php
    $contractorTypes =  \App\Models\ContractorType::get();
    $currencyTypes = \App\Models\Currency::get();
@endphp
<div class="modal fade" id="editEventElementModal" role="dialog" aria-labbeledby="editEventElementLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <form id="elementEditModal_formUrl" method="POST" action="">
                @method('PATCH')
                @csrf
                <div class="modal-header">
                    <h5>Edytuj punkt programu:</h5>
                </div>

                <div class="modal-body">
                        <input type="hidden" name="id" value="" id="editElementModal_elementId">
                        <input type="hidden" name="eventIdinEventElements" id="editElementModale_eventId" value="">
                        <input type="hidden" name="last_change_user_id" value="{{ Auth::user()->id }}">
                        <div class="row mb-3">
                            <div class="col-md-9">
                                <label for="element_name" class="awesome">Punkt programu</label>
                                <input type="text" name="element_name" id="editElementModale_element_name_field" class="form-control form-control-border" placeholder="Nazwa">                                
                            </div>
                            <div class="col-md-3">
                                <div>
                                    <label for="active" class="">
                                        <span class="">Aktywny: </span>
                                    </label>
                                        <input type="checkbox" class="" name="active" id="element_active">
                                </div>
                                <label for="booking">rezerwacja:</label>
                                <select id="editElementModal_booking" name="booking" class="form-select form-control-border">
                                    <option value="0">brak rezerwacji</option>
                                    <option value="1">do rezerwacji</option>
                                    <option value="2">rezerwacja</option>
                                    <option value="3">do anulacji</option>
                                    <option value="4">anulowany</option>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-4">                        
                                <label for="eventElementStart" class="awesome">Start</label>
                                <input type="datetime-local" name="eventElementStart" id="editElementModale_elementStart" class="form-control" value=''>
                            </div> 
                            {{-- <div class="col-md-2">
                                <label for="elementduration" class="awesome">Długość(godz./min)</label>
                                <input type="time" name="elementduration" id="editElementModale_elementduration" class="form-control" value="00:00">
                            </div>               --}}
                            <div class="col-md-4">
                                <label for="eventElementEnd" class="awesome">Koniec</label>
                                <input type="datetime-local" name="eventElementEnd" id="editElementModale_elementEnd" class="form-control" data-time-start='' data-time-end=''>
                            </div>
                            <div class="col-md-2">
                                <label for="eventElementPilotPrint" class="awesome">Druk pilot</label>
                                <select name="eventElementPilotPrint" id="editElementModale_eventElementPilotPrint" class="form-select">
                                    <option value="tak">tak</option>
                                    <option value="nie">nie</option>
                                </select>                                
                            </div>
                            <div class="col-md-2">
                                <label for="eventElementHotelPrint" class="awesome">Druk hotele</label>
                                <select name="eventElementHotelPrint" id="editElementModale_eventElementHotelPrint" class="form-select">
                                    <option value="tak">tak</option>
                                    <option value="nie">nie</option>
                                </select>                                
                            </div>
                        </div>
                        <div class="row mb-3">                                                    
                            <div class="col-md-4">
                                <label for="eventElementDescription" class="awesome">Opis do programu</label>
                                <textarea name="eventElementDescription" id="editElementModale_elementDescriptionField" class="form-control summernoteeditor"></textarea>
                            </div>
                            <div class="col-md-4">
                                <label for="eventElementNote" class="awesome">Notatki dla biura(niewidoczne dla hotelu i pilota</label>
                                <textarea name="eventElementNote" id="editElementModale_eventElementNote" class="form-control summernoteeditor"></textarea>                   
                            </div>
                            <div class="col-md-4">
                                <label for="eventElementReservationt" class="awesome">Rezerwacje/ustalenia</label>
                                <textarea name="eventElementReservation" id="editElementModale_eventElementReservation" class="form-control summernoteeditor"></textarea>                            
                            </div>
                        </div>
                    </div>
            <div class="modal-bottom">
                <div class="btn-group m-3 float-end" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>