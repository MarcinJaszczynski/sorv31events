@php
$executors=\App\Models\User::get();
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
</div>
<div class="clearfix"></div>
</div>