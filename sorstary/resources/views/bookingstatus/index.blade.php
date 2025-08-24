@extends('layouts.app')
@section('content')

<div class="container">

<h1> BookingStatus - index </h1>

            <form action="{{ route('bookingstatus.create')}}" method="get">
                  @csrf
                  <button class="btn btn-success" type="submit">Nowy</button>
            </form>

<div class="table-responsive">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Nazwa</th>
      <th scope="col">Opis</th>
      <th scope="col">Akcje</th>
    </tr>
  </thead>
  <tbody>

@foreach($data as $bookingstatus)
    <tr>
      <th scope="row">{{$bookingstatus->name}} </th>
        <td>
            {!! $bookingstatus->description !!}
        </td>
        <td> 
          <div class="btn-group" role="group" aria-label="Basic navi">

           
            <form action="{{ URL::to('bookingstatus/'.$bookingstatus->id.'/edit') }}" method="get">
                  @csrf
                  <button class="btn btn-primary" type="submit"><i class="bi bi-pencil-square"></i>
</button>
            </form>
            <form action="{{ route('bookingstatus.destroy', $bookingstatus->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit"><i class="bi bi-trash3"></i>
</button>
            </form>
          </div>
        </td>
    </tr>
    @endforeach
  </tbody>
 </table>
</div>


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