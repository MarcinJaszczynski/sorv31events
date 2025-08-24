@extends('layouts.app')
@section('content')


<!-- Modal HTML -->

<div class="container">
    <div class="justify-content-center">
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Ups!</strong> Coś poszło nie tak. Sprawdź błędy poniżej!<br><br>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
    </div>
        @endif
        <div class="card">
            <div class="card-header">
                Szybkie zapytanie
                <span class="float-right">
                    <a class="btn btn-primary" href="{{ route('events.index') }}">Imprezy</a>
                </span>
            </div>
            <div class="card-body">
                <div class="card-text">                              
                        {{ Form::open(array('route' => 'eventinit.store', 'method'=>'POST')) }}
                        <input type="hidden" name="author_id" value="{{ Auth::user()->id }}">
                        <input type="hidden" name="statusChangeDatetime" value="{{ Carbon\Carbon::now() }}">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <strong>Nazwa:</strong>
                                        {!! Form::text('eventName', null, array('placeholder' => 'Nazwa','class' => 'form-control')) !!}                                                        
                                    </div>
                                    <div class="form-group">
                                        <strong>Kod imprezy:</strong>
                                        {!! Form::text('eventOfficeId', now()->format('Ymd/Hi'), array('placeholder' => now()->format('Ymd/Hi'),'class' => 'form-control')) !!}
                                    </div>
                                    <div class="form-group">
                                        <strong>Łączna ilość uczestników:</strong>
                                        {!! Form::text('eventTotalQty', null, array('placeholder' => 'Uczestnicy','class' => 'form-control')) !!}
                                    </div>
                                    <input type="hidden" name="eventStatus" value="Zapytanie">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <strong>długość wycieczki: </strong>
                                                {{ Form::input('text', 'duration', 1, ['id'=>'duration', 'class' => 'form-control']) }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong>Termin od: </strong>
                                                {{ Form::input('dateTime-local', 'eventStartDateTime', null, ['id' => 'eventStartDateTime', 'class' => 'form-control']) }}
                                            </div>
                                            <div class="col-md-4">
                                                <strong> do: </strong>
                                                {{ Form::input('dateTime-local', 'eventEndDateTime', null, ['id' => 'eventEndDateTime', 'class' => 'form-control']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <strong>Zamówienie:</strong>
                                            {{ Form::textarea('orderNote', null, array('placeholder' => 'Notatki','class' => 'form-control', 'class'=>'editEventNote')) }}
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-6">
                                        <label for="searchfield">Wyszukaj klienta</label>
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
                                </div>
                                <div class="row">
                                    <div class="container">
                                        <button type="submit" class="btn btn-primary">Zapisz</button></div>
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                    </div>




    @endsection

    

@section('scripts')
        

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>


 

<script>
    $(document).ready(function() {
        $(".editEventNote").summernote();
        $('.dropdown-toggle').dropdown();
    });

$('#search').on('keyup', function(){
    search();
});

function search(){
     var keyword = $('#search').val();
     $.post('{{ route("customersearch.search") }}',
      {
         _token: $('meta[name="csrf-token"]').attr('content'),
         keyword:keyword,
         contractortype: '4'

       },
       function(data){
        table_post_row(data);
       });
}
// table row with ajax
function table_post_row(res){
let htmlView = '';
let contractorCard = '';
if(res.contractors.length <= 0){
    htmlView+= `
       <tr>
          <td colspan="4">Brak danych.</td>
      </tr>`;
}
for(let i = 0; i < res.contractors.length; i++){
    htmlView += `
        <tr>
           <td>`+ (i+1) +`</td>
              <td>`+res.contractors[i].name+`</td>
               <td>`+res.contractors[i].phone+`</td>
        </tr>`;

    contractorCard += `
        <div class="card">
            <div class="card-header">
                <h5><input name="purchaser_id" type="radio" value="`+res.contractors[i].id+`">
`+res.contractors[i].name+`</h5>            
            </div>
            <dic class="card-body">
                <div>Imię: `+res.contractors[i].firstname+`</div>
                <div>Nazwisko: `+res.contractors[i].surname+`</div>
                <div>tel: `+res.contractors[i].phone+`</div>
                <div>email: `+res.contractors[i].email+`</div>
                <div>ul: `+res.contractors[i].street+`</div>
                <div>województwo: `+res.contractors[i].region+`</div>
                <div>
            </div>

        </div>`;    

        $('#eventPurchaserName').val(res.contractors[i].name)
        $('#eventPurchaserPhone').val(res.contractors[i].phone)
        $('#eventPurchaserEmail').val(res.contractors[i].email)
        $('#eventPurchaserStreet').val(res.contractors[i].street)
        $('#eventPurchaserCity').val(res.contractors[i].city)
        $('#eventPurchaserRegion').val(res.contractors[i].region)

}
     $('tbody').html(htmlView);
     $('#contractorsCards').html(contractorCard);
}
</script>

@endsection


