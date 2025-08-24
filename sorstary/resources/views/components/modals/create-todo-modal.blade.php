<div class="modal fade" id="todoCreateModal" tabindex="-1" role="dialog" aria-labelledby="todoCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content"> 
            <form action="/todo" method="POST">
            @csrf           
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj zadanie 1</h4>
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" class="form-control" name="principal_id" value="{{ Auth::user()->id }}">
                @isset($event->id)
                    <input type="hidden" class="form-control" name="event_id" value="{!! $event->id !!}">
                @endisset
                <input type="hidden" class="form-control" name="status_id" value="1">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="name" class="col-sm-3 col-form-label">Nazwa</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="name" name="name" value="nazwa" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="deadline" class="col-sm-3 col-form-label">Data wykonania: </label>
                            <div class="col-sm-9">
                                {{ Form::input('dateTime-local', 'deadline', date('Y-m-d H:i',  null) , [ 'class' => 'form-control']) }}
                                {{-- {{ Form::input('date', 'deadline', null, ['id' => 'deadline', 'class' => 'form-control']) }} --}}

                                {{-- <input type="datetime-local" class="form-control" id="deadline" name="deadline"  required> --}}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label for="executor_id" class="col-sm-3 col-form-label">Wykonawca: </label>
                            <div class="col-sm-9">
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
                    </div>
                    <div class="col-md-6">
                        <div class="row">                
                            <div class="col-6">
                                <div class="form-group row">
                                    <div class="offset-sm-3">
                                        <div class="form-check">
                                            <div>
                                                <input type="radio" class="form-check-input" id="urgent_0" name="urgent" value="0" checked>
                                                <label class="form-check-label" for="urgent_0"> - Zwykłe </label>
                                            </div>
                                        <div>
                                        <input type="radio" class="form-check-input" id="urgent_1" name="urgent" value="1">
                                        <label class="form-check-label" for="urgent_1"> - PILNE </label>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>
                        <div class="col-6">
                            <div class="form-group row">
                                <div class="offset-sm-3">
                                    <div class="form-check">

                                        <div>
                                            <input type="checkbox" class="form-check-input" name="private" value="0" checked>
                                            <label class="form-check-label" for="private_1"> - zwykłe </label>
                                        </div>
                                        <div>
                                            <input type="checkbox" class="form-check-input" name="private" value="1">
                                            <label class="form-check-label" for="private_1"> - PRYWATNE </label>
                                        </div>
                                    </div>
                                </div>
                            </div>     
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col-12">
                            <label for="description">notatki: </label>
                            <textarea class="summernoteeditor" name="description"></textarea>
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