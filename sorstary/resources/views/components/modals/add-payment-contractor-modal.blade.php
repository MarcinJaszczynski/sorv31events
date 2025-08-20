<div class="modal fade" id="addPaymentContractor" tabindex="-1" role="dialog" aria-labelledby="addPaymentContractorModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/eventpayments/addcontractor" method="POST">
                @csrf  
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Dodaj kontrahenta</h4>
                    </div>
                </div>

                <input type="hidden" id="addContractorPaymentPaymentId" name="payment_id" value="">

                    {{-- TODO - zrobić wybór typu kontrahenta --}}

                <div class="modal-body">
                    <div class="modal-text">
                        <div id="addPaymentContractrorTitle">
                        </div>
                        <label for="payment_contractor_type" class="awesome">
                        <select name="contractortype_id" id="payment_contractor_type_select" class="form-select">
                            @foreach($contractorstypes as $type)
                                <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                        <label for="searchfield" class="awesome">Nazwa kontrahenta</label>
                        <input type="text" id="payment_contractor_search" class="form-control" 
                                data-contractortype="payment_contractor_type_select" 
                                data-dataplace="addPaymentContractorResoults"
                                placeholder="kontrahent">
                    </div>
                    <div id="addPaymentContractorResoults"></div>
                        
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

