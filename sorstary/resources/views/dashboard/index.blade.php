@extends('layouts.app')
@section('content')
@push('meta')
@endpush
@php 
// $users=\App\Models\User::all();
$users=\App\Models\User::all();
$todos = \App\Models\Todo::orderBy('created_at', 'desc')->where('executor_id', Auth::user()->id)->take(5)->get();
$events = \App\Models\Event::orderBy('created_at', 'desc')->take(5)->get();
// $newtodos = DB::table('todos')->orderBy('created_at', 'desc')->where('executor_id', Auth::user()->id)->take(5)->get();
$notices=  \App\Models\Notice::orderBy('created_at', 'desc')->take(4)->get();
$notes= \App\Models\Note::with('todo')->orderBy('created_at', 'desc')->take(5)->get();  
$todostatuses = \App\Models\TodoStatus::all();
@endphp
<section class="content-header">
<div class="container-fluid">
<div class="row">
<div class="col-sm-6">
<h1>Kokpit</h1>
</div>
</div>
</div>
</section>


<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-6">
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>  
              @php
                echo DB::table('todos')->where('urgent', '1')->count();  
              @endphp
            </h3>
            <p>Zmiany w imprezie</p>
          </div>
          <div class="icon">
          <i class="ion ion-bag"></i>
          </div>
          <a href="/todo?urgent=1" class="small-box-footer">więcej <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
          <div class="inner">
            <h3>
            @php
              echo DB::table('todos')->where('executor_id', Auth::user()->id)->where('status_id', '1')->count();  
            @endphp
            </h3>
            <p>Do zrobienia</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="/todo?executor={{ Auth::user()->id }}&status=1" class="small-box-footer">więcej <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
          <div class="inner">
            <h3>
            @php
              echo DB::table('events')->where('eventStatus', 'Zapytanie')->count();  
            @endphp
            </h3>
            <p>Zapytanie</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="/events/getevents?eventStatus=Zapytanie" class="small-box-footer">więcej <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>

      <div class="col-lg-3 col-6">
        <div class="small-box bg-warning">
          <div class="inner">
            <h3>  
              @php
                echo DB::table('events')->where('eventStatus', 'doanulacji')->count();  
              @endphp
            </h3>
            <p>Imprezy do anulacji</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="/events/getevents?eventStatus=doanulacji" class="small-box-footer">więcej <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
    </div>
  </div>
<section class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <h1>Ogłoszenia
                        <span class="float-right">
<a class="btn btn-primary" href="/notices/create"><i class="fas fa-plus"></i> nowe</a>
<a class="btn btn-primary" href="/notices/">wszystkie</a>
                        </span>
                        </h1>
      </div>
    </div>
    </div>
</section>
    @foreach($notices as $notice)
        <div class="col-lg-3 col-6">
          <div class="callout callout-info">
            
          <p class="text-muted small"><i class="far fa-clock"> </i> {!! $notice->created_at !!}<br>
            <strong>{!! $notice->author->name !!}</strong></p>
            <h6 class="text-muted">{!! $notice->title !!}</h6>
          </p>
          <p class="text-muted small">{!! $notice->description !!}</p>
          </div>
        </div>
      @endforeach
</div>



<div class="container-fluid">
<div class="row">
  <div class="col-md-4">
    <div class="card">
<div class="card-header ui-sortable-handle" style="cursor: move;">
<h3 class="card-title">Zadania</h3>
<div class="card-tools"><a href="{{ url('/todo') }}"<button type="button" class="btn btn-primary float-right"></i>wszystkie</button></a>
</div>
</div>
 
<div class="card-body">
  @foreach($todos as $todo)
  <div><x-todos-list :todo='$todo' :executors='$users' /></div>
  @endforeach
</div>

<div class="card-footer clearfix">
<button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
</div>
</div>
</div>



  <div class="col-md-4">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title">Komentarze</h3>
          <div class="card-tools"><a href="{{ url('/todo') }}>"button type="button" class="btn btn-primary float-right"></i>wszystkie</button></a>
          </div>
      </div>
 
      <div class="card-body">
        <table class="table table-hover">
          @foreach($notes as $note)
           
          
          @endforeach
        </table>
      </div>
      <div class="card-footer clearfix">
        <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
      </div>
    </div>
  </div>

   <div class="col-md-4">
    <div class="card">
      <div class="card-header ui-sortable-handle" style="cursor: move;">
        <h3 class="card-title">
        <i class="ion ion-clipboard mr-1"></i>Nowe imprezy</h3>
          <div class="card-tools"><a href="{{ url('/todo') }}>"button type="button" class="btn btn-primary float-right"></i>wszystkie</button></a>
          </div>
      </div>
 
      <div class="card-body">
       


          @foreach($events as $event)
                    <x-event-dashboard :event='$event' />            
          @endforeach
        </table>
      </div>
      <div class="card-footer clearfix">
        <button type="button" class="btn btn-primary float-right"><i class="fas fa-plus"></i> Add item</button>
      </div>
    </div>
  </div>
  




</div>
@endsection

@section('scripts')
@endsection

