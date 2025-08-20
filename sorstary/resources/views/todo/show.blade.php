@extends('layouts.app')
@section('content')

<div class="container">

<h1> Todo - show </h1>

<div>{!! $todo->principal->name !!}</div>
<div>{!! $todo->name !!}</div>
<div>{!! $todo->description !!}</div>
    @isset($todo->event->eventName)
    <div>{!! $todo->event->eventName !!}</div>
    @endisset
<div>{!! $todo->parent_todo_id !!}</div>
<div>{!! $todo->executor_id !!}</div>
<div>{!! $todo->status_id !!}</div>
<div>{!! $todo->contractor_id !!}</div>

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