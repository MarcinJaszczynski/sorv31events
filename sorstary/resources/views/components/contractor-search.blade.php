<div class="col-md-6">
    <label for="serchfield">Wyszukaj klienta</label>
    <input type="text" class="form-control"  name ="searchfield" placeholder="Wyszukaj klienta" id="search" class="form-control">
    <hr>
    <div id="contractorsCards"></div>
    <div class="card">
    <div class="card-header">
        <input name="purchaser_id" type="radio" value="0" checked>
        <strong>Nowy zamawiający:</strong>
    </div>
    <div class="card-body">
        <div class="card-text">
            <div class="form-group">
                <div class="form-group">
                    <strong>Nazwa firmy/szkoły:</strong>
                {!! Form::text('name', null, array('placeholder' => 'Nazwa', 'id'=>'eventPurchaserName', 'class' => 'form-control')) !!}
                </div>
            <div class="form-group">
                <strong>Imię: </strong>
                {!! Form::text('firstname', null, array('placeholder' => 'Imię', 'id'=>'firstname', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <strong>Nazwisko: </strong>
                {!! Form::text('surname', null, array('placeholder' => 'Nazwisko', 'id'=>'surname', 'class' => 'form-control')) !!}
            </div>
                <strong>telefon kontaktowy:</strong>
                {!! Form::text('phone', null, array('placeholder' => '','id'=>'eventPurchaserPhone','class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <strong>email:</strong>
                {!! Form::email('email', null, array('placeholder' => '','id'=>'eventPurchaserEmail', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <strong>Ulica/nr posesji:</strong>
            </div>
            <div class="form-group">
                {!! Form::text('street', null, array('placeholder' => 'Ulica','id'=>'eventPurchaserStreet', 'class' => 'form-control')) !!}
            </div>
            <div class="form-group">
                <strong>Miejscowość:</strong>
                {!! Form::text('city', null, array('placeholder' => 'miejscowość','id'=>'eventPurchaserCity', 'class' => 'form-control')) !!}
                </div>                                       
            </div>
        </div>
    </div>
</div>