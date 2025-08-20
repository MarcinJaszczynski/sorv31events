@extends('layouts.app')
@section('content')

<div class="container">

<h1> Todo status - create </h1>

<form action="/bookingstatus" method="POST">
    @csrf

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="name">Nazwa</label>
      <input type="text" class="form-control" id="name" name="name" value="nazwa" required>
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="description">Opis: </label>
      <input type="text-area" class="form-control" id="description" name="description">
    </div>   
  </div>
  <button class="btn btn-primary" type="submit">Dodaj</button>
</form>


</div>

{{-- scripts --}}

<script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script></div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<script>
    $(document).ready(function() {
        $("#editEventNote").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script>
@endsection