


<div class="container-fluid">
  <div class = "row">
    <div class = "col-md-3 ">
      <h5>Do zrobienia</h5>
      <div id='newtasks'>
        @foreach($myTodos as $todo)
          <x-todos-list :todo='$todo' :executors='$executors' />
        @endforeach
      </div>
    </div>
    <div class = "col-md-3">
      <h5>W trakcie </h5>
      <div id='pendingtasks'>
        @foreach($pendingTodos as $todo)
          <x-todos-list :todo='$todo' :executors='$executors' />
        @endforeach
      </div>
      
    </div>
  
    <div class = "col-md-3 ">
      <h5>Zrobione</h5>
      <div id='finished'>
        @foreach($finishedTodos as $todo)
          <x-todos-list :todo='$todo' :executors='$executors' />
        @endforeach
      </div>
    </div>

    <div class = "col-md-3 ">
      <h5>Zaakceptowane</h5>
      <div id='finished'>
        @foreach($acceptedTodos as $todo)
          <x-todos-list :todo='$todo' :executors='$executors' />
        @endforeach
      </div>
    </div>
</div>
</div>