@extends('layouts.app')
@section('content')
    @php
        $acceptedTodos = $data;
        // $todos = \App\Models\Todo::orderBy('last_update','desc')->get();
        $executors = \App\Models\User::get();
        
        $event = '';
    @endphp

    {{-- Start Modals --}}

    <x-modals.create-todo-modal :event="$event" />

    {{-- End Modals --}}

    <div class="container">
        <div class="row">
            <div class="col">
                <div class="btn-group float-end" role="group" aria-label="button-add-todo">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todoCreateModal">Dodaj
                        zadanie</button>
                </div>
            </div>
        </div>
        <div class="row mt-5">

            <div class="col">

                <div>
                    <x-layout-elements.accepted-todos-list :executors='$executors' :acceptedTodos='$acceptedTodos' />
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
    @endsection

    @section('scripts')
        <script></script>
    @endsection



    {{-- @extends('layouts.app')
@section('content')


@php 
$executors=\App\Models\User::get();
$event='';
@endphp


<x-modals.create-todo-modal :event="$event"/>


<div class="container">
<div class="btn-group float-end" role="group" aria-label="button-add-todo">
  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#todoCreateModal">Dodaj zadanie</button>
</div>
          

  <div class="tab-pane fade" id="acceptedTasks" role="tabpanel" aria-labelledby="task-tab">  
        <x-layout-elements.accepted-todos-group :todos='$data' />     
  </div>  
<div class="clearfix"></div>
</div>



 
@endsection

@section('scripts')
    <script>

    </script>
@endsection --}}
