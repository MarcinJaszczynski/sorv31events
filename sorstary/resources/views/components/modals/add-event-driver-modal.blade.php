<div class="modal fade" id="addEventDriverModal" tabindex="-1" role="dialog" aria-labelledby="createNoteModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj kierowcę do imprezy</h4>
                </div>
            </div>

            <div class="modal-body">
                <form action="/eventcontractors" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="event_id" value="{{$eventid}}">
                    <input type='hidden' name='contractortype_id' value='6'>
                <div>nr imprezy {{$eventid}}</div>
                <hr>  
                <div class="col-md-6">
                    <label for="pilotsearchfield">Wyszukaj kierowcę</label>
                    <input type="text" class="form-control"  name ="searchfield" placeholder="Wyszukaj kierowcę" id="driversearch" data-contractortype="6" data-dataplace="driverslist" class="form-control">
                    <hr>
                    <div id="driverslist"></div>
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

