@extends('layouts.app')
@section('content')

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalScrollable">
  Launch demo modal
</button>

<!-- Modal -->

<x-modals.test-modal :event="$event"/>

@endsection

@section('scripts')

<script>
    $(document).ready(function() {
        $(".editEventNote").summernote();
        $('.dropdown-toggle').dropdown();
    });


</script>
  
@endsection


