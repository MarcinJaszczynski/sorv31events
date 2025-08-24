<div class="modal fade" id="addEventPilotModal" tabindex="-1" role="dialog" aria-labelledby="addEventPilotModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj pilota do imprezy</h4>
                </div>
            </div>
            <form action="/eventcontractors" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="event_id" value="{{$eventid}}">
            <input type='hidden' name='contractortype_id' value='5'>                    
            <div class="modal-body">
                <div class="modal-text">
                    <div class="row">
                        <div class="col">
                            <div>nr imprezy {{$eventid}}</div>
                            <hr>  
                            <div class="col">
                                <label for="pilotsearchfield">Wyszukaj pilota</label>
                                <input type="text" class="form-control"  placeholder="Wyszukaj pilota" id="pilotsearch" data-contractortype="5" data-dataplace="pilotslist" class="form-control">
                                <hr>
                                <div id="pilotslist"></div>
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
        </form>
        </div>
    </div>
</div>

