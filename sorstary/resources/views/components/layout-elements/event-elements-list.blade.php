@php
$eventElements = \App\Models\EventElement::orderBy('eventElementStart', 'desc')->where('eventIdinEventElements', $event->id)->get();
@endphp
<x-modals.add-element-payment-modal :currencies='$currencies' :event='$event' :eventElements='$eventElements' />
<x-modals.add-element-contractor-modal :event='$event' />
<div>
    <div class="container">
        <div class="d-flex justify-content-between align-items-center my-3">
            <h4>Program imprezy</h4>
            <button type="button" data-toggle="modal" data-target="#createEventElementModal" class="btn btn-link link-secondary"><i class="bi bi-plus-square"></i> dodaj punkt programu</button>
        </div>
    <div class="row justify-content-between my-3">
        {{-- <div class="col">
            <h4 class="m-0">Program imprezy</h4>
        </div> --}}
        <div>


            <div>
                @php
                $elements = $event->getEventElements($event->id);
                @endphp

            </div>
        </div>



        {{-- <div class="col text-right">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventElementModal"><i class="bi bi-plus"></i>Nowy punkt programu</button>
        </div> --}}
    </div>
    <div>
        <table class="table table-striped">
            <tbody>
            @php
                $oldday = new Date();
            @endphp   
            
                
            @foreach($elements as $eventElement)
            @if($eventElement->active == 1)

            @php
                $newday = \Carbon\Carbon::parse($eventElement->eventElementStart)->format('d-m-Y');
                if($newday!=$oldday){
                    echo '<tr class="bg-success"><td colspan="6" class="bg-success"><h4>'.$newday.'</h4></td></tr>';
                }             
            @endphp
            
            <tr>
                <td>
                    {{\Carbon\Carbon::parse($eventElement->eventElementStart)->format('H:i')}}-{{\Carbon\Carbon::parse($eventElement->eventElementEnd)->format('H:i')}}</div>
                </td>
                <td>
                    <div class="d-flex justify-content-start">
                        <div class="eventeditlink">
                            <a href="#" data-toggle="modal" data-target="#editEventElementModal" class="link-secondary text-decoration-none text-uppercase font-weight-bold" data-element-id={{$eventElement->id}}>
                                {!! $eventElement->element_name !!}
                            </a>
                        </div>
                        <div>
                            <form method="POST" action='/eventelements/{{ $eventElement->id }}'>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    
                        @if($eventElement->booking === '1')
                        <div class="text-purple">Do rezerwacji</div>
                        @elseif($eventElement->booking === '2')
                        <div class="text-success">Rezerwacja</div>
                        @elseif($eventElement->booking === '3')
                        <div class="text-danger text-uppercase">Do anulacji</div>
                        @elseif($eventElement->booking === '4')
                        <div class="text-muted">Anulowane</div>
                        @else
                        <div class="text-secondary">Bez rezerwacji</div>
                        @endif
                        
                    <div>
                        {!! $eventElement->eventElementDescription !!}
                    </div>
                    <div>
                        {!! $eventElement->eventElementNote !!}
                    </div>
                    <div>
                        {!! $eventElement->eventElementContact !!}
                    </div>



                </td>
                {{-- TODO - dodać wyswietlanie rezerwacji na czerwono czy coś --}}

                <td>
                    <div class="addElementContractorLink">Kontrahent 
                        <a href="#"  class="text-decoration-none link-secondary" data-toggle="modal" data-target="#addElementContractorModal" data-elementid = "{{ $eventElement->id }}" data-elementname = "{{ $eventElement->element_name }}">(+)</a>
                    </div>
                    @foreach($eventContractors as $eventContractor)
                        @if($eventContractor->eventelement_id === $eventElement->id)
                            <div class="d-flex justify-content-start mt-3">
                                <div class="font-weight-bold text-uppercase">{!! $eventContractor->contractor->name !!}  </div>
                                <div>
                                    <form method="POST" action="/eventcontractors/{{$eventContractor->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div>{!! $eventContractor->contractor->firstName !!} {!! $eventContractor->contractor->surname !!}</div>
                            <div>{!! $eventContractor->contractor->street !!}, {!! $eventContractor->contractor->city !!}</div>
                            <div>tel.: {!! $eventContractor->contractor->phone !!}</div>
                            <div>email: {!! $eventContractor->contractor->email !!}</div>
                        @endif
                    @endforeach
                    {{-- <div data-reservation="{{$eventElement->booking}}">Kontrahent <span class="addelementcontractorlink"><a href="#" data-toggle="modal" data-target="#addElementContractorModal" class="link-secondary text-decoration-none text-uppercase font-weight-bold" data-event-id={{$event->id}} data-element-id={{$eventElement->id}}>(+)</a></span></div>                     --}}
                </td>
                <td>
                    {{-- TODO - dodać zaliczkę do eventElement i coś wymyslić z tym g... Pewnie dodać powiązanie płatności z element --}}
                    <div class="addelementpayment">Płatności  
                        <a href="#" data-toggle="modal" data-target="#addPaymentModal" class="link-secondary text-decoration-none text-uppercase font-weight-bold" data-event-id="{{$event->id}}" data-element-id="{{$eventElement->id}}" data-element-name="{{$eventElement->element_name}}">(+)</a>
                                            @foreach($payments as $payment)
                                                @if($payment->element_id === $eventElement->id)
                                                <div class="font-weight-bold">{!! $payment->paymentName !!}</div>
                                                <div>
                                                    Planowane: 
                                                    @php
                                                        $plannedTotal = $payment->plannedPrice * $payment->plannedQty;
                                                        echo $plannedTotal;
                                                    @endphp
                                                    @if($payment->currency_id != null) 
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
                                    </div>
                </td>
                <td>
                    {!! $eventElement->eventElementReservation !!}
                </td>
                <td>
                    <div>P:{{$eventElement->eventElementPilotPrint}}</div>
                    <div>H:{{$eventElement->eventElementHotelPrint}}</div>
                </td>
            </tr>
            @php
                $oldday = $newday
            @endphp
            @endif
            @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-between align-items-center my-3">
            <h4>Archiwum elementów</h4>
        </div>
         <table class="table table-striped">
            <tbody>
            @php
                $oldday = new Date();
            @endphp   
            
                
            @foreach($elements as $eventElement)
            @if($eventElement->active == 0)

            @php
                $newday = \Carbon\Carbon::parse($eventElement->eventElementStart)->format('d-m-Y');
                if($newday!=$oldday){
                    echo '<tr class="bg-secondary"><td colspan="6" class="bg-success"><h4>'.$newday.'</h4></td></tr>';
                }             
            @endphp
            
            <tr>
                <td>
                    {{\Carbon\Carbon::parse($eventElement->eventElementStart)->format('H:i')}}-{{\Carbon\Carbon::parse($eventElement->eventElementEnd)->format('H:i')}}</div>
                </td>
                <td>
                    <div class="d-flex justify-content-start">
                        <div class="eventeditlink">
                            <a href="#" data-toggle="modal" data-target="#editEventElementModal" class="link-secondary text-decoration-none text-uppercase font-weight-bold" data-element-id={{$eventElement->id}}>
                                {!! $eventElement->element_name !!}
                            </a>
                        </div>
                        <div>
                            <form method="POST" action='/eventelements/{{ $eventElement->id }}'>
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </div>
                    
                        @if($eventElement->booking === '1')
                        <div class="text-purple">Do rezerwacji</div>
                        @elseif($eventElement->booking === '2')
                        <div class="text-success">Rezerwacja</div>
                        @elseif($eventElement->booking === '3')
                        <div class="text-danger text-uppercase">Do anulacji</div>
                        @elseif($eventElement->booking === '4')
                        <div class="text-muted">Anulowane</div>
                        @else
                        <div class="text-secondary">Bez rezerwacji</div>
                        @endif
                        
                    <div>
                        {!! $eventElement->eventElementDescription !!}
                    </div>
                    <div>
                        {!! $eventElement->eventElementNote !!}
                    </div>
                    <div>
                        {!! $eventElement->eventElementContact !!}
                    </div>



                </td>
                {{-- TODO - dodać wyswietlanie rezerwacji na czerwono czy coś --}}

                <td>
                    <div class="addElementContractorLink">Kontrahent 
                        <a href="#"  class="text-decoration-none link-secondary" data-toggle="modal" data-target="#addElementContractorModal" data-elementid = "{{ $eventElement->id }}" data-elementname = "{{ $eventElement->element_name }}">(+)</a>
                    </div>
                    @foreach($eventContractors as $eventContractor)
                        @if($eventContractor->eventelement_id === $eventElement->id)
                            <div class="d-flex justify-content-start mt-3">
                                <div class="font-weight-bold text-uppercase">{!! $eventContractor->contractor->name !!}  </div>
                                <div>
                                    <form method="POST" action="/eventcontractors/{{$eventContractor->id}}">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                            <div>{!! $eventContractor->contractor->firstName !!} {!! $eventContractor->contractor->surname !!}</div>
                            <div>{!! $eventContractor->contractor->street !!}, {!! $eventContractor->contractor->city !!}</div>
                            <div>tel.: {!! $eventContractor->contractor->phone !!}</div>
                            <div>email: {!! $eventContractor->contractor->email !!}</div>
                        @endif
                    @endforeach
                    {{-- <div data-reservation="{{$eventElement->booking}}">Kontrahent <span class="addelementcontractorlink"><a href="#" data-toggle="modal" data-target="#addElementContractorModal" class="link-secondary text-decoration-none text-uppercase font-weight-bold" data-event-id={{$event->id}} data-element-id={{$eventElement->id}}>(+)</a></span></div>                     --}}
                </td>
                <td>
                    {{-- TODO - dodać zaliczkę do eventElement i coś wymyslić z tym g... Pewnie dodać powiązanie płatności z element --}}
                    <div class="addelementpayment">Płatności  
                        <a href="#" data-toggle="modal" data-target="#addPaymentModal" class="link-secondary text-decoration-none text-uppercase font-weight-bold" data-event-id="{{$event->id}}" data-element-id="{{$eventElement->id}}" data-element-name="{{$eventElement->element_name}}">(+)</a>
                                            @foreach($payments as $payment)
                                                @if($payment->element_id === $eventElement->id)
                                                <div class="font-weight-bold">{!! $payment->paymentName !!}</div>
                                                <div>
                                                    Planowane: 
                                                    @php
                                                        $plannedTotal = $payment->plannedPrice * $payment->plannedQty;
                                                        echo $plannedTotal;
                                                    @endphp
                                                    @if($payment->currency_id != null) 
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
                                    </div>
                </td>
                <td>
                    {!! $eventElement->eventElementReservation !!}
                </td>
                <td>
                    <div>P:{{$eventElement->eventElementPilotPrint}}</div>
                    <div>H:{{$eventElement->eventElementHotelPrint}}</div>
                </td>
            </tr>
            @php
                $oldday = $newday
            @endphp
            @endif
            @endforeach
            </tbody>
        </table>
    </div>
</div> 
</div> 

<script>







</script>
    

