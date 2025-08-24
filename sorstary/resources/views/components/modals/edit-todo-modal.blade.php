<form action="/todo/{{ $todo->id }}" method="POST">
    @csrf
    @method('PATCH')
    <div class="modal fade" id="editTodoModal{{$todo->id}}" tabindex="-1" role="dialog" aria-labelledby="todoCreateModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">            
                <div class="modal-header">
                    <div class="modal-title">
                        <h4>Edytuj zadanie - {{$todo->name}}</h4>
                                                @isset($todo->event_id)
                            <div><strong>Impreza: </strong><span>{{ $todo->event->eventName }}</span></div>
                        @endisset
                    </div>
                </div>
                <div class="modal-body">
                {{-- <input type="hidden" class="form-control" name="principal_id" value="{{ Auth::user()->id }}"> --}}

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Nazwa</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="name" name="name" value="{{$todo->name}}" required>
                            </div>
                        </div>
                 
                        @isset($event->id)
                            <input type="hidden" class="form-control" name="event_id" value="{{ $event->id }}">
                        @endisset

                        <div class="form-group row">
                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                            <div class="col-sm-8">
                                <select name="status_id" id="status_id">
                                    <option value="{{$todo->status_id}}">{{$todo->status->name}}</option>
                                    @foreach($todoStatuses as $todoStatus)
                                        @if($todoStatus->id !== $todo->status_id)
                                            <option value="{{$todoStatus->id}}">{{ $todoStatus->name }}</option>
                                        @endif
                                    @endforeach                                    
                                </select>
                            </div>
                        </div>                                                                                                                                                          
                        <div class="form-group row">
                            <label for="deadline" class="col-sm-4 col-form-label">Data wykonania: </label>
                            <div class="col-sm-8">
                                {{ Form::input('dateTime-local', 'deadline', date('Y-m-d\TH:i',  strtotime($todo->deadline)) , [ 'class' => 'form-control']) }}
                            </div>
                        </div>    
                        <div class="form-group row">
                            <label for="executor_id" class="col-sm-4 col-form-label">Wykonawca: </label>
                            <div class="col-sm-8">
                                <select name="executor_id" id="executor_id">
                                    <option value="{{ $todo->executor_id }} ">{!!$todo->executor->name!!}</option>
                                    @foreach($executors as $executor)
                                    @if($todo->executor_id != $executor->id)
                                    <option value="{{$executor->id}}">{{$executor->name}}</option>
                                    @endif
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
                                            <input type="radio" class="form-check-input" id="urgent_0" name="urgent" value="0" 
                                            @if($todo->urgent===0)
                                            checked
                                            @endif
                                            >
                                            <label class="form-check-label" for="urgent_0"> - Zwykłe </label>
                                            </div>
                                            <div>
                                            <input type="radio" class="form-check-input" id="urgent_1" name="urgent" value="1"
                                            @if($todo->urgent===1)
                                            checked
                                            @endif>
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
                                                <input type="radio" class="form-check-input" name="private" value="0" 
                                                @if($todo->private === 0)
                                                checked
                                                @endif
                                                >
                                                <label class="form-check-label" for="private_1"> - zwykłe </label>
                                            </div>
                                            <div>
                                                <input type="radio" class="form-check-input" name="private" value="1"
                                                @if($todo->private === 1)
                                                checked
                                                @endif>
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
                            <textarea class="form-control form-control-border" name="description">{!! $todo->description !!}</textarea>
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
        
