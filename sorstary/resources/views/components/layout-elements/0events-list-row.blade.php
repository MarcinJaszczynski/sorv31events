<tr>
    <th scope="row">
        <div>
            {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }}
        </div>
        <div>
            {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}
        </div>
        <div>
            @if($event->duration != null)
            dni: {{ $event->duration }}
            @endif
        </div>
    </th>
    <td>
        <div>
            @php
                $todosTotal = $event->todo->count();
                $todosDone = $event->todo->where('status_id',2)->count() + $event->todo->where('status_id',5)->count();
            @endphp
            @if($event->todo->where('status_id',2)->count() + $event->todo->where('status_id',5)->count() >= $event->todo->count() and $event->todo->count()!=0)

                <td>
                                    <div>
                                        <i class="font-weight-bold text-success fas fa-check-square"></i>

                    <a href="/events/{{ $event->id }}/edit" class="text-decoration-none text-success text-uppercase fw-bolder" >{{ $event->eventName }}</a>({{ $todosDone}}/{{$event->todo->count()}}) - {{ $event->eventTotalQty}} os.
                </div>
                <div>
                    ({!! $event->eventOfficeId !!})
                </div>   
            @else
                <td>
                <div>
                    <a href="/events/{{ $event->id }}/edit" class="text-decoration-none text-dark text-weight-bold text-uppercase fw-bolder" >{{ $event->eventName }}</a> ({{$event->todo->where('status_id',2)->count()}}/{{$event->todo->count()}}) - {{ $event->eventTotalQty}} os.
                </div>
                <div>
                    ({!! $event->eventOfficeId !!})
                </div>                        
            @endif

            @if((Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) >=7) && ($event->eventStatus=== "Zapytanie"))
                <div class="text-danger text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni </div>
            @elseif((Carbon\Carbon::now()->diffInDays($event->created_at) >=7) && ($event->eventStatus === "Zapytanie"))
                <div class="text-danger text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni </div>                    
            @elseif((Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) >=7) && ($event->eventStatus === "oferta"))
                <div class="text-danger text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni </div>                    
            @elseif((Carbon\Carbon::now()->diffInDays($event->updated_at) >=7) && ($event->eventStatus === "oferta"))
                <div class="text-danger text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni </div>                    
            @elseif($event->eventStatus === "OdprawaOK")
                <div class="text-primary text-bold"><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni </div>                    
            @elseif($event->statusChangeDatetime != null)
                <div>{{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->statusChangeDatetime) }} dni  </div> 
            @elseif(Carbon\Carbon::now()->diffInDays($event->created_at)>=7)
                <div class=""><i class="fa fa-exclamation-circle" aria-hidden="true"></i> {{ $event->eventStatus }} od: {{ Carbon\Carbon::now()->diffInDays($event->created_at) }} dni </div>                
            @else
                <div>{{ $event->eventStatus }} od: {{ $event->statusChangeDatetime }}</div>
            @endif

            {{-- @if($event->purchaser_id!=null)
                @php
                $purchasers = \App\Models\Contractor::where('id', $event->purchaser_id)->get();                 
                @endphp
                @foreach($purchasers as $purchaser)
                    <div class="text-muted sm"><a href="/contractors/{{ $purchaser->id }}/edit">{{$purchaser->name}}</a></div>
                    <div class="text-muted sm">{{$purchaser->firstname}} {{$purchaser->surname}}</div>
                @endforeach
                @else
                <div class="text-muted sm">{{$event->eventPurchaserName}}</div>
                <div class="text-muted sm">{{$event->eventPurchaserContactPerson}}</div>
            @endif --}}
            @if($event->purchaser_id === NULL)
                @php
                @endphp
                    @foreach($event->eventContractor as $econtractor)
                    @if($econtractor->contractortype_id === 4)
                     <div><a href="/contractors/{{ $econtractor->contractor->id }}/edit" class="small text-uppercase text-decoration-none text-dark">{{ $econtractor->contractor->name }}</div>, 
                     <div class="small">{{$econtractor->firstname}} {{$econtractor->surname}}</div> 

        @endif
        @endforeach
                {{-- @foreach($purchasers as $purchaser)
                    <div class="text-muted sm"><a href="/contractors/{{ $purchaser->id }}/edit">{{$purchaser->name}}</a></div>
                    <div class="text-muted sm">{{$purchaser->firstname}} {{$purchaser->surname}}</div>
                @endforeach --}}
                @else
                    @foreach($event->eventContractor as $econtractor)
                        @if($econtractor->contractortype_id === 4)
                        <div><a href="/contractors/{{ $econtractor->contractor->id }}/edit" class="small text-uppercase text-decoration-none text-dark">{{ $econtractor->contractor->name }}</div>, 
                        <div class="small">{{$econtractor->firstname}} {{$econtractor->surname}}</div> 
                        @endif
                    @endforeach
                    <div class="text-muted sm">{!!$event->eventPurchaserName!!}</div>
                    <div class="text-muted sm">{{$event->eventPurchaserContactPerson}}</div>
                    @endif

        </div>
    </td>
    <td class="col-sm-3">
        <div class="text-uppercase fw-bold">T:
        @foreach($event->eventContractor as $econtractor)
        @if($econtractor->contractortype_id === 7)
        <span class="small"><a href="/contractors/{{ $econtractor->contractor->id }}/edit" class="">{{ $econtractor->contractor->name }}</a>, 
            {{-- <span class="font-weight-light">- {{ $econtractor->contractor->firstname }} {{ $econtractor->contractor->surname }}, tel.:{{ $econtractor->contractor->phone }} --}}
            </span>
        @endif
        @endforeach
        </div>
        @isset($event->eventContractor)
        <div class="text-uppercase fw-bold">K: 
        @isset($event->eventDriver)
        <span>{!! $event->eventDriver !!}</span>
        @endisset
        @foreach($event->eventContractor as $econtractor)
        @if($econtractor->contractortype_id === 6)
        <span class="small"><a href="/contractors/{{ $econtractor->contractor->id }}/edit" class="">{{ $econtractor->contractor->name }}</a>, 
            {{-- <span class="font-weight-light">- {{ $econtractor->contractor->firstname }} {{ $econtractor->contractor->surname }}, tel.:{{ $econtractor->contractor->phone }} --}}
            </span>
        @endif
        @endforeach
        </div>
        <div class="text-uppercase fw-bold">P: 
        @isset($event->eventPilot)
        <span>{!! $event->eventPilot !!}</span>
        @endisset
        @foreach($event->eventContractor as $econtractor)
        @if($econtractor->contractortype_id === 5)
        <span class="small"><a href="/contractors/{{ $econtractor->contractor->id }}/edit">{{ $econtractor->contractor->name }}</a>,  
            {{-- <span class="fw-light"- {{ $econtractor->contractor->firstname }} {{ $econtractor->contractor->surname }}, tel.:{{ $econtractor->contractor->phone }}</span> --}}
        </span>
        @endif
        @endforeach
        </div>
        <div class="text-uppercase fw-bold">H: 
        @isset($event->hotels)
            @foreach($event->hotels as $hotel)
            <span>{!! $hotel->hotelName !!}, </span>
            @endforeach
        @endisset
        @foreach($event->eventContractor->where('contractortype_id', 1)->unique('contractor_id') as $econtractor)
        {{-- @if($econtractor->contractortype_id === 1) --}}
        {{-- <div>{{ $econtractor}}</div> --}}
        <span class="small"><a href="/contractors/{{ $econtractor->contractor->id }}/edit">{{ $econtractor->contractor->name }}</a>, {{ $econtractor->contractor->city }}, </span>
        {{-- <div class="small">{{ $econtractor->contractor->street }}, {{ $econtractor->contractor->city }}</div>      --}}
        {{-- @endif --}}
        @endforeach
        @endisset
    </td>
    <td class="col-sm-4">
        <div class="small">
            <span class="fw-bold">Uwagi do imprezy: </span>

            {!! $event->eventNote !!}
        </div>
    </td>

</tr>