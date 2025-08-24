<div class="row">
        @foreach($acceptedTodos as $todo)
        <div class="col-md-3">
          <x-todos-list :todo='$todo' :executors='$executors' />
        </div>
        @endforeach
</div>