{{-- ecd -- Edit Contractor Modal - przedrostek --}}
<div class="modal fade edit-contractor-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
             {{-- <form action="/contractor" method="POST"> --}}
                @csrf
                @method('patch')            
                    <div class="modal-header">
                        <div class="modal-title">
                            <h4>Edytuj kontrahenta</h4>
                            <input type="hidden" name="payment_id" id="addAdvancePaymentId" value="">

                        </div>
                    </div>


                    <div class="modal-body">
                        <div id="ecd-name">
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