<div class="modal fade" id="createNoteModal{{$todoId}}" tabindex="-1" role="dialog" aria-labelledby="createNoteModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj komentarz</h4>
                </div>
            </div>

            <div class="modal-body">
                <form action="/notes" method="POST">
            @csrf
            <input type="hidden" class="form-control" name="author_id" value="{{ Auth::user()->id }}">
            <input type="hidden" class="form-control" name="todo_id" value="{{$todoId}}">
            <input type="hidden" class="form-control" name="event_id" value="{{$eventId}}">


            <div class="row">
                <div class="col">

                    <label for="name">Komentarz:</label>
                    <textarea class="form-control form-control-border m-3" name="name" placeholder="wpisz komentarz"></textarea>

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
</div>

