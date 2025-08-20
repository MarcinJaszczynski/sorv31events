
<tr 
@if($element->booking==='2')
@if($element->event->eventStatus==='doanulacji')
class="bg-warning"
@endif
@endif
> 
        <td class="col-md-1">
            @php
                $start = \Carbon\Carbon::parse($element->eventElementStart)->format('H:i');
                $end = \Carbon\Carbon::parse($element->eventElementEnd)->format('H:i');
            @endphp

            
            {{ $start }} - {{ $end }}
        </td>
        <td class="col-md-4">
            <div>
                <a href="/events/{{$element->event->id}}/edit" class=" text-dark text-uppercase fw-bolder" >{{ $element->event->eventName }}</a>
            </div>
            <div>
                {{ $element->event->eventTotalQty}} os. - {{ $element->event->eventStatus}}
            </div>
            <div>
                @isset($element->event->purchaser_id)
                <div>{{ $element->event->purchaser->name }}</div>
                <div>{{ $element->event->purchaser->firstName }} {{ $element->event->purchaser->surName }}</div>
                <div>{{ $element->event->purchaser->street }}, {{ $element->event->purchaser->city }}</div>
                <div>tel.: {{ $element->event->purchaser->phone }}, email: {{ $element->event->purchaser->email }}</div>
                @endisset
            </div>
            
        </td>
        <td class="col-md-4">
            <div class="text-dark text-uppercase fw-bolder">
                @isset($element->bookingType)

                <div> TYP - {{ $element->bookingType }}</div>
                @endisset
                
                <a href="/events/{{$element->event->id}}/edit" class=" text-dark text-uppercase fw-bolder">{{$element->element_name}}</a>
            </div>
            <div>
                @if($element->booking === '1')
                <span class="text-purple">Do rezerwacji</span>
                @elseif($element->booking === '2')
                <span class="text-success">Rezerwacja</span>
                @elseif($element->booking === '3')
                <span class="text-danger text-uppercase">Do anulacji</span>
                @elseif($element->booking === '4')
                <span class="text-muted">Anulowane</span>
                @else
                <span class="text-secondary">Bez rezerwacji</span>
                @endif
            </div>
            @foreach($element->elementContractor as $contractor)                
                <div>{{ $contractor->name }}</div>
                <div>{{ $contractor->firstName}} {{ $contractor->surName }}</div>
                <div>{{ $contractor->street}}, {{ $contractor->city }}</div>
                <div>{{ $contractor->phone }}, {{ $contractor->email }}</div>
            @endforeach

        </td>
        <td col="col-md-3">
            @foreach($element->event->eventPayment as $payment)
                @if($payment->element_id === $element->id)
                    <div>                                                    
                        Planowane: 
                        @php
                            $plannedTotal = $payment->plannedPrice * $payment->plannedQty;
                            echo $plannedTotal;
                        @endphp
                        @if($payment->currency_id!=null) 
                        {{ $payment->currency->symbol }}
                        @else 
                        PLN 
                        @endif
                    </div>
                    <div>
                        Rzeczywiste: 
                        @php
                            $total = $payment->price * $payment->qty;
                            echo $total;
                        @endphp
                        @if($payment->currency_id != null) 
                        {{ $payment->currency->symbol }}
                        @else 
                        PLN 
                        @endif
                    </div>
                        @if($payment->paymentStatus === 1)
                        <div class="text-success">
                            Zapłacone: {{$payment->paymentDate}}
                        </div>
                        @else
                        <div class="text-danger"> 
                            niezapłacone
                        </div>
                        @endif                                                    
                    @endif
            @endforeach
        </td>
</tr>