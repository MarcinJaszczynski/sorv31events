@extends('layouts.app')
@section('content')

<div class="container">

<h1> Kontrahenci - index </h1>
            <form action="{{ route('contractors.create')}}" method="get">
                  @csrf
                  <button class="btn btn-success" type="submit">Nowy</button>
            </form>

<div class="table-responsive">
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">Nazwa</th>
      <th scope="col">Imie i nazwisko</th>
      <th scope="col">Kontakt</th>
      <th scope="col">Rodzaj</th>
      <th scope="col">Notatki</th>
      <th scope="col">Akcje</th>
    </tr>
  </thead>
  <tbody>

@foreach($data as $contractor)
    <tr>
      <th scope="row">
        <a href="/contractors/{{$contractor->id}}/edit" class="font-weight-bold text-decoration-none text-uppercase text-dark">{{$contractor->name}}</a>
      </th>
      <td>
        <div>{{ $contractor->firstname }}</div>
        <div>{{ $contractor->surname }}</div>
      </td>
      <td>
        @isset($contractor->street)
        {!! $contractor->street !!}<br>
        @endisset
        @isset($contractor->city)
        {!! $contractor->city !!}<br>
        @endisset
        @isset($contractor->region)
        {!! $contractor->region !!}<br>
        @endisset
        @isset($contractor->email)
        {!! $contractor->email !!}<br>
        @endisset
        @isset($contractor->phone)
        {!! $contractor->phone !!}<br>
        @endisset
        @isset($contractor->www)
        {!! $contractor->www !!}<br>
        @endisset
      </td>
      <td>
        @foreach($contractor->type as $contractortype)
          <div>{{ $contractortype->name }}</div>
        @endforeach
      </td>
      <td>
          {!! $contractor->description !!}
      </td>
        <td> 
          <div class="btn-group" role="group" aria-label="Basic navi">

           {{-- <form action="{{ URL::to('contractors/'.$contractor->id)}}" method="get">

                  <button class="btn btn-info" type="submit"><i class="bi bi-search"></i></button>
            </form> --}}
            <form action="{{ URL::to('contractors/'.$contractor->id.'/edit')}}" method="get">
                  @csrf
                  {{-- @method('DELETE') --}}
                  <button class="btn btn-primary" type="submit"><i class="bi bi-pencil-square"></i>
</button>
            </form>
            {{-- <form action="{{ route('contractors.destroy', $contractor->id)}}" method="post">
                  @csrf
                  @method('DELETE')
                  <button class="btn btn-danger" type="submit"><i class="bi bi-trash3"></i>
</button>
            </form> --}}
          </div>
        </td>
    </tr>
    @endforeach
  </tbody>
 </table>
</div>

</div>




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