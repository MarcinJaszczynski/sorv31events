<div class="container-fluid">
  <div class = "row">
    <div class = "col-md-4 ">
      <h5>Zaakceptowane</h5>
      <div id='acceptedTodos'>
        @foreach($acceptedTodos as $todo)
          <x-todos-list :todo='$todo' :executors='$executors' />
        @endforeach
      </div>
    </div>
    
  

</div>
</div>