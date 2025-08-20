@php

$contractorTypes =  \App\Models\ContractorType::get();

@endphp


<div class="modal fade" id="addAdvanceModal" tabindex="-1" role="dialog" aria-labelledby="addElementContractorModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
             <form action="/advance" method="POST">
                @csrf            
                    <div class="modal-header">
                        <div class="modal-title">
                            <h4>Dodaj zaliczkę</h4>
                            <input type="hidden" name="payment_id" id="addAdvancePId" value="1">

                        </div>
                    </div>

                    {{-- TODO - zrobić wybór typu kontrahenta --}}

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="name" class="awesome">Nazwa</label>
                                <input type="text" name="name" class="form-control">
                                <label for="desc" class="awesome">Opis</label>
                                <textarea name="desc" class="summernoteeditor"></textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="advance_date" class="awesome">Data płatności</label>
                                <input type="datetime-local" name="advance_date" class="form-control defaultTime">
                                <label for="total" class="awesome">Kwota</label>
                                <input type="text" name="total" class="form-control" value="0">
                                <label for="currency_id" class="awesome">Waluta</label>
                                <select name="currency_id" class="form-select">
                                    @foreach($currencies as $currency)
                                        <option value="{{$currency->id}}"
                                        @if($currency->id === 1)
                                         selected
                                        @endif
                                        >{{$currency->symbol}}

                                </option>
                                    @endforeach
                                </select>
                                {{-- TODO - dopisać wybór sposobu płatności --}}
                                {{-- <input type="hidden" name="paymenttype_id" value="0"> --}}
                                <label for="paymenttype_id" class="awesome">Sposób płatności</label>
                                <select name="paymenttype_id" class="form-select">
                                    @foreach($paymenttypes as $paymenttype)
                                        <option value="{{$paymenttype->id}}"
                                            @if($paymenttype->id === 1)
                                              selected 
                                            @endif
                                            >
                                             {{$paymenttype->name}}</option>

                                    @endforeach
                                </select>
                            </div>
                        </div>

 
                    </div>  
            <div class="modal-bottom">
                <div class="btn-group m-3 float-end" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
                </div>
            </form>
        </div>
    </div>

