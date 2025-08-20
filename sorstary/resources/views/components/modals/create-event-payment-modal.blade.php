<div class="modal fade" id="createEventPaymentModal" role="dialog" aria-labelledby="createCostLabel" aria-hidden="true">
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
                <div class="btn-group m-3 float-end" role="group" aria-label="Zamykacz">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>