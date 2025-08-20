@extends('layouts.app')
@section('content')

@php
echo "<script>console.log(JSON.parse('" . json_encode($data) . "'));</script>";
@endphp


<div class="container">
<div>
<h1> Zadania <span class="float-right"><form action="{{ route('todo.create')}}" method="get">
                  @csrf
                  <button class="btn btn-primary" type="submit">Nowe Zadanie</button>
            </form></span>
          </h1>
</div>

<div class="container-fluid">
  <div class = "row">
    <div class = "col-md-3 ">
      <h5>Nowe zadania</h5>
    </div>
    <div class = "col-md-3 ">
      <h5>W trakcie zadania</h5>
    </div>
    <div class = "col-md-3 ">
      <h5>Pilne</h5>
    </div>
    <div class = "col-md-3 ">
      <h5>Przeterminowane</h5>
    </div>
</div>

 

<div class="table-responsive">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Nazwa</th>
      <th scope="col">Wykonawca</th>
      <th scope="col">Opis</th>
      <th scope="col">Akcje</th>
    </tr>
  </thead>
  <tbody>
  @foreach($data as $todo)
    <tr>
      <th scope="row">{{ $todo->name }}<br> autor: {!! $todo->principal->name !!}<br>termin wykonania: {!! $todo->deadline !!}<br>Pilne: 
        @if($todo->urgent === 0)
        nie 
        @else
        TAK
        @endif
      <td>
            @if (!is_null($todo->executor)) <div>{!! $todo->executor->name !!}</div> @endif
            @if (!is_null($todo->status)) <div> {!! $todo->status->name !!}</div> @endif
      </td>
      <td>
        <div>{!! $todo->description !!}</div>
        @if (!is_null($todo->contractor)) <div>Podwykonawca: {!! $todo->contractor->name !!}</div> @endif
      </td>
      <td> 
        <div class="btn-group" role="group" aria-label="Basic navi">
                    <form action="{{ URL::to('todo/'.$todo->id) }}" method="get">
                @csrf
                <button class="btn btn-primary" type="submit"><i class="bi bi-eye"></i>
                </button>
          </form>
          <form action="{{ URL::to('todo/'.$todo->id.'/edit') }}" method="get">
                @csrf
                <button class="btn btn-primary" type="submit"><i class="bi bi-pencil-square"></i>
                </button>
          </form>

            <form action="{{ route('todo.destroy', $todo->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit"><i class="bi bi-trash3"></i>
                  </button>
            </form>
            <br>
                <form action="{{ URL::to('notes/createwithrequest/') }}" method="post">
                  <input type="hidden" name="todo_id" value="{{ $todo->id }}">
                  @isset($todo->event_id)
                  <input type="hidden" name="event_id" value="{{ $todo->event_id }}">
                  @endisset
                @csrf
                <button class="btn btn-primary" type="submit"> + Dodaj komentarz
                </button>
                </form>
          </div>
        </td>
      </tr>
        @php
          $notes= \App\Models\Note::orderBy('created_at', 'desc')->where('todo_id', $todo->id)->get();  
        @endphp
        <tr>
          <td colspan="4"> 
            <table class="table table-hover table-striped">
              <tbody>
                





                @foreach($notes as $note)
                  <tr>
                      <td class="mailbox-date">{{ $note->created_at }}</td>
                      {{-- <td class="mailbox-name">{{ $note->author->name }}</td> --}}
                      <td class="mailbox-subject"><b>{{ $note->name }}</b> - {{ $note->description }}
                     </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </td>
        </tr>
        
      </td>
      @endforeach
    </tbody>
 </table>
</div>
</div>
@endsection

@section('scripts')
<script>

  $(function() {
    $('.delete').click(function() {
      $.ajax({
        method: "DELETE",
        url: "todo/" + $(this).data('id'),
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
      })
      .done(function( response ) {
        window.location.reload()
      })
      .fail(function (response) {

        window.location.reload()

      });
    })
  })

</script>
@endsection