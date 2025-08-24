@php
    $todoStatuses = \App\Models\TodoStatus::get();
    $diff = (Carbon\Carbon::today()->diffInDays($todo->deadline));
    $diff_text = "+ ";
    $startDiv = '<div class="callout callout-danger">';
    $badgeClass='success';
    if(Carbon\Carbon::today()->gte($todo->deadline)){
        $diff_text = "- ";
        $badgeClass = 'danger';
    }
    elseif($diff<=3){
        $startDiv = '<div class="callout callout-warning">';
    }
    elseif($diff<=7){
        $startDiv = '<div class="callout callout-info">';
    }
    elseif($todo->urgent==true){
        $startDiv = '<div class="alert alert-danger">';
    }
    else{
        $startDiv = '<div class="callout callout-success">';
    }
@endphp

    {!! $startDiv !!}
    <div class="row">
        <div class="container col-12"><span class="text-muted sm">od: {{ $todo->principal->name }}</span> <small class="badge badge-{!!$badgeClass!!} float-right"><i class="far fa-clock"></i> {{ $todo->deadline }} </small></div>
        <div class="container col-12"><span class="text-muted sm">dla: {{ $todo->executor->name }}</span></div>
            <div>
                <small class="text-muted sm">Zadanie: </small>
                <a href="#" data-toggle="modal" data-target='#editTodoModal{{$todo->id}}' class='text-uppercase font-weight-bold'>{{ $todo->name }}</a> 
                @php
                $todo = $todo;
                $executors = $executors;
                @endphp
                <x-modals.edit-todo-modal :todo='$todo' :executors='$executors' :todoStatuses='$todoStatuses' />
            </div>
         </div>
        
        @isset($todo->event->eventName)
            <div>
                <small class="text-muted sm">Impreza: </small><a href = "/events/{!!$todo->event_id!!}/edit"><span class="text">{{ $todo->event->eventName }}</a></span>
            </div>
        @endisset
            <div>
                <small class="text-muted sm">Treść: </small><span class="text">{!! $todo->description !!}</a></span>
            </div>
            <hr />

        @php
            $notes = \App\Models\Note::orderBy('created_at', 'desc')->where('todo_id', $todo->id)->get(); 
            $i = 0;
        @endphp
            <div class="text-muted">
                Ostatni komentarz: {{ $todo->last_update }}
            </div>

            @if($notes->count()>0)
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{$notes[0]->author->name}}</span>
                        <span class="direct-chat-timestamp float-right">
                            @php
                            echo(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notes[0]->created_at)->format('d/m H:i'));
                            @endphp
                        </span>
                    </div>
                    <p class="py-1"><span class="font-weight-bold">napisał:</span> {!! $notes[0]->name !!}</p>
                </div>
            @endif
        
        <div class="text-muted">
            <a data-toggle="collapse" href="#todoNotes{{$todo->id}}" role="button" aria-expanded="false" aria-controls="collapseTodo{{$todo->id}}">
                Wszystkie: 
            </a>
            <strong>({{$notes->count()}})</strong>

            <x-modals.create-note-modal :todoId='$todo->id' :eventId='$todo->event_id' />
            <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#createNoteModal{{$todo->id}}"><i class="bi bi-plus-lg"></i></button>
                
        </div>
        <div class="collapse" id="todoNotes{{$todo->id}}">        
            @foreach($notes as $note)
                @php
                    $i++;
                @endphp
                @if($i>1)
                <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{$note->author->name}}</span>
                        <span class="direct-chat-timestamp float-right">
                            @php
                            echo(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $note->created_at)->format('d/m H:i'));
                            @endphp
                        </span>
                    </div>
                    <p class="py-1"><span class="font-weight-bold">napisał:</span>{!! $note->name !!}</p>
                </div>
                {{-- @else
                 <div class="direct-chat-msg">
                    <div class="direct-chat-infos clearfix">
                        <span class="direct-chat-name float-left">{{$note->author->name}}</span>
                        <span class="direct-chat-timestamp float-right">
                            @php
                            echo(Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $note->created_at)->format('d/m H:i'));
                            @endphp
                        </span>
                    </div>
                    <p class="py-1 px-2 bg-gradient-secondary text-white rounded-2">{!! $note->name !!}</p>
                </div>                --}}
                @endif
            @endforeach 
    </div>
    </div>

