@php
$executors=\App\Models\User::get();
  $myTodosNew = $todos->where('executor_id', Auth::user()->id)->where('status_id', 1);
  $myTodosPending = $todos->where('executor_id', Auth::user()->id)->where('status_id', 4);
  $myTodosFinished = $todos->where('executor_id', Auth::user()->id)->where('status_id', 2);
  $myTodosAccepted = $todos->where('executor_id', Auth::user()->id)->where('status_id', 5);
  $myOrdersNew = $todos->where('principal_id', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 1);
  $myOrdersPending = $todos->where('principal_id', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 4);
  $myOrdersFinished = $todos->where('principal_id', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 2);
  $myOrdersAccepted = $todos->where('principal_id', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 5);
  $otherTodosNew = $todos->where('principal_id', '!=', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 1);
  $otherTodosPending = $todos->where('principal_id', '!=', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 4);
  $otherTodosFinished = $todos->where('principal_id', '!=', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 2);
  $otherTodosAccepted = $todos->where('principal_id', '!=', Auth::user()->id)->where('executor_id', '!=', Auth::user()->id)->where('status_id', 5);
  $myAcceptedOrders = $todos->where('principal_id', Auth::user()->id)->where('status_id', 5);  
@endphp

<div class="invoice p-3 mb-3">
  <div>
<div class="btn-group float-end" role="group" aria-label="button-add-todo">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todoCreateModal"><i class="bi bi-plus"></i> dodaj zadanie</button>
</div>
<h4>Zadania</h4>
  </div>
  <ul class="nav nav-tabs mb-3" id="eventEdit" role="tablist">
      <li class="nav-item" role="presentation">
          <button class="nav-link active" id="task-tab" data-bs-toggle="tab" data-bs-target="#task" type="button" role="tab" aria-controls="taskedit" aria-selected="true">Moje zadania</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="myorder-tab" data-bs-toggle="tab" data-bs-target="#myorders" type="button" role="tab" aria-controls="myorders" aria-selected="false">Moje zlecenia</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#alltasks" type="button" role="tab" aria-controls="alltasks" aria-selected="false">Pozostałe</button>
      </li>
      {{-- <li class="nav-item" role="presentation">
          <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#acceptedTasks" type="button" role="tab" aria-controls="accepdedtasks" aria-selected="false">Zaakceptowane</button>
      </li> --}}
    </ul>       

       
<div class="tab-content" id="myTabContent">



  {{-- {!! $acceptedTodos !!}  --}}
  <div class="tab-pane fade show active" id="task" role="tabpanel" aria-labelledby="task-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myTodosNew' :pendingTodos='$myTodosPending' :finishedTodos='$myTodosFinished' :acceptedTodos='$myTodosAccepted' />
  </div>
  <div class="tab-pane fade" id="myorders" role="tabpanel" aria-labelledby="myorders-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myOrdersNew' :pendingTodos='$myOrdersPending' :finishedTodos='$myOrdersFinished' :acceptedTodos='$myOrdersAccepted' />
  </div>
  <div class="tab-pane fade" id="alltasks" role="tabpanel" aria-labelledby="task-tab">  
        <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$otherTodosNew' :pendingTodos='$otherTodosPending' :finishedTodos='$otherTodosFinished' :acceptedTodos='$otherTodosAccepted' />     
  </div>
  {{-- <div class="tab-pane fade show active" id="task" role="tabpanel" aria-labelledby="task-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myTodosNew' :pendingTodos='$myTodosPending' :finishedTodos='$myTodosFinished' :acceptedTodos='$myTodosAccepted' />
  </div>
  <div class="tab-pane fade" id="myorders" role="tabpanel" aria-labelledby="myorders-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myOrdersNew' :pendingTodos='$myOrdersPending' :finishedTodos='$myOrdersFinished' :acceptedTodos='$myOrdersAccepted' />
  </div>
  <div class="tab-pane fade" id="alltasks" role="tabpanel" aria-labelledby="task-tab">  
        <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$otherTodosNew' :pendingTodos='$otherTodosPending' :finishedTodos='$otherTodosFinished' :acceptedTodos='$otherTodosAccepted' />     
  </div> --}}
    {{-- <div class="tab-pane fade" id="acceptedTasks" role="tabpanel" aria-labelledby="task-tab">
        <x-layout-elements.accepted-todos-list :acceptedTodos='$todos' :executors='$executors' />     
    </div>    --}}
</div>
<div class="clearfix"></div>
</div>