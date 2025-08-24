@extends('layouts.app')
@section('content')

<div class="container">

<h1> Waluty - index </h1>

            <form action="{{ route('currency.create')}}" method="get">
                  @csrf
                  <button class="btn btn-success" type="submit">Nowy</button>
            </form>

<div class="table-responsive">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Symbol</th>
      <th scope="col">Nazwa</th>
      <th scope="col">Akcje</th>
    </tr>
  </thead>
  <tbody>

@foreach($data as $currency)
    <tr>
        <td>
            {!! $currency->symbol !!}
        </td>
        <td>
            {!! $currency->name !!}
        </td>
        <td> 
          <div class="btn-group" role="group" aria-label="Basic navi">

           
            <form action="{{ URL::to('currency/'.$currency->id.'/edit') }}" method="get">
                  @csrf
                  <button class="btn btn-primary" type="submit"><i class="bi bi-pencil-square"></i> edycja
</button>
            </form>
            <form action="{{ route('currency.destroy', $currency->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit"><i class="bi bi-trash3"></i> usuń
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


@endsection