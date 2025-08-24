
<tr>
    <th scope="row">
        <div>{{ $payment->paymentDate }}</div>
        @isset($payment->invoice)
        <div><span class="font-weight-light">f: </span>{{ $payment->invoice }}</div>
        @endisset
    </th>
    <td>
        <div class="paymenteditlist">
            <a href="#" data-toggle="modal" data-target="#editEventPaymentModal" class="paymenteditlink link-dark text-decoration-none text-uppercase font-weight-bold" data-payment-id={{$payment->id}}>
                {!! $payment->paymentName !!}
            </a>
        </div>
        <div>
            {!! $payment->paymentDescription !!}
        </div>
        <div>
            {!! $payment->paymentNote !!}
        </div>

        {{-- TODO - poprawić kasowanie wydatku --}}

        <div class="btnContainer">
            <form method="POST" action='/eventPayments/delete/{{ $payment->id }}'>
                @csrf
                @method('DELETE')
                    <button type="submit" class="deleteconfirm btn btn btn-link text-decoration-none p-0">usuń</button>
            </form>
        </div>
    </td>
    <td>
        <div><a href="#" data-toggle="modal" data-target="#addPaymentContractor" class="add-payment-contractor-link link-dark text-decoration-none text-uppercase font-weight-bold" data-payment-id={{$payment->id}}>(+)</a></div>
        <div>
            @if($payment->contractor_id != null)
            <div>{{ $payment->contractor->name }} - {{ $payment->contractor->firstname }} {{ $payment->contractor->surname }}</div>
            <div>{{ $payment->contractor->street }}</div>
            <div>{{ $payment->contractor->city }}</div>
            <div>nip: {{ $payment->contractor->nip }}</div>
            <div>tel.: {{ $payment->contractor->phone}}</div>
            <div>email: {{ $payment->contractor->email}}</div>
            @endif
                    <div class="btnContainer">
            <form method="POST" action='/eventPayments/update'>
                @csrf
                @method('PUT')
                    <input type="hidden" name="id" value="{{ $payment->id }}">
                    <input type="hidden" name="contractor_id" value=''>


                    <button type="submit" class="deleteconfirm btn btn btn-link text-decoration-none p-0">usuń</button>
            </form>
        </div>
    </td>
    <td>
        <div>{{ $payment->payer }}</div>


    @if($payment->paymentStatus === 0)
    <div class="text-danger">niezapłacone</div>
    @else
    <div>zapłacone</div>
    @endif
    </td>

    
    {{-- TODO - dodać obsługę zaliczki --}}

    <td>
        <div class="add-advance-link">
            zaliczka: 
            <a href="#" data-toggle="modal" data-target="#addAdvanceModal" class="link-dark text-decoration-none text-uppercase font-weight-bold" data-payment-id={{$payment->id}}>(+)</a>
        </div>
        <div>
            @php
                $advances = \App\Models\Advance::where('payment_id', $payment->id)->get();
            @endphp
            @foreach($advances as $advance)
            <div><a href="#" data-toggle="modal" data-target="#editAdvanceModal" class="advanceeditlink link-dark text-decoration-none text-uppercase font-weight-bold" data-payment-id={{ $advance->id }}>{{ $advance->name }}</a></div>
            <div class="text-danger">Kwota: {{ $advance->total }} {{ $advance->currency->symbol }}</div>
            <div>{{$advance->paymentType->name}} - {{$advance->advance_date}}</div>
                    <div class="btnContainer">
                        <form method="POST" action='/advance/{{ $advance->id }}'>
                        @csrf
                        @method('DELETE')
                    <button type="submit" class="deleteconfirm btn btn btn-link text-decoration-none p-0">usuń</button>
            </form>
        </div>


            
            @endforeach           
            
        </div>
    </td>
            
    </td>
    


        {{-- TODO - dodać walutę --}}

    <td>
        <div ><span class="font-weight-light">razem: </span><span class="font-weight-bold">{{ $payment->plannedPrice * $payment->plannedQty }} PLN</span></div>
        <div class="font-weight-light"><small class="text-muted">({{ $payment->plannedPrice }} PLN x {{ $payment->plannedQty }} szt.)</small></div>
    </td>



    {{-- TODO - zmienić na wydatki rzeczywiste --}}

    <td>
        <div ><span class="font-weight-light">razem: </span><span class="font-weight-bold">{{ $payment->price * $payment->qty }} PLN</span></div>
        <div class="font-weight-light"><small class="text-muted">({{ $payment->price }} PLN x {{ $payment->qty }} szt.)</small></div>
    </td>
</tr>
