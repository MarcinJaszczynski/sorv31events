@extends('layouts.app')
@section('content')


@php 
$todos = $data;
// $todos = \App\Models\Todo::orderBy('last_update','desc')->get();
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
$acceptedTodos = $todos->where('status_id', 5);  

$event='';
@endphp

{{-- Start Modals --}}

<x-modals.create-todo-modal :event="$event"/>

{{-- End Modals --}}

<div class="container">
<div class="btn-group float-end" role="group" aria-label="button-add-todo">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todoCreateModal">Dodaj zadanie</button>
</div>
  <ul class="nav nav-tabs" id="eventEdit" role="tablist">
      <li class="nav-item" role="presentation">
          <button class="nav-link active" id="task-tab" data-bs-toggle="tab" data-bs-target="#task" type="button" role="tab" aria-controls="taskedit" aria-selected="true">Moje zadania</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="myorder-tab" data-bs-toggle="tab" data-bs-target="#myorders" type="button" role="tab" aria-controls="myorders" aria-selected="false">Moje zlecenia</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#alltasks" type="button" role="tab" aria-controls="alltasks" aria-selected="false">Pozostałe</button>
      </li>

    </ul>              
<div class="tab-content" id="myTabContent">
    <div class="tab-pane fade show active" id="task" role="tabpanel" aria-labelledby="task-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myTodosNew' :pendingTodos='$myTodosPending' :finishedTodos='$myTodosFinished' :acceptedTodos='$myTodosAccepted' />
  </div>
  <div class="tab-pane fade" id="myorders" role="tabpanel" aria-labelledby="myorders-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myOrdersNew' :pendingTodos='$myOrdersPending' :finishedTodos='$myOrdersFinished' :acceptedTodos='$myOrdersAccepted' />
  </div>
  <div class="tab-pane fade" id="alltasks" role="tabpanel" aria-labelledby="task-tab">  
        <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$otherTodosNew' :pendingTodos='$otherTodosPending' :finishedTodos='$otherTodosFinished' :acceptedTodos='$otherTodosAccepted' />     
  </div>


</div>
<div class="clearfix"></div>
</div>



 
@endsection

@section('scripts')
    <script>

    </script>
@endsection



{{-- @extends('layouts.app')
@section('content')


@php 
$executors=\App\Models\User::get();
$myTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('executor_id', Auth::user()->id)->where('status_id', '1')->get();
$pendingTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('executor_id', Auth::user()->id)->where('status_id', '4')->get();
$finishedTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('executor_id', Auth::user()->id)->where('status_id', '2')->get();
$myOrders = \App\Models\Todo::orderBy('last_update', 'desc')->where('principal_id', Auth::user()->id)->where('status_id', '1')->get();
$pendingOrders = \App\Models\Todo::orderBy('last_update', 'desc')->where('principal_id', Auth::user()->id)->where('status_id', '4')->get();
$finishedOrders = \App\Models\Todo::orderBy('last_update', 'desc')->where('principal_id', Auth::user()->id)->where('status_id', '2')->get();
$newAllTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('principal_id', '!=',Auth::user()->id)->where('executor_id', '!=',Auth::user()->id)->where('status_id', '1')->get();
$pendingAllTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('principal_id', '!=',Auth::user()->id)->where('executor_id', '!=',Auth::user()->id)->where('status_id', '4')->get();
$finishedAllTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('principal_id', '!=',Auth::user()->id)->where('executor_id', '!=',Auth::user()->id)->where('status_id', '2')->get();
$acceptedTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('status_id', '5')->get();

$event='';
@endphp


<x-modals.create-todo-modal :event="$event"/>


<div class="container">
<div class="btn-group float-end" role="group" aria-label="button-add-todo">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todoCreateModal">Dodaj zadanie</button>
</div>
  <ul class="nav nav-tabs" id="eventEdit" role="tablist">
      <li class="nav-item" role="presentation">
          <button class="nav-link active" id="task-tab" data-bs-toggle="tab" data-bs-target="#task" type="button" role="tab" aria-controls="taskedit" aria-selected="true">Moje zadania</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="myorder-tab" data-bs-toggle="tab" data-bs-target="#myorders" type="button" role="tab" aria-controls="myorders" aria-selected="false">Moje zlecenia</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#alltasks" type="button" role="tab" aria-controls="alltasks" aria-selected="false">Pozostałe</button>
      </li>
      <li class="nav-item" role="presentation">
          <button class="nav-link" id="all-tab" data-bs-toggle="tab" data-bs-target="#acceptedTasks" type="button" role="tab" aria-controls="acceptedTasks" aria-selected="false">Zaakceptowane</button>
      </li>
    </ul>              
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="task" role="tabpanel" aria-labelledby="task-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myTodos' :pendingTodos='$pendingTodos' :finishedTodos='$finishedTodos' />
  </div>
  <div class="tab-pane fade" id="myorders" role="tabpanel" aria-labelledby="myorders-tab">
    <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$myOrders' :pendingTodos='$pendingOrders' :finishedTodos='$finishedOrders' />
  </div>
  <div class="tab-pane fade" id="alltasks" role="tabpanel" aria-labelledby="task-tab">  
        <x-layout-elements.todo-list-group :executors='$executors' :myTodos='$newAllTodos' :pendingTodos='$pendingAllTodos' :finishedTodos='$finishedAllTodos' />     
  </div>  
  <div class="tab-pane fade" id="acceptedTasks" role="tabpanel" aria-labelledby="task-tab">  
        <x-layout-elements.accepted-todos-group :executors='$executors' :acceptedTodos='$acceptedTodos' :pendingTodos='$acceptedTodos' :finishedTodos='$acceptedTodos' />     
  </div>  
</div>
<div class="clearfix"></div>
</div>



 
@endsection

@section('scripts')
    <script>

    </script>
@endsection --}}