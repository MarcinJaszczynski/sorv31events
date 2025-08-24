
{{-- <div class="modal fade" id="addPaymentModal" tabindex="-1" role="dialog" aria-labelledby="addPaymentModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj wydatek</h4>
                </div>
            </div>

            <div class="modal-body">
                <div class="modal-text">
                    <div class="row">
                        <div class="col-md-4">
                            <h4>Dane podstawowe</h4>
                            <label for="paymentName" class="awesome">Nazwa</label>
                            <input type="text" name="paymentName" class="form-control">
                            <label for="paymentDescription" class="awesome">Opis</label>
                            <textarea name="paymentDescription" class="summernoteeditor"></textarea>
                        </div>
                        <div class="col-md-4">
                            <h4>Dane kontrahenta</h4>
                            
                        </div>
                        <div class="col-md-4">
                            <h4 class="mb-3">Wydatki planowane</h4>
                            <div class="row mb-3">
                                <div class="col-sm">
                                    <label for="plannedPrice" class="awesome ">Cena jedn.</label>
                                    <input type="text" name="plannedPrice" id="plannedPrice" class="form-control listenerArea">
                                </div>
                                <div class="col-sm">
                                    <label for="plannedQty" class="awesome">Ilość</label>
                                    <input type="text" name="plannedQty" id="plannedQty" class="form-control listenerArea">
                                </div>
                                <div class="col-sm">
                                    <label for="plannedQty" class="awesome">Ilość</label>
                                    <input type="text" name="plannedQty" id="plannedQty" class="form-control listenerArea">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="" id="plannedTotal">
                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-3">Wydatki rzeczywiste</h4>
                            <label for="advance" class="awesome">Nazwa</label>
                            <input type="text" name="paymentName" class="form-control">
                        </div>

                    </div>
                </div>                
            </div>


                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>

        
    let plannedTotalField = document.querySelector("#plannedTotal");
    let plannedPriceField = document.querySelector("#plannedPrice");
    let plannedQtyField = document.querySelector("#plannedQtyField");

    let countListeners = document.getElementsByClassName("listenerArea")
    for(let i=0; i<countListeners.length; i++){
    countListeners[i].addEventListener('keyup', ()=>
   {        
        plannedTotalField.innerText = plannedPrice.value * plannedQty.value
   })
}
</script> --}}


@php
    
@endphp

<div class="modal fade" id="addPaymentModal" role="dialog" aria-labelledby="addPaymentModal" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Dodaj nowy wydatek</h4>
            </div>
            {{ Form::open(array('url' => 'eventPayments/store', 'method' => 'post')) }}
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="element_id" id="payment_modal_element_id">
            <div class="modal-body">
                <div class="modal-text">

                    <div class="row">
                        <div class="col-md-4">
                            <label for="paymentName" class="awesome">Wydatek</label>
                            <input type="text" name="paymentName" id="payment_modal_element_name" class="form-control" placeholder="Nazwa" value="">
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
                                <div class="col-md-4">
                                    <label for="plannedPrice" class="awesome">Cena jedn.</label>
                                    <input type="text" name="plannedPrice" id="add_plannedPrice" class="form-control totalinput" value="0">
                                </div>

                                <div class="col-md-4">
                                    <label for="plannedQty" class="awesome">sztuk</label>
                                    <input type="text" name="plannedQty" id="add_plannedQty" class="form-control totalinput" value="1">
                                </div>

                                <div class="col-md-4">
                                    <label for="planned_currency_id" class="awesome">waluta</label>
                                    <select name="planned_currency_id" id="add_planned_currency_id" class="form-select">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}
                                    @endforeach
                                    </select>
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
                            
                                <div class="col-md-4">
                                    <label for="plannedPrice" class="awesome">Cena jedn.</label>
                                    <input type="text" name="price" id="price" class="form-control totalinput" value="0">
                                </div>

                                <div class="col-md-4">
                                    <label for="plannedQty" class="awesome">sztuk</label>
                                    <input type="text" name="qty" id="qty" class="form-control totalinput" value="1">
                                </div>

                                <div class="col-md-4">
                                    <label for="planned_currency_id" class="awesome">waluta</label>
                                    <select name="currency_id" id="currency_id" class="form-select">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}">{{$currency->symbol}}
                                    @endforeach
                                    </select>
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






    
    
    
    
    
 
