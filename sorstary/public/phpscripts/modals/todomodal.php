<!-- ///////////////////////////// StartCreateTodoModal ////////////////////////////////////////// -->

<div class="modal fade" id="todoCreateModal" role="dialog" aria-labellby="todoCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5>Dodaj zadanie do imprezy</h5>
            </div>
            <div class="container">
                <form action="/todo" method="POST">
                    @csrf
                    <input type="hidden" class="form-control" name="principal_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" class="form-control" name="event_id" value="{{ $event->id }}">
                    <input type="hidden" class="form-control" name="status_id" value="1">

                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Nazwa</label>
                            <input type="text" class="form-control" id="name" name="name" value="nazwa" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="urgent">Pilne: </label>
                            <input type="checkbox" name="urgent">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="name">Termin wykonania</label>
                            <input type="date" class="form-control" id="deadline" name="deadline" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="executor_id">wykonawca: </label>
                            <select name="executor_id" id="executor_id">
                                @php
                                $executors=DB::table('users')->get();
                                @endphp
                                @foreach($executors as $executor)
                                <option value="{{$executor->id}}">{{$executor->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label for="description">notatki: </label>
                            <input type="text-area" class="form-control" id="description" name="description">
                        </div>
                    </div>
            </div>
            <div class="modal-bottom">
                <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-trash3"></i> Wyjdź</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ///////////////////////////// EndCreateTodoModal ////////////////////////////////////////// -->