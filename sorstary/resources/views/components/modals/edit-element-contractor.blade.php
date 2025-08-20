<div class="modal fade" id="editElementContractorModal" tabindex="-1" role="dialog" aria-labelledby="createNoteModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Edytuj ustalenia</h4>
                </div>
            </div>

            <div class="modal-body">
                <form action="/eventcontractors/updateeventcontractor" method="POST">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" id="editContractorModal_eventcontractor_id_form" class="form-control" name="id" value="">
                    <input type="hidden" id="editContractorModal_eventid_form" class="form-control" name="event_id" value="">
                    <input type='hidden' id="editContractorModal_contractortype_id_form" name='contractortype_id' value=''>
                    <input type='hidden' id="editContractorModal_contractor_id_form" name='contractor_id' value=''>
                <div>Impreza: <span id="editContractorModal_eventid"></span></div>
                <hr>  
                <div>Kontrahent: <span id="editContractorModal_contractordata"></span></div>
                <hr>  
                <div class="col">                    
                    <div id="hotelslist"></div>
                    <label for="desc">Notatki</label>
                    <textarea id="editContractorModal_desc" name="desc" class="summernoteeditor"></textarea>

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

