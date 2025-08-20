@extends('layouts.app')
@section('content')

<!-- Start - Modal Cost Create -->

<div class="modal fade" id="createCostModal" role="dialog" aria-labelledby="createCostLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Dodaj nowy wydatek</h4>
            </div>
            {{ Form::open(array('url' => 'eventPayments/store', 'method' => 'post')) }}
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <div class="modal-body">
                <div class="modal-text">

                    {{ Form::label('paymentName', 'Wydatek: ', array('class' => 'awesome')) }}
                    {{ Form::text('paymentName', 'nazwa', ['class'=>'form-control']) }}

                    {{ Form::label('paymentDescription', 'Opis: ', array('class' => 'awesome')) }}
                    {!! Form::textarea('paymentDescription', null, ['rows' => 4, 'class'=>'form-control']) !!}

                    {{ Form::label('payer', 'Płatnik: ', array('class' => 'awesome')) }}
                    {{ Form::select('payer', ['biuro' => 'biuro', 'pilot' => 'pilot'], 'biuro', ['class'=>'form-select']) }}

                    {{ Form::label('paymentStatus', 'Status: ', array('class' => 'awesome')) }}
                    {{ Form::select('paymentStatus', ['0' => 'niezapłacone', '1' => 'zapłacono'], '0', ['class'=>'form-select']) }}

                    {{ Form::label('invoice', 'Faktura: ', array('class' => 'awesome')) }}
                    {{ Form::text('invoice', null, ['class'=>'form-control']) }}

                    {{ Form::label('paymentDate', 'Data: ', array('class' => 'awesome')) }}
                    {{ Form::date('paymentDate', null, ['class'=>'datepicker form-control']) }}

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('price', 'Cena jednostkowa: ', array('class' => 'awesome')) }}
                            {{ Form::text('price', 0, ['class'=>'form-control']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('qty', 'Ilość: ', array('class' => 'awesome')) }}
                            {{ Form::text('qty', 1, ['class'=>'form-control']) }}
                        </div>
                    </div>

                    {{ Form::label('paymentNoten', 'Uwagi: ', array('class' => 'awesome')) }}
                    {!! Form::textarea('paymentNote', null, ['rows' => 4, 'class'=>'form-control']) !!}

                </div>
            </div>
            <div class="modal-bottom">
                <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-trash3"></i> Wyjdź</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<!-- End - Modal Cost Create -->

<!-- Start - Modal Cost Edit -->

<div class="modal fade" id="editCostModal" role="dialog" aria-labelledby="editCostLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Edytuj wydatek</h4>
            </div>
            {{ Form::open(array('url' => 'eventPayments/update', 'method' => 'put')) }}
            @csrf
            <input type="hidden" name="event_id" value="{{ $event->id }}">
            <input type="hidden" name="id" value="" id="id">

            <div class="modal-body">
                <div class="modal-text">

                    {{ Form::label('paymentName', 'Wydatek: ', array('class' => 'awesome')) }}
                    {{ Form::text('paymentName', 'nazwa', ['class'=>'form-control', 'id'=>'costName']) }}

                    {{ Form::label('paymentDescription', 'Opis: ', array('class' => 'awesome')) }}
                    {!! Form::textarea('paymentDescription', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'costDescription']) !!}

                    {{ Form::label('payer', 'Płatnik: ', array('class' => 'awesome')) }}
                    {{ Form::select('payer', ['biuro' => 'biuro', 'pilot' => 'pilot'], 'biuro', ['class'=>'form-select', 'id'=>'costPayer']) }}

                    {{ Form::label('paymentStatus', 'Status: ', array('class' => 'awesome')) }}
                    {{ Form::select('paymentStatus', ['' => 'wybierz','0' => 'niezapłacone', '1' => 'zapłacono'], '0', ['class'=>'form-select', 'id'=>'costStatus']) }}

                    {{ Form::label('invoice', 'Faktura: ', array('class' => 'awesome')) }}
                    {{ Form::text('invoice', null, ['class'=>'form-control', 'id'=>'costInvoice']) }}

                    {{ Form::label('paymentDate', 'Data: ', array('class' => 'awesome')) }}
                    {{ Form::date('paymentDate', null, ['class'=>'datepicker form-control', 'id'=>'costDate']) }}

                    <div class="row">
                        <div class="col-md-6">
                            {{ Form::label('price', 'Cena jednostkowa: ', array('class' => 'awesome')) }}
                            {{ Form::text('price', 0, ['class'=>'form-control', 'id'=>'costPrice']) }}
                        </div>
                        <div class="col-md-6">
                            {{ Form::label('qty', 'Ilość: ', array('class' => 'awesome')) }}
                            {{ Form::text('qty', 1, ['class'=>'form-control', 'id'=>'costQty']) }}
                        </div>
                    </div>

                    {{ Form::label('paymentNoten', 'Uwagi: ', array('class' => 'awesome')) }}
                    {!! Form::textarea('paymentNote', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'costNote']) !!}

                </div>
            </div>
            <div class="modal-bottom">
                <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i class="bi bi-trash3"></i> Wyjdź</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>

<!-- End - Modal Cost Edit -->

<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Opps!</strong> Coś poszło nie tak, sprawdź błędy!!!<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        <div class="card">
            <div class="card-header">
                <div class="row justify-content-between">
                    <div class="col-6">
                        <h3>Wydatki: {{ $event->eventName }}</h3>
                        <h5>data: {{ date('d.m.Y',  strtotime($event->eventStartDateTime)) }} - {{ date('d.m.Y',  strtotime($event->eventEndDateTime)) }}
                    </div>
                    <div class="col-6 btn-group float-end" role="group">

                        {{ Form::open(array('route' => array('eventPaymentsIndex'), 'method'=>'get')) }}
                        <button type="button" class="btn btn-outline-success " id="btnAddCost">
                            <i class="bi bi-currency-euro"></i> Nowy wydatek
                        </button>
                        {!! Form::close() !!}

                        {{ Form::open(array('route' => array('events.edit',$event->id), 'method'=>'get')) }}
                        <button type="submit" class="btn btn-outline-primary "><i class="bi bi-skip-backward-fill"></i> powrót do imprezy
                        </button>
                        {!! Form::close() !!}

                        {{ Form::open(array('route' => array('events.index'), 'method'=>'get')) }}
                        <button type="submit" class="btn btn-outline-primary "><i class="bi bi-skip-backward-fill"></i> wszystkie imprezy
                        </button>
                        {!! Form::close() !!}



                        <!-- <a class="btn btn-outline-primary float-end " href="{{ route('events.index') }}"><i class="bi bi-skip-backward-fill"></i> wszystkie imprezy</a> -->
                    </div>
                </div>
            </div>





            <table class="table table-striped table-hover" width="100%">
                <thead>
                    <th class="d-none">id</th>
                    <td>Data</td>
                    <td>Faktura</td>
                    <td>Nazwa</td>
                    <td>Opis</td>
                    <td>Status</td>
                    <td>Płatnik</td>
                    <td>C.jedn</td>
                    <td>Ilość</td>
                    <td>Suma</td>
                    <td>Notatki</td>
                    <td>Akcje</td>
                </thead>

                @foreach($data as $payment)

                <tr>
                    <td class="d-none">{{ $payment->id }}</td>
                    <td>{{ $payment->paymentDate }}</td>
                    <td>{{ $payment->invoice }}</td>
                    <td>{{ $payment->paymentName }}</td>
                    <td>{{ $payment->paymentDescription }}</td>

                    @if($payment->paymentStatus === 0)
                    <td class="notPay">niezapłacone</td>
                    @else
                    <td>zapłacone</td>
                    @endif


                    <td>{{ $payment->payer }}</td>
                    <td>{{ $payment->price }}</td>
                    <td>{{ $payment->qty }}</td>
                    <td>{{ $payment->price * $payment->qty }}</td>
                    <td>{{ $payment->paymentNote }}</td>
                    <td>
                        <div class="btn-group float-end" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-outline-success btnEditCost" id="btnEditCost">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <form action="/eventPayments/delete/{{ $payment->id }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-outline-danger"><i class="bi bi-trash3"></i></button>
                            </form>
                    </td>

                </tr>

                @endforeach

                <tr>
                    <td colspan="8"></td>
                    <td colspan="2">
                        <h4 class="float-end">Wydatki łącznie:</h4>
                    </td>
                    <td colspan="2">
                        <h4>{{ $event->totalSum($event->id) }}</h4>
                    </td>
                </tr>
                <tr>
                    <td colspan="8"></td>
                    <td colspan="2">
                        <h5 class="float-end">Zapłacone:</h5>
                    </td>
                    <td colspan="2">
                        <h5>{{ $event->paidSum($event->id) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="8"></td>
                    <td colspan="2">
                        <h5 class="float-end">Pozostało:</h5>
                    <td colspan="2">
                        <h5>{{ $event->totalSum($event->id) - $event->paidSum($event->id) }}</h5>
                    </td>
                </tr>
                <tr>
                    <td colspan="8"></td>
                    <td colspan="2">
                        <h5 class="float-end">Wydatki pilota:</h5>
                    </td>
                    <td colspan="2">
                        <h5>{{ $event->pilotSum($event->id) }}</h5>
                        <div><strong>zaliczka: </strong>{{ $event->	eventAdvancePayment }}
                    </td>
                </tr>


            </table>



        </div>

        <!-- Start - skrypty -->

        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

        <!-- Start - Wyświetlanie Modal Create Cost -->
        <script>
            $(document).ready(function() {
                $('#btnAddCost').on('click', function() {
                    $('#createCostModal').modal('show');
                })
            })
        </script>
        <!-- End - Wyświetlanie Modal Create Cost -->


        <!-- Start - Wyświetlanie Danych Modal Edit Cost -->

        <!-- <script>
    $(document).ready(function(){
        $('.btnEditCost').on('click', function(){
            $('#editCostModal').modal('show');
        })
    })

</script> -->


        <!-- Start - Wyświetlanie Danych Modal Edit Cost -->

        <script>
            $(document).ready(function() {

                $('.btnEditCost').on('click', function() {

                    $('#editCostModal').modal('show');

                    $tr = $(this).closest('tr');

                    var data = $tr.children("td").map(function() {
                        return $(this).text();
                    }).get();


                    // var data = $tr.children("td").map(function () {
                    //     return $(this).text();
                    // }).get();

                    console.log(data[5]);

                    $('#id').val(data[0]);
                    $('#costDate').val(data[1]);
                    $('#costInvoice').val(data[2]);
                    $('#costName').val(data[3]);
                    $('#costDescription').val(data[4]);

                    switch (data[5]) {
                        case "zapłacone":
                            $('#costStatus').val(1)
                            break;
                        default:
                            $('#costStatus').val(0)
                            break;

                    }


                    $('#costStatus').val(data[5]);
                    $('#costPayer').val(data[6]);
                    $('#costPrice').val(data[7]);
                    $('#costQty').val(data[8]);
                    $('#costNote').val(data[10]);



                });
            });
        </script>

        <script>
            const makeNotPayRed = () => {
                let notPay = document.getElementsByClassName('notPay')
                console.log(notPay)
                for (var element of notPay) {

                    element.style.color = "red"
                    element.style.textTransform = "uppercase"
                }
            }
            makeNotPayRed()
        </script>


        <!-- End - skrypty -->
        @endsection