<div class="modal fade" id="addEventPurchaserModal" tabindex="-1" role="dialog" aria-labelledby="createNoteModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj klienta</h4>
                </div>
            </div>

            <div class="modal-body">
                <form action="/eventcontractors" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="event_id" value="{{$eventid}}">
                    <input type='hidden' name='contractortype_id' value='4'>
                <div>nr imprezy {{$eventid}}</div>
                <hr>  
                <div class="col-md-6">
                    <label for="purchasersearchfield">Wyszukaj klienta</label>
                    <input type="text" class="form-control"  name ="searchfield" placeholder="Wyszukaj klienta" id="purchasersearch" data-contractortype="4" data-dataplace="purchaserslist" class="form-control">
                    <hr>
                    <div id="purchaserslist"></div>
                </div>
                <hr>  
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
</div>

