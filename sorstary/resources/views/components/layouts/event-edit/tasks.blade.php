<div>
Task Editor
</div>
 {{-- <div class="card">
                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">Moje zadania</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#todoCreateModal"> Dodaj zadanie</button>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="todo-list ui-sortable" data-widget="todo-list">
                        <x-layout-elements.todos-list :todos='$todos' />
                    </ul>
                </div>

                <div class="card-header ui-sortable-handle">
                    <h3 class="card-title">Pozostałe zadania</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#todoCreateModal"> Dodaj zadanie</button>
                    </div>
                </div>

                <div class="card-body">
                    <ul class="todo-list ui-sortable" data-widget="todo-list">
                        <x-layout-elements.event-elements-list :eventElements='$eventElements' />
                    </ul>
                </div>
  </div> --}}
                 {{-- <div class="card-body">
                    <ul class="todo-list ui-sortable" data-widget="todo-list">
                        @foreach($todos as $todo)
                            @if($todo->executor_id != Auth::user()->id)
                                <li>
                                    <x-todos-list :todo='$todo' :executors:'$executor' />
                                </li>
                             @endif
                        @endforeach
                    </ul>
                </div> --}}