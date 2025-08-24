@php
$date = date_create($event->eventStartDateTime);
$startTime = date_format($date, 'Y-m-d');
@endphp
<div class="row">
        <div class="container col-12">
            <div class="callout callout-info">
                <div><span class="text-muted sm">dodane: {{ $event->created_at}}</span></div>
                @isset($event->author->name)
                <div><span class="text-muted sm">przez: {{ $event->author->name}}</span></div>
                @endisset
                <div>
                    <small class="text-muted sm">Impreza: </small>
                    <span class="text"> <a href = "/events/{!!$event->id!!}/edit">{{ $event->eventName }}</a></small>
                    </span>
                <div>
                <div>
                    <small class="text-muted sm">Start: </small><span class="text">{!!$startTime!!} ({{$event->duration}} dni)</span>
                </div>
                @if($event->purchaser_id)
                <div><small class="text-muted sm">Dla: </small><span class="text"> {{$event->purchaser->name }}</span></div>
                @else
                <div><small class="text-muted sm">Dla: </small><span class="text">{{$event->eventPurchaserName}}</span></div>
                @endisset               

            </div>
        </div>
</div>