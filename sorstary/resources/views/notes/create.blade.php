@extends('layouts.app')
@section('content')

<div class="container">
    <div class="card">
    <h5 class="card-header">Nowa notatka</h5>
    <div clas="card-body">
        <div input type="text" title
</div>

<form action="/notes" method="POST">
    @csrf
        <input type="hidden" class="form-control" name="author_id" value="{{ Auth::user()->id }}">
        @isset($data['todo_id'])
                <input type="hidden" name="todo_id" value="{{ $data['todo_id'] }}">            
        @endisset
                @isset($data['event_id'])
                <input type="hidden" name="event_id" value="{{ $data['event_id'] }}">            
        @endisset
            <div class="container">
                <div class="col-md-6">
                    <div>
                        <label for="name">Tytuł: </label>
                        <input type="text" class="form-control" name="name" value="tytuł">
                    </div>

                    <div>
                        <label for="description">Treść: </label>
                        <div>
                            <textarea name="description" rows="4" cols="50"></textarea>
                        </div>
                    </div>
                <div>
                <button type="submit" class="btn btn-success">Wyślij</button>
                </div>
                </div>
            </div>
            </form>


@endsection

