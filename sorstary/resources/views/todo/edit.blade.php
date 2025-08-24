@extends('layouts.app')
@section('content')
@php
    $executors=DB::table('users')->get();
@endphp

<div class="container">
    
    <div class="card">
        <h5 class="card-header">
            Edytuj zadanie
        </h5>
        <div class="card-body">
            <form action="/todo/{{ $todo->id }}" method="POST">
            @csrf
            @method('PATCH')
            <input type="hidden" name="id" value="{{ $todo->id }}">
            <input type="hidden" name="principal_id" value="{{ $todo->principal_id }}">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-row">
                            <div class="col-md-4 mb-3">
                                <label for="name">Nazwa</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $todo->name }}" required>
                </div>
            </div>

            <div class = "form-row">
                <div class = "col-md mb-3">
                    <label for="deadline">Termin wykonania do: </label>
                    <input type="date" id = "deadline" name="deadline" value="{{ $todo->deadline }}">
                </div>        
            </div>

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="executor_id">wykonawca: </label>
                    <select name="executor_id" id="executor_id">
                        <option value="{{ $todo->executor_id }} "> {!! $todo->executor->name !!} </option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>   
            </div>
            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="status_id">status: </label>
                    <select name="status_id" id="status_id">
                        <option value="{{ $todo->status_id }} ">
                            @if(isset($todo->status->name))
                            {{ $todo->status->name }}
                            @else
                            {{ $todo->status_id }}
                            @endif

                    </option>
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
                        <option value="{{ $todo->contractor_id }}" selected>{{ $todo->contractor_id }}</option>
                        @foreach($contractors as $contractor)
                        <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                        @endforeach
                    </select>
                </div>   
            </div>

            <div class="form-row">
                <div class="col-md-4 mb-3">
                    <label for="description">notatki: </label>
                    <input type="text-area" class="form-control" id="description" name="description" value={!! $todo->description !!}>
                </div>   
            </div>

        <button class="btn btn-primary" type="submit">Aktualizuj</button>
        </form>                                             

    </div>

</div>

@endsection

{{-- scripts --}}
@section('scripts')
<script>
    $(document).ready(function() {
        $("#editEventNote").summernote();
        // $('.dropdown-toggle').dropdown();
    });
</script>
@endsection