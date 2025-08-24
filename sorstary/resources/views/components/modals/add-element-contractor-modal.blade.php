@php

$contractorTypes =  \App\Models\ContractorType::get();

@endphp


<div class="modal fade" id="addElementContractorModal"  role="dialog" aria-labelledby="addElementContractorModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">        
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj kontahenta</h4>
                </div>
            </div>
            <form action="/createElementContractor" method="POST">
            @csrf 
            <input type="hidden" class="form-control" name="event_id" value="{{$event->id}}">
            <input type="hidden" class="form-control" id="event_element_id" name="eventelement_id" value="">
                    
            <div class="modal-body">
                <div class="modal-text">
                    <div class="row">
                        <div class="col">
                            <h4>Impreza/PunktProgramu:  {{$event->eventName}} - <span id="elementNameHeader"></span></h4>
                        </div>
                        <hr>
                    </div>
                    <div class="row">  
                        <div class="col-md-6">
                            <label for="contractorType">Typ kontrahenta</label>
                                <select id="elementcontractortypefield" class="form-select form-control-border mb-3" name="contractortype_id">
                                    @foreach($contractorTypes as $type)
                                    <option value="{{$type->id}}">{{$type->name}}</option>
                                    @endforeach
                                </select>
                            <label for="contractor">Wyszukaj kontrahenta</label>
                            <input type="text" class="form-control"  placeholder="Wyszukaj kontrahenta" id="elementcontractorsearch" data-contractortype="" data-dataplace="elementcontractorlist" data-contractortypefield="elementcontractortypefield" class="form-control">
                            <hr>
                            <div id="elementcontractorlist"></div>
                        </div>
                        <hr>
                    </div>  
                </div>
            </div>
            <div class="modal-bottom ">
                <div class="btn-group m-3 float-end" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
        </form>
    </div>
    </div>
</div>

