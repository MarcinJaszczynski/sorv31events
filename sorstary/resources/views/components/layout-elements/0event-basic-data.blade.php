@php
$eventcontractors = \App\Models\EventContractor::with('contractor')->where('event_id', $event->id)->get();
@endphp

<x-modals.add-event-driver-modal :eventid='$event->id' />
<x-modals.add-event-carrier-modal :eventid='$event->id' />
<x-modals.add-event-hotel-modal :eventid='$event->id' />
<x-modals.add-pilot-modal :eventid='$event->id' />
{{-- <x-modals.add-event-purchaser-modal :eventid='$event->id' /> --}}
<x-modals.edit-contractor-modal />

<div class="invoice mb-3 p-3">
    <div class="row justify-content-between">
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-12 m-3">
                    <h4>Dane imprezy</h4>
                </div>
            </div>
            
            <div class="row">                
                <div class="col-md-4">
                    <form action="/events/{{ $event->id}}" method="POST">
                    @csrf
                    @method('PATCH')
                        <div class="card">
                            <div class="card-header">
                                <h4>Impreza</h4>
                            </div>
                        <div class="card-body">
                            <div class="card-text">
                                <div class="form-group mb-3">
                                    <label for="eventName">Nazwa: </label>
                                    <input type="text" class="form-control form-control-border" name="eventName" value="{{$event->eventName}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventOfficeId">Kod: </label>
                                    <input type="text" class="form-control form-control-border" name="eventOfficeId" value="{{$event->eventOfficeId}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Ilość dni: </strong></span>
                                    </div>
                                    <input type="text" class="form-control" name="duration" value="{{ $event->duration }}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Start: </strong></span>
                                    </div>
                                    <input type="datetime-local" class="form-control" name="eventStartDateTime" value="{{date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime))}}">
                                </div>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                    <span class="input-group-text"><strong>Koniec: </strong></span>
                                    </div>
                                    <input type="datetime-local" class="form-control" name="eventEndDateTime" value="{{date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime))}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventStatus">Status: </label>
                                        <select class="custom-select form-control form-control-border" name="eventStatus">
                                            <option value="{{ $event->eventStatus }}" checked>{{ $event->eventStatus }}</option>
                                            <option value="Zapytanie">Zapytanie</option>
                                            <option value="oferta">Oferta</option>
                                            <option value="Potwierdzona">Potwierdzona</option>
                                            <option value="OdprawaOK">Odprawa</option>
                                            <option value="DoRozliczenia">Do rozliczenia</option>
                                            <option value="Zakończona">Rozliczona</option>
                                            <option value="Archiwum">Archiwum</option>
                                            <option value="doanulacji">DO ANULACJI</option>
                                            <option value="Anulowana">Anulowane</option>                                            
                                        </select>
                                     </div>
                                     <div class="row">
                                    <div class="form-group mb-3 col-4">
                                    <label for="ventTotalQty">Łączna ilość uczestników: </label>
                                    <input type="text" class="form-control form-control-border" name="eventTotalQty" value="{{$event->eventTotalQty}}">
                                </div>
                                <div class="form-group mb-3 col-4">
                                    <label for="eventGuardiansQty">Ilość opiekunów: </label>
                                    <input type="text" class="form-control form-control-border" name="eventGuardiansQty" value="{{$event->eventGuardiansQty}}">
                                </div>
                                <div class="form-group mb-3 col-4">
                                    <label for="eventFreeQty">Ilość uczestników w gratisie: </label>
                                    <input type="text" class="form-control form-control-border" name="eventFreeQty" value="{{$event->eventFreeQty}}">
                                </div>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventDietAlert">Dieta: </label>
                                    <input type="text" class="form-control form-control-border" name="eventDietAlert" value="{{$event->eventDietAlert}}">
                                </div>
                            <div class="form-group mb-3">
                            <label for="eventNote">Uwagi do zamówienia</label>
                            <textarea id="editEventNote" name="orderNote" rows="6" class="form-control summernoteeditor">
                                    {!! $event->orderNote !!}
                                </textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="eventNote">Uwagi biura</label>
                                <textarea id="editEventNote" name="eventNote" rows="6" class="form-control summernoteeditor">
                                    {!! $event->eventNote !!}
                                </textarea>
                            </div>
                        </div>
                    </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">Aktualizuj</button>
                        </div>
                   </form>
                </div>
            </div>
                <div class="col-md-4">

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Piloci</h4>
                                    <button type="button" data-toggle="modal" data-target="#addEventPilotModal" class="btn btn-link link-secondary"><i class="bi bi-plus-square"></i></button>
                                </div>


                            </div>
                            <div class="card-body">
                                @foreach($eventcontractors->where('contractortype_id', 5)->unique('contractor_id') as $eventcontractor)
                                            <div class="d-flex justify-content-between">
                                                <div class="font-weight-bold text-uppercase">
                                                    {{-- {{$eventcontractor->contractor->name}} --}}
                                                    <a href="/contractors/{{$eventcontractor->contractor->id}}/edit" class="text-decoration-none text-muted text-uppercase" target="blank">{{$eventcontractor->contractor->name}}</a>
                                                    {{-- <button type="button" class="btn btn-link p-0  text-decoration-none text-muted text-uppercase font-weight-bold editcontractorlink" data-toggle="modal" data-target=".edit-contractor-modal" data-contractorid="{{$eventcontractor->contractor->id}}">{{$eventcontractor->contractor->name}}</button> --}}
                                                </div>
                                                <div>
                                                    <form method="POST" action="/eventcontractors/{{$eventcontractor->id}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div>{{$eventcontractor->contractor->firstname}} {{$eventcontractor->contractor->surname}}</div>
                                            <div>tel.: {{$eventcontractor->contractor->phone}} </div>
                                            <div>email: {{$eventcontractor->contractor->email}} </div>
                                            <div>{{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}} </div>
                    
                                            <hr>
                                    @endforeach
                                <x-modals.add-pilot-modal :eventid='$event->id' />
                                <x-modals.edit-contractor-modal />
                                                                
                                <form action="/events/{{ $event->id}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                <div class="card-text">
                                    @isset($event->eventPilot)
                                    <div>{!! $event->eventPilot !!}</div>
                                    <hr>
                                    @endisset
                                    <label for="eventNote">Informacje dla pilota</label>
                                    <textarea id="editEventNote" name="eventPilotNotes" rows="6" class="form-control summernoteeditor">
                                        {!! $event->eventPilotNotes !!}
                                    </textarea>
                                    <div><strong>Łącznie: </strong>{{ $event->totalSum($event->id) }}</div>
                                    <div><strong>Zapłacono: </strong> {{ $event->paidSum($event->id) }}</div>
                                    <hr>

                                    <div><strong>Wydatki pilota: </strong>{{ $event->pilotSum($event->id) }}</div>

                                    <div class="form-group">
                                        <strong>Zaliczka dla pilota:</strong>
                                        {!! Form::text('eventAdvancePayment', $event->eventAdvancePayment, array('placeholder' => '0','class' => 'form-control')) !!}
                                    </div>
                                </div>                            
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Aktualizuj</button>
                            </div>
                                </form>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Transport</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                <h4>Przewoźnicy</h4>

                                <button type="button" data-toggle="modal" data-target="#addEventCarrierModal" class="btn btn-link link-secondary"><i class="bi bi-plus-square"></i></button>
                            </div>
                                @foreach($eventcontractors->where('contractortype_id', 7)->unique('contractor_id') as $eventcontractor)
                                        <div class="d-flex justify-content-between">
                                            <div class="font-weight-bold text-uppercase">
                                                <a href="/contractors/{{$eventcontractor->contractor->id}}/edit" class="text-decoration-none text-muted text-uppercase" target="blank">{{$eventcontractor->contractor->name}}</a>

                                                {{-- {{$eventcontractor->contractor->name}} --}}
                                                {{-- <button type="button" class="btn btn-link p-0 text-decoration-none text-muted text-uppercase font-weight-bold editcontractorlink" data-toggle="modal" data-target=".edit-contractor-modal" data-contractorid="{{$eventcontractor->contractor->id}}">{{$eventcontractor->contractor->name}}</button> --}}
                                            </div>                                                <div>
                                                <form method="POST" action="/eventcontractors/{{$eventcontractor->id}}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                                </form>
                                            </div>
                                        </div>
                                        <div>{{$eventcontractor->contractor->firstname}} {{$eventcontractor->contractor->surname}}</div>
                                        <div>tel.: {{$eventcontractor->contractor->phone}} </div>
                                        <div>email: {{$eventcontractor->contractor->email}} </div>
                                        <div>{{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}} </div>
                
                                        <hr>
                                @endforeach
                                <hr>
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Kierowcy</h4>
                                     
                                    <button type="button" data-toggle="modal" data-target="#addEventDriverModal" class="btn btn-link link-secondary"><i class="bi bi-plus-square"></i></button>
                                </div>
                                @isset($event->eventDriver)
                                    <div>{!! $event->eventDriver !!}</div>
                                    <hr>
                                    @endisset
                                @foreach($eventcontractors->where('contractortype_id', 6)->unique('contractor_id') as $eventcontractor)
                                            <div class="d-flex justify-content-between">
                                            <div class="font-weight-bold text-uppercase">
                                                {{-- {{$eventcontractor->contractor->name}} --}}
                                                     <a href="/contractors/{{$eventcontractor->contractor->id}}/edit" class="text-decoration-none text-muted text-uppercase" target="blank">{{$eventcontractor->contractor->name}}</a>

                                                {{-- <button type="button" class="btn btn-link p-0  text-decoration-none text-muted text-uppercase font-weight-bold editcontractorlink" data-toggle="modal" data-target=".edit-contractor-modal" data-contractorid="{{$eventcontractor->contractor->id}}">{{$eventcontractor->contractor->name}}</button> --}}
                                            </div>                                                    <div>
                                                    <form method="POST" action="/eventcontractors/{{$eventcontractor->id}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div>{{$eventcontractor->contractor->firstname}} {{$eventcontractor->contractor->surname}}</div>
                                            <div>tel.: {{$eventcontractor->contractor->phone}} </div>
                                            <div>email: {{$eventcontractor->contractor->email}} </div>
                                            <div>{{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}} </div>
                    
                                            <hr>
                                    @endforeach
                                <form action="/events/{{ $event->id}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                <div class="card-text">
                                    <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                            <span class="input-group-text"><strong>Podstawienie: </strong></span>
                                            </div>
                                            <input type="datetime-local" class="form-control" name="busBoardTime" value="{{date('Y-m-d\TH:i',  strtotime($event->busBoardTime))}}">
                                        </div>
                                        <div class="input-group mb-3">
                                            <label for="eventStartDescription">Uwagi do podstawienia: </span>
                                            <textarea class="form-control form-control-border" rows="3" cols="60" name="eventStartDescription">{{ $event->eventStartDescription }}</textarea>
                                        </div>
                                        
                
                                        <div class="input-group mb-3">
                                            <label for="eventStartDescription">Uwagi do powrotu: </span>
                                            <textarea class="form-control form-control-border" rows="3" cols="60" name="eventEndDescription">{{ $event->eventEndDescription }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Aktualizuj</button>
                                </div>
                            </form>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h4>Hotel</h4>
                                    <button type="button" data-toggle="modal" data-target="#addEventHotelModal" class="btn btn-link link-secondary"><i class="bi bi-plus-square"></i></button>
                                </div>                            
                                                       
                            </div>
                            <div class="card-body">
                                     @isset($event->hotels)
                                    @foreach($event->hotels as $hotel)
                                        <div>{!! $hotel->hotelName !!}</div>
                                        <div>{!! $hotel->hotelStreet !!}, {!! $hotel->hotelCity !!}</div>
                                        <div>{!! $hotel->hotelPhone !!}, {!! $hotel->hotelEmail !!}</div>
                                        <hr>
                                    @endforeach
                                    @endisset
                                <div class="card-text">
                                    @foreach($eventcontractors->where('contractortype_id', 1)->unique('contractor_id') as $eventcontractor)
                                    {{-- @if($eventcontractor->contractortype_id === 1) --}}
                                            <div class="d-flex justify-content-between">
                                                <div class="font-weight-bold text-uppercase">
                                                    <a href="/contractors/{{$eventcontractor->contractor->id}}/edit" class="text-decoration-none text-muted text-uppercase" target="blank">{{$eventcontractor->contractor->name}}</a>

                                                    {{-- {{$eventcontractor->contractor->name}} --}}
                                                    {{-- <button type="button" class="btn btn-link p-0 text-decoration-none text-muted text-uppercase font-weight-bold editcontractorlink" data-toggle="modal" data-target=".edit-contractor-modal" data-contractorid="{{$eventcontractor->contractor->id}}">{{$eventcontractor->contractor->name}}</button> --}}
                                                </div>                                                <div>
                                                    <form method="POST" action="/eventcontractors/{{$eventcontractor->id}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div>{{$eventcontractor->contractor->firstname}} {{$eventcontractor->contractor->surname}}</div>
                                            <div>tel.: {{$eventcontractor->contractor->phone}} </div>
                                            <div>email: {{$eventcontractor->contractor->email}} </div>
                                            <div>{{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}} </div>
                                            <div>Ustalenia: {!! $eventcontractor->desc !!}</div>
                    
                                            <hr>
                                        {{-- @endif --}}
                                    @endforeach
                                </div>
                                <form action="/events/{{ $event->id}}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                <div class="card-text">
                                    <label for="hotelInfo">Ustalenia z hotelem</label>
                                    <input name="hotelInfo" id="hotelInfo" class="summernoteeditor">{!! $event->hotelInfo !!}</textarea>
                                    
                                </div>                            
                            </div>
                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Aktualizuj</button>
                            </div>
                                </form>
                        </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4>Klient</h4>
                                <button type="button" data-toggle="modal" data-target="#addEventPurchaserModal" class="btn btn-link link-secondary"><i class="bi bi-plus-square"></i></button>
                            </div>     
                        </div>
                        <div class="card-body">
                                @foreach($eventcontractors->where('contractortype_id', '4')->unique('contractor_id') as $eventcontractor)
                                            <div class="d-flex justify-content-between">
                                                <div class="font-weight-bold text-uppercase">
                                                    <a href="/contractors/{{$eventcontractor->contractor->id}}/edit" class="text-decoration-none text-muted text-uppercase" target="blank">{{$eventcontractor->contractor->name}}</a>

                                                    {{-- {{$eventcontractor->contractor->name}} --}}
                                                    {{-- <button type="button" class="btn btn-link p-0 text-decoration-none text-muted text-uppercase font-weight-bold editcontractorlink" data-toggle="modal" data-target=".edit-contractor-modal" data-contractorid="{{$eventcontractor->contractor->id}}">{{$eventcontractor->contractor->name}}</button> --}}
                                                </div>                                                <div>
                                                    <form method="POST" action="/eventcontractors/{{$eventcontractor->id}}">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        <button type="submit" class="btn btn-link p-0 text-decoration-none text-danger deleteconfirm"><i class="bi bi-trash"></i></button>
                                                    </form>
                                                </div>
                                            </div>
                                            <div>{{$eventcontractor->contractor->firstname}} {{$eventcontractor->contractor->surname}}</div>
                                            <div>tel.: {{$eventcontractor->contractor->phone}} </div>
                                            <div>email: {{$eventcontractor->contractor->email}} </div>
                                            <div>{{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}} </div>
                                            <div>Ustalenia: {!! $eventcontractor->desc !!}</div>
                    
                                            <hr>
                                    @endforeach
                            <div class="uppercase font-weight-bold">Zamówił:</div>
                            @if($event->eventPurchaserName!=null)                      
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserName">Nazwa: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserName" value="{{$event->eventPurchaserName}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserName">Ulica: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserStreet" value="{{$event->eventPurchaserStreet}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserName">Miejscowość: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserCity" value="{{$event->eventPurchaserCity}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserName">Nip: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserNip" value="{{$event->eventPurchaserNip}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserName">Kontakt: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserContactPerson" value="{{$event->eventPurchaserContactPerson}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserName">tel.: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserTel" value="{{$event->eventPurchaserTel}}">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="eventPurchaserEmail">email: </label>
                                    <input type="text" class="form-control form-control-border" name="eventPurchaserEmail" value="{{$event->eventPurchaserEmail}}">
                                </div>
                            @elseif($event->purchaser_id !=null)
                                <div>Nazwa: 
                                    @isset($event->purchaser->name)
                                    <span class="text-uppercase font-weight-bold">{{ $event->purchaser->name }}</span>
                                    @endisset
                                </div>
                                <div>Imię i nazwisko: 
                                    @isset($event->purchaser->name)
                                    <span class="text-uppercase font-weight-bold">{{ $event->purchaser->firstname }} {{ $event->purchaser->surname }}</span>
                                    @endisset
                                </div>
                                <div>Adres: 
                                    @isset($event->purchaser->name)
                                    <span class="">{{ $event->purchaser->street }}, {{ $event->purchaser->city }}</span>
                                    @endisset
                                </div>
                                <div>Tel.: 
                                    @isset($event->purchaser->phone)
                                    <span class="">{{ $event->purchaser->phone }}</span>
                                    @endisset
                                </div>
                                <div>email: 
                                    @isset($event->purchaser->email)
                                    <span class="">{{ $event->purchaser->email }}</span>
                                    @endisset
                                </div>
                                <div>www: 
                                    @isset($event->purchaser->email)
                                    <span class="">{{ $event->purchaser->www }}</span>
                                    @endisset
                                </div>
                            @else
                                @foreach($eventcontractors as $eventcontractor)
                                    @if($eventcontractor->contractortype_id === 4)

                                            <div>Nazwa: <span class="text-uppercase font-weight-bold">{{$eventcontractor->contractor->name}}</span></div>
                                            <div>Kontakt: <span class="text-uppercase font-weight-bold">{{$eventcontractor->contractor->firstname}} {{$eventcontractor->contractor->surname}}</span></div>
                                            <div>tel.: {{$eventcontractor->contractor->phone}} </div>
                                            <div>email: {{$eventcontractor->contractor->email}} </div>
                                            <div>adres: {{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}}</div>    
                                            <div>{{$eventcontractor->contractor->street}}, {{$eventcontractor->contractor->city}} </div>
                                    @endif
                                @endforeach
                            @endif
                        </div>                            
                        <div class="card-footer">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<script>

        
</script>




