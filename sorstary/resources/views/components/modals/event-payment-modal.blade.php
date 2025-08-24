<div class="modal fade" id="editCostModal" role="dialog" aria-labelledby="editCostLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Dodaj/Edytuj płatność</h4>
            </div>
            {{ Form::open(array('url' => 'eventPayments/update', 'method' => 'put')) }}
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="id" value="" id="id">

            <div class="modal-body">
                <div class="modal-text">

                    <div class="row  mb-3">
                        <div class="col-6">
                            <label for="paymentName">Płatność: </label>
                            <input type="text" name="paymentName" id="paymentname" class="form-control">
                        </div>
                        <div class="col-6">
                            <label for="paymentDescription" class="awesome">Status:</label>
                            <input type="text" class="form-control"></input> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <h5>Opis: </h5>
                            <label for="paymentDescription" class="awesome">Opis:</label>
                            <textarea name="paymentDescription" id="paymentdescription" class="summernoteeditor form-control"></textarea>                            
                        </div>
                        <div class="col-md-4">
                            <h5>Kontrahent: </h5>                        
                            
                                                       
                        </div>
                        <div class="col-md-4">
                            <h5>Zaliczka: </h5>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="advanceDate" class="awesome">Data:</label>
                                    <input type="text" class="form-control" id="advanceDate"></input> 
                                </div>
                                <div class="col-4">
                                    <label for="advanceAmount" class="awesome">Kwota:</label>
                                    <input type="text" class="form-control" name="advanceAmount" id="advanceAmount"></input> 
                                </div>
                                <div class="col-4">
                                    <label for="advanceCurrency" class="awesome">Waluta:</label>
                                    <input type="text" class="form-control" name="advanceCurrency" id="advanceCurrency"></input> 
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <label for="advanceDescription">Uwagi do zaliczki</label>
                                    <textarea name="advanceDescription" id="advanceDescription" class="summernoteeditor form-control"></textarea>
                                </div>
                            </div>
                            <h5>Wydatki planowane: </h5>
                            <div class="row mb-3">
                                <div class="col-4">
                                    <label for="paymentDescription" class="awesome">C.jedn.:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>
                                <div class="col-4">
                                    <label for="paymentDescription" class="awesome">Ilość:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>
                                <div class="col-4">
                                    <label for="paymentDescription" class="awesome">Waluta:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>
                            </div>
                            
                            <h5>Wydatki rzeczywiste: </h5>
                            <div class="row">
                                <div class="col-12">
                                    <label for="paymentDescription" class="awesome">Dokument zakupu:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>
                                <div class="col-12">
                                    <label for="paymentDescription" class="awesome">Data:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <label for="paymentDescription" class="awesome">C.jedn.:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>
                                <div class="col-4">
                                    <label for="paymentDescription" class="awesome">Ilość:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>
                                <div class="col-4">
                                    <label for="paymentDescription" class="awesome">Waluta:</label>
                                    <input type="text" class="form-control"></input> 
                                </div>

                            </div>
                            
                           
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-bottom">
                <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>