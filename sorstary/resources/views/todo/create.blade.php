@extends('layouts.app')
@section('content')

<div class="container">

<h1> Zadanie - Dodaj </h1>

<form action="/todo" method="POST">
    @csrf
    <input type="hidden" class="form-control" name="principal_id" value="{{ Auth::user()->id }}">  
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="name">Nazwa</label>
            <input type="text" class="form-control" id="name" name="name" value="nazwa" required>
        </div>
        <div class="col-md-4 mb-3">
            <label for="urgent">Pilne: </label>
            <input type="checkbox" name="urgent" >
        </div>
    </div>

    <div class = "form-row">
        <div class = "col-md mb-3">
            <label for="deadline">Termin wykonania do: </label>
            <input type="date" id = "deadline" name="deadline">
        </div>        
    </div>

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="executor_id">wykonawca: </label>
            <select name="executor_id" id="executor_id">
                @foreach($executors as $executor)
                <option value="{{$executor->id}}">{{$executor->name}}</option>
                @endforeach
            </select>
        </div>   
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="status_id">status: </label>
            <select name="status_id" id="status_id">
                @foreach($statuses as $status)
                <option value="{{$status->id}}">{{$status->name}}</option>
                @endforeach
            </select>
        </div>   
    </div>
        <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="contractor_id">Podwykonawca: </label>
            <select name="contractor_id" id="contractor_id">
                <option value="" selected>brak</option>
                @foreach($contractors as $contractor)
                <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                @endforeach
            </select>
        </div>   
    </div>



    

    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="description">notatki: </label>
            <input type="text-area" class="form-control" id="description" name="description">
        </div>   
    </div>

  <button class="btn btn-primary" type="submit">Dodaj</button>
</form>


</div>

@endsection


@section('scripts')

<script>
    $(document).ready(function() {
        $("#description").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script>
@endsection