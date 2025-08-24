@extends('layouts.app')
@section('content')

<div class="container">

<h1> Wiadomości - create </h1>

<form action="/notices" method="POST">
    @csrf
    <input type="hidden" class="form-control" name="author_id" value="{{ Auth::user()->id }}">
  
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="name">Tytuł</label>
            <input type="text" class="form-control" id="title" name="title" value="tytuł" required>
        </div>
    </div>
    <div class = "form-row">
        <div class = "col-md mb-3">
            <label for="deadline">Wyświetlaj do: </label>
            <input type="date" id = "validity" name="validity">
        </div>        
    </div>
    <div class="form-row">
        <div class="col-md-4 mb-3">
            <label for="description">treść: </label>
            <input type="text-area" class="form-control" id="description" name="description">
        </div>   
    </div>

  <button class="btn btn-primary" type="submit">Dodaj</button>
</form>

@endsection

@section('scripts')

{{-- <script>
    $(document).ready(function() {
        $("#description").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script> --}}
@endsection