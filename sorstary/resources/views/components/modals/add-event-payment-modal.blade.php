@php
    
@endphp

<div class="modal fade" id="createEventPaymentModal" role="dialog" aria-labelledby="createCostLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Dodaj nowy wydatek</h4>
            </div>
            {{ Form::open(array('url' => 'eventPayments/store', 'method' => 'post')) }}
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="element_id" value="">
            <div class="modal-body">
                <div class="modal-text">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="paymentName" class="awesome">Wydatek</label>
                            <input type="text" name="paymentName" class="form-control" placeholder="Nazwa">
                            <label for="paymentDescription" class="awesome">Opis</label>
                            <textarea name="paymentDescription" class="form-control summernoteeditor"></textarea>
                        </div>

                        <div class="col-md-4">
                            <label for="payer" class="awesome">Płatnik</label>
                            <select name="payer" class="form-select total-input">
                                <option value="biuro">biuro</option>
                                <option value="pilot">pilot</option>
                            </select>

                            <label for="paymentStatus" class="awesome">Status</label>
                            <select name="paymentStatus" class="form-select total-input">
                                <option value="0">niezapłacone</option>
                                <option value="1">zapłacone</option>
                            </select>

                            <label for="invoice" class="awesome">Faktura</label>
                            <input type="text" name="invoice" class="form-control" placeholder="nr dokumentu">

                            <label for="paymentDate" class="awesome">data płatności</label>
                            <input type="date" name="paymentDate" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <h4>Wydatki planowane</h4>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <label for="plannedPrice" class="awesome">Cena jedn.</label>
                                    <input type="text" name="plannedPrice" id="add_plannedPrice" class="form-control totalinput" value="0">
                                </div>

                                <div class="col-md-3">
                                    <label for="plannedQty" class="awesome">sztuk</label>
                                    <input type="text" name="plannedQty" id="add_plannedQty" class="form-control totalinput" value="1">
                                </div>

                                <div class="col-md-3">
                                    <label for="planned_currency_id" class="awesome">waluta</label>
                                    <select name="planned_currency_id" id="add_planned_currency_id" class="form-select">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}
                                    @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="plannedExchangeRate" class="awesome">kurs</label>
                                    <input type="text" name="planned_exchange_rate" id="add_plannedExchangeRate" class="form-control totalinput" value="1">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <span class="font-weight-bold">Razem: </span>
                                    <span id="planned_total" 
                                        data-price="add_plannedPrice" 
                                        data-qty="add_plannedQty" 
                                        data-currency="add_planned_currency_id">
                                    </span>
                                </div>
                            </div>

                            <h4>Wydatki poniesione</h4>

                            <div class="row mb-3">
                            
                                <div class="col-md-3">
                                    <label for="plannedPrice" class="awesome">Cena jedn.</label>
                                    <input type="text" name="price" id="price" class="form-control totalinput" value="0">
                                </div>

                                <div class="col-md-3">
                                    <label for="plannedQty" class="awesome">sztuk</label>
                                    <input type="text" name="qty" id="qty" class="form-control totalinput" value="1">
                                </div>

                                <div class="col-md-3">
                                    <label for="planned_currency_id" class="awesome">waluta</label>
                                    <select name="currency_id" id="currency_id" class="form-select">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}
                                    @endforeach
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label for="plannedExchangeRate" class="awesome">kurs</label>
                                    <input type="text" name="exchange_rate" id="add_plannedExchangeRate" class="form-control totalinput" value="1">
                                </div>

                            </div>

                            <div class="row mb-3">
                                <div class="col">
                                    <span class="font-weight-bold">Razem: </span>
                                    <span id="total"
                                    data-price="price" 
                                    data-qty="qty" 
                                    data-currency="currency_id"></span>
                                </div>
                            </div>                            
                        </div> 
                    </div>
                </div>
            </div>
            <div class="modal-bottom">
                <div class="btn-group m-3 float-end" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<script>

</script>

