@extends('layouts.app')
@section('content')
<div class="container">

<h1> Kontrahent </h1>
<br>

@php
  $contractorTypes =  \App\Models\ContractorType::get();
  $contractorEvents = $contractor->contractorevents;
  $contractorEvents=$contractorEvents->sortBy('eventStartDateTime');
@endphp



<div class = "row">
  <div class = "col">
    <h1>{!!$contractor->name!!}</h1>
    <hr>
  </div>
</div>
<div class = "row">
  <div class = "col-md-6">
    <h4>Imię i nazwisko: {!!$contractor->firstname!!} {!!$contractor->surname!!}</h4>
    <h4>Adres: {!!$contractor->street!!}, {!!$contractor->city!!}</h4>
    <h4>tel.: {!!$contractor->phone!!} </h4>
    <h4>mail.: {!!$contractor->email!!}</h4>
    <h4>www.: {!!$contractor->www!!}</h4>    
  </div>
  <div class="col-md-6">
    <h4>Rodzaj kontrahenta:</h4>
      @foreach($contractor->type as $ctype)
        <h4>{!!$ctype->name!!}</h4>
      @endforeach
    <hr>
    <h4>Uwagi:</h4>
    <h5>{!!$contractor->description!!}</h5>


  </div>
</div>
<hr>
<div class='row'>
  <div class="col">
    <h4>Imprezy kontrahenta</h4>

    <table class="table table-hover">


    @foreach($contractorEvents->where('eventStatus','!=','Anulowane')->unique('id') as $cevent)
      @php
        $ceventElements = $cevent->eventElements->sortBy('eventElementStart');
      @endphp
      <tr>
        <td>
          {!!$cevent->eventStartDateTime!!}<br>
          {!!$cevent->eventEndDateTime!!}
        </td>
        <td><a href="/events/{{$cevent->id}}/edit" class="text-uppercase font-weight-bold text-decoration-none text-dark">{!! $cevent->eventName !!}</a> (os. {!!$cevent->eventTotalQty!!})
          <div>({!!$cevent->eventOfficeId!!})</div>
        <div>
          

          @isset($ceventElements)
          {{-- {{$ceventElements->elementName}} --}}
          
            @foreach($ceventElements as $ceventElement)
            
              @isset($ceventElement->elementContractor)
              
                @foreach($ceventElement->elementContractor as $eContractor)

                

                  @if($eContractor->id === $contractor->id)
                    <div>{!! $ceventElement->eventElementStart !!} - {!! $ceventElement->eventElementEnd!!} - <span class="font-weight-bold text-uppercase text-muted">{!!$ceventElement->element_name!!} </span> - rezerwacja: 
                      @switch($ceventElement->booking)
                        @case('0')
                            <span class="text-dark font-weight-bold text-uppercase">bez rezerwacji</span>
                            @break            
                        @case('1')
                            <span class="text-primary font-weight-bold text-uppercase">do rezerwacji</span>
                            @break
                        @case('2')
                            <span class="text-success font-weight-bold text-uppercase">zarezerwowany</span>
                            @break
                        @case('3')
                            <span class="text-danger font-weight-bold text-uppercase">do anulacji</span>
                            @break
                        @case('4')
                            <span class="text-muted font-weight-bold text-uppercase">anulowany</span>
                            @break
            
                        @default
                            <span class="status">???</span>
                       @endswitch
                        - status: 
                      @switch($ceventElement->active)
                        @case('0')
                            <span class="text-muted">Nieaktywny</span>
                            @break
            
                        @case('1')
                            <span class="text-dark text-uppercase">Aktywny</span>
                            @break
            
                        @default
                            <span class="status">???</span>
                       @endswitch
                      </div>

                              {{-- {{$ceventElement->element_name}} --}}

                  
                    {{-- <div>{!!$ceventElement->eventElementStart!!} - {!!$ceventElement->eventElementEnd !!} - <span class="{!! $ceventElement->element_name !!} - rezerwacja:{!! $ceventElement->booking !!}</div> --}}
                  @endif
                @endforeach
              @endisset
            @endforeach
          @endisset
        </div>
        </td>
        <td>{{$cevent->eventStatus}}</td>
      </tr>
      <tr>
        <td>
        </td>
        <td>
        {{-- {{ $cevent->eventElements }} --}}

        </td>
        <td>
        </td>

      </tr>
    @endforeach
    </table>

  </div>
</div>
<div class = "row">
  <div class="col">
      <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#contractorEdit" aria-expanded="false" aria-controls="collapseContractorEdit">
    edycja
  </button>
  </div>
</div>

<div class="collapse" id="contractorEdit">

<form method="post" action="{{ route('contractors.update', $contractor->id ) }}">
          <div class="form-group">
              @csrf
              @method('PATCH')


  <div class="m-3">
        <div class="row">
            <div class="col-md-6">
              <label>Dane kontrahenta</label>
              <div class="form-group">
              <label>Imię i nazwisko/Nazwa kontrahenta</label>
              <input type="text" class="form-control" name="name"  value="{!! $contractor->name !!}">
              </div>
              

              <div class="form-group row">
              <label class="col-sm-3 col-form-label">Imię: </label>
              <div class="col-sm-9">
              <input type="text" class="form-control" name="firstname" value="{!! $contractor->firstname !!}"> 
              </div>
              </div>

              <div class="form-group row"> 
              <label class="col-sm-3 col-form-label">Nazwisko:</label> 
              <div class="col-sm-9">      
              <input type="text" class="form-control" name="surname" value="{{ $contractor->surname }}"> 
              </div> 
              </div>

              <div class="form-group row">    
              <label class="col-sm-3 col-form-label">Ulica nr budynku:</label>
              <div class="col-sm-9">
              <input type="text" name="street" class="form-control" value="{{ $contractor->street }}"> 
              </div>
              </div>

              <div class="form-group row">             
              <label class="col-sm-3 col-form-label">Miasto:</label>
              <div class="col-sm-9">
              <input type="text" name="city" class="form-control form-control-border" value="{{ $contractor->city }}">
              </div>
              </div>                  

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">NIP: </label>
                <div class="col-sm-9">
                <input type="text" class="form-control form-control-border" name="nip" value="{{ $contractor->nip }}">
                </div>
              </div>

              <label>Kontakt</label>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tel.:</label>
                <div class="col-sm-9">
                <input type="text" class="form-control form-control-border" name="phone" value="{{ $contractor->phone }}">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Email: </label>
                <div class="col-sm-9">
                <input type="email" class="form-control form-control-border" name="email" value="{{ $contractor->email }}">
                </div>
              </div>

              <div class="form-group row">
                <label class="col-sm-3 col-form-label">WWW: </label>
                <div class="col-sm-9">
                <input type="text" class="form-control form-control-border" name="www" value="{{ $contractor->www }}">
                </div>
              </div>

               
            </div>
            <div class="col-md-6">
              <div class="form-group">
                <h4>Rodzaj kontrahenta</h4>
                
                  @foreach($contractorTypes as $type)
                  <div>
                  <input class="orm-check-input" type="checkbox" id="{{$type->name}}"" name="contractortype[]" value="{{$type->id}}" 
                  @foreach($contractor->type as $ctype)
                    @if($type->id === $ctype->id)
                      checked
                    @endif
                  @endforeach
                  />
                  <label class="form-check-label" for="{{$type->name}}">{{$type->name}}</label>

                  </div>   
                  {{-- <option value="{{$type->id}}">{{$type->name}}</option> --}}
                  @endforeach
              </div>


                              
              <label for="name">Komentarz:</label>
              <textarea class="summernoteeditor m-3" name="description">{{ $contractor->description }} </textarea>
            </div>
        </div>
      </div>
        <button type="submit" class="btn btn-primary">Zapisz</button>
    </form>
</div>
</div>

@endsection

{{-- @extends('layouts.app')
@section('content')

<div class="container">

<h1> Kontrahenci - edit </h1>

<form method="post" action="{{ route('contractors.update', $contractor->id ) }}">
          <div class="form-group">
              @csrf
              @method('PATCH')

                          <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="name">Nazwa</label>
      <input type="text" class="form-control" id="name" name="name" value="{{ $contractor->name }}" required>
    </div>
  </div>

  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="name">Imię</label>
      <input type="text" class="form-control" id="firstname" name="firstname" value="{{ $contractor->firstname }}">
    </div>
  </div>
              <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="name">Nazwisko</label>
      <input type="text" class="form-control" id="surname" name="surname" value="{{ $contractor->surname }}">
    </div>
  </div>
  
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="street">Ulica</label>
      <input type="text" class="form-control" id="street" name="street" value="{{ $contractor->street }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="city">Miejscowość</label>
      <input type="text" class="form-control" id="city" name="city" value="{{ $contractor->city }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="region">Województwo</label>
      <input type="text" class="form-control" id="region" name="region" value="{{ $contractor->region }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="country">Kraj</label>
      <input type="text" class="form-control" id="country" name="country" value="{{ $contractor->country }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="nip">nip: </label>
      <input type="number" class="form-control" id="nip" name="nip" value="{{ $contractor->nip }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="phone">tel.: </label>
      <input type="tel" class="form-control" id="phone" name="phone" value="{{ $contractor->phone }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="email">email:  </label>
      <input type="email" class="form-control" id="email" name="email" value="{{ $contractor->email }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="www">Adress www: </label>
      <input type="text" class="form-control" id="www" name="www" value="{{ $contractor->www }}">
    </div>   
  </div>
  <div class="form-row">
    <div class="col-md-4 mb-3">
      <label for="description">notatki: </label>
      <input type="text-area" class="form-control" id="description" name="description" value="{{ $contractor->description }}">
    </div>   
  </div>
<div class="btn-group" role="group">
  <button class="btn btn-primary" type="submit">Dodaj</button>
  <a href="{{ route('contractors.index') }}" class="btn btn-danger">Cofnij</a>
</div>
        </div>
    </div>
</form>
</div>





    <script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script></div>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



<script>
    $(document).ready(function() {
        $("#editEventNote").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script>
@endsection --}}