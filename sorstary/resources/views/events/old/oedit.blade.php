@extends('layouts.app')
@section('content')

@php
$executors=\App\Models\User::get();
$eventElements = \App\Models\EventElement::orderBy('eventElementStart', 'desc')->where('eventIdinEventElements', $event->id)->get();
$todos = \App\Models\Todo::orderBy('last_update','desc')->where('event_id', $event->id)->get();
$todoStatuses = \App\Models\TodoStatus::get();
$eventContractors = \App\Models\EventContractor::where('event_id', $event->id)->get();

$myTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('executor_id', Auth::user()->id)->where('status_id', '1')->get();
$pendingTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('executor_id', Auth::user()->id)->where('status_id', '4')->get();
$finishedTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('executor_id', Auth::user()->id)->where('status_id', '2')->get();
$myOrders = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('principal_id', Auth::user()->id)->where('status_id', '1')->get();
$pendingOrders = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('principal_id', Auth::user()->id)->where('status_id', '4')->get();
$finishedOrders = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('principal_id', Auth::user()->id)->where('status_id', '2')->get();
$newAllTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('principal_id', '!=',Auth::user()->id)->where('executor_id', '!=',Auth::user()->id)->where('status_id', '1')->get();
$pendingAllTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('principal_id', '!=',Auth::user()->id)->where('executor_id', '!=',Auth::user()->id)->where('status_id', '4')->get();
$finishedAllTodos = \App\Models\Todo::orderBy('last_update', 'desc')->where('event_id', $event->id)->where('principal_id', '!=',Auth::user()->id)->where('executor_id', '!=',Auth::user()->id)->where('status_id', '2')->get();

$payments = \App\Models\EventPayment::where('event_id', $event->id)->get();
$currencies=\App\Models\Currency::get();
$contractorstypes=\App\Models\ContractorType::get();
$paymenttypes=\App\Models\PaymentType::get();
@endphp


<x-modals.create-todo-modal :event='$event' />

{{--}}
<x-modals.create-contract :event="$event"/>--}}
<x-modals.create-event-element :event='$event'/>
<x-modals.edit-event-element-modal :event='$event' />
<x-modals.edit-contract-modal :event='$event' />
<x-modals.add-event-purchaser-modal :eventid='$event->id' />

{{-- <x-modals.create-pilot-modal /> --}}

{{-- <x-modals.create-event-hotel :event="$event"/> --}}
{{-- <x-modals.edit-event-hotel :event="$event"/> --}}
{{-- End Modals --}} 

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
        @endif
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-sm-4">
            <h1>Edycja imprezy</h1>
        </div>
        <div class="col-sm-8">
            <div class="row ">
                <div class="col d-flex justify-content-end align-items-center">
                <div class="mx-3">
                    ODPRAWY: 
                </div>
                <div>
                    <form method="GET" target=”_blank” action="{{url('reports/pilotpdf')}}" accept-charset="UTF-8">
                        <input type="hidden" name="eventId" value="{{$event->id}}">
                        <button type="submit" class="btn btn-outline-success "><i class="bi bi-filetype-pdf"></i><i class="bi bi-person-lines-fill"></i> pilot
                        </button>
                    </form> 
                </div>
                <div>
                    <form method="GET" target=”_blank” action="{{url('reports/hotelpdf')}}" accept-charset="UTF-8">
                        <input type="hidden" name="eventId" value="{{$event->id}}">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i class="bi bi-house-door"></i> hotel
                        </button>
                    </form>
                </div>
                <div>
                    <form method="GET" target=”_blank” action="{{url('reports/driverPdf')}}" accept-charset="UTF-8">
                        <input type="hidden" name="eventId" value="{{$event->id}}">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i class="bi bi-globe"></i> kierowca
                        </button>
                    </form> 
                </div>
                <div>
                    <form method="GET" target=”_blank” action="{{url('/reports/briefcasePdf')}}" accept-charset="UTF-8">
                        <input type="hidden" name="eventId" value="{{$event->id}}">
                        <button type="submit" class="btn btn-outline-success"><i class="bi bi-filetype-pdf"></i><i class="bi bi-briefcase"></i> teczka imprezy
                        </button>
                    </form> 
                </div>
                <div class="mx-3">
                    UMOWA: 
                </div>
                <div>
                    <button type="button" id="contractButton" class="btn btn-outline-success" data-toggle="modal" data-target="#contractModal">umowa</button>

                    {{-- <button type="submit" id="contractButton" class="btn btn-outline-success"><i class="bi bi-briefcase"></i> umowa
                    </button> --}}
                </div>
                </div>
            </div>
            
        </div>








        

            

        <div class="clearfix"></div>
        <div class="col-12">
            <ul class="nav nav-tabs" id="eventEdit" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="basic-tab" data-bs-toggle="tab" data-bs-target="#basic" type="button" role="tab" aria-controls="basicedit" aria-selected="true">Dane podstawowe</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="eventelement-tab" data-bs-toggle="tab" data-bs-target="#eventelement" type="button" role="tab" aria-controls="eventelement" aria-selected="false">Program</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="task-tab" data-bs-toggle="tab" data-bs-target="#task" type="button" role="tab" aria-controls="contact" aria-selected="false">Zadania</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="payments-tab" data-bs-toggle="tab" data-bs-target="#payments" type="button" role="tab" aria-controls="payments" aria-selected="false">Wydatki</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="documents-tab" data-bs-toggle="tab" data-bs-target="#documents" type="button" role="tab" aria-controls="documents" aria-selected="false">Dokumenty</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="basic" role="tabpanel" aria-labelledby="basic-tab">
                    
                        <x-layout-elements.event-basic-data :event='$event' />
                </div>
                <div class="tab-pane fade" id="eventelement" role="tabpanel" aria-labelledby="eventelement-tab">
                    
                    <x-layout-elements.event-elements-list :currencies='$currencies' :event='$event' :eventElements='$eventElements' :eventContractors='$eventContractors'  :payments='$payments' />
                </div>
                <div class="tab-pane fade" id="task" role="tabpanel" aria-labelledby="task-tab">
                                 
                        <x-layout-elements.todo-collapse-list :myTodos='$myTodos' :pendingTodos='$pendingTodos' :finishedTodos='$finishedTodos' :myOrders='$myOrders' :pendingOrders='$pendingOrders' :finishedOrders='$finishedOrders' :newAllTodos='$newAllTodos' :pendingAllTodos='$pendingAllTodos' :finishedAllTodos='$finishedAllTodos'  />
                </div>
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">    
                                             
                        <x-layout-elements.event-payments :payments='$payments' :event='$event' :currencies='$currencies' :contractorstypes='$contractorstypes' :paymenttypes='$paymenttypes' />
                </div>
                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                                 
                        <x-layout-elements.event-documents-list :event='$event' />
                </div>
                <div class="tab-pane fade" id="documents" role="tabpanel" aria-labelledby="documents-tab">
                                 
                        <x-layout-elements.event-documents-list :event='$event' />
                </div>
            </div>
<div class="clearfix"></div>

</div>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            
        </div>
        <div class="col-md-4">

<div class="card-footer clearfix">
{{-- <button type="button" class="btn btn-primary " data-toggle="modal" data-target="#todoCreateModal"> Dodaj zadanie</button> --}}
</div>
</div>
        </div>
    </div>
</div>



@endsection

@section('scripts')

<script>




// $('#addEventDriverModal').on('keyup', function () {
//     contractorsearch('driversearch');
// });


$('#purchasersearch').on('keyup', function () {
    contractorsearch('purchasersearch');
});

$('#carriersearch').on('keyup', function () {
    contractorsearch('carriersearch');
});

$('#pilotsearch').on('keyup', function () {
    contractorsearch('pilotsearch');
});

$('#driversearch').on('keyup', function () {
    contractorsearch('driversearch');
});

$('#hotelsearch').on('keyup', function () {
    contractorsearch('hotelsearch');
});

$('#elementcontractorsearch').on('keyup', function () {
    elementcontractorsearch('elementcontractorsearch');    
});

$('.deleteconfirm').click(function () {
    return confirm("Czy na pewno chcesz usunąć element?");
});

function start(){

eventElementContractorAdd();
eventElementPaymentAdd();
// contractorEdit();
getElementId();
// element_duration();
// clearInputs();
}

start();

// function element_duration(){
//     let new_element_duration = document.querySelector('#elementduration');
//     let new_element_start = document.querySelector('#elementStart');
//     let new_element_end = document.querySelector('#elementEnd');
//     let startDate = new_element_start.value;
//     new_element_duration.addEventListener('keyup', function(){
//         changeDate(startDate, 1,12,34)        
//     })

// }

// function clearInputs(){
//     inputs = document.querySelectorAll('input');
//     for(let i=0; i<inputs.length; i++){
//         inputs[i].value = '';
//     }
// }

function changeDate(date, days, hours, minutes){
    // console.log(date);
    const startDate = new Date(date).getTime()/1000;
    // console.log(startDate);
    let newDate = startDate+days*24*60*60+hours*60*60+minutes*60;
    console.log('czas' + startDate + ' - ' + newDate)
    return
}

function disableBack() { window.history.forward(); }
setTimeout("disableBack()", 0);
window.onunload = function () { null };

function getElementId(){
    let editElementsList = document.querySelectorAll('.eventeditlink');
    let getElementButton = document.querySelector('#getElement');
    for(let i=0; i<editElementsList.length; i++){
        let element = editElementsList[i].querySelector('a');
        element.addEventListener('click', function(){
            let elementId = element.getAttribute('data-element-id'); 
            getElement(elementId);           
        })
    }
}

function getElement(id){
    let elementEditModal = document.querySelector('#editEventElementModal');
    let queryUrl = '/api/eventelements/'+id;
        $.get(queryUrl, {
             _token: $('meta[name="csrf-token"]').attr('content'),
        },
        function (data){
            console.log(data)
            let formUrl = elementEditModal.querySelector('#elementEditModal_formUrl');
            formUrl.action = '/eventelements/'+ id;
            let elementId = elementEditModal.querySelector('#editElementModal_elementId');
            elementId = data.element['id'];
            let eventId = elementEditModal.querySelector('#editElementModale_eventId');
            eventId.value = data.element['eventIdinEventElements'];
            let elementNamePlace = elementEditModal.querySelector('#editElementModale_element_name_field');
            elementNamePlace.value = data.element['element_name'];
            let elementActive = elementEditModal.querySelector('#element_active');
            console.log(data.element['active'])
            if(data.element['active']==1){
                elementActive.checked=true;
            }
            else
            {
                elementActive.checked=false;
            }
            let bookingStatus = elementEditModal.querySelector('#editElementModal_booking');
            bookingStatus.value = data.element['booking'];
            let elementStart = elementEditModal.querySelector('#editElementModale_elementStart');
            elementStart.value = data.element['eventElementStart'];

            let elementEnd = elementEditModal.querySelector('#editElementModale_elementEnd');
            elementEnd.value = data.element['eventElementEnd'];
            let pilotPrint = elementEditModal.querySelector('#editElementModale_eventElementPilotPrint');
            pilotPrint.value = data.element['eventElementPilotPrint'];
            let hotelPrint = elementEditModal.querySelector('#editElementModale_eventElementHotelPrint');
            hotelPrint.value = data.element['eventElementHotelPrint'];
            // let desc = elementEditModal.querySelector('#editElementModale_elementDescriptionField');
            $("#editElementModale_elementDescriptionField").summernote('code', data.element['eventElementDescription']);
            $("#editElementModale_eventElementNote").summernote('code', data.element['eventElementNote']);
            $("#editElementModale_eventElementReservation").summernote('code', data.element['eventElementReservation']);

            // desc.innerHTML = data.element['elementDescriptionField'];
                        
        }
    );
}


function eventElementPaymentAdd(){
    let addElementPaymentsList = document.querySelectorAll('.addelementpayment');
    let addPaymentModal = document.querySelector('#addPaymentModal');
    let elementid = document.querySelector('#payment_modal_element_id');
    for(let i=0; i<addElementPaymentsList.length; i++){
        let listElement = addElementPaymentsList[i].querySelector('a');
        listElement.addEventListener('click', function(){
            let element = listElement.getAttribute("data-element-id");
            elementid.value = element;
            let elementNameField = document.querySelector('#payment_modal_element_name');
            let elementName = listElement.getAttribute("data-element-name");

            elementNameField.value=elementName;

        })
    }
}
        
    


// // dodanie kontrahenta do elementu

// // listener




// console.log(document.querySelectorAll(".addelementcontractorlink"))
function elementcontractorsearch(searchid) {
    let element = document.querySelector("#" + searchid);
    let keyword = element.value;
    let contractortype = element.dataset.contractortype;
    let selecttypefield = element.dataset.contractortypefield;    
    if (element.dataset.contractortype === '') {

        let select = document.querySelector("#" + selecttypefield)
        contractortype = select.options[select.selectedIndex].value;
        console.log(keyword + ' - '+ contractortype);
    }

    let dataplaceval = element.dataset.dataplace;
    let resoultplace = document.querySelector("#" + dataplaceval);

    $.post('{{ route("customersearch.search") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            keyword: keyword,
            contractortype: contractortype
        },
        function (data) {
            resoultplace.innerHTML = ''
            resoultplace.appendChild(dataTable(data))
        });
}
// // koniec dodania kontrahenta do elementu

// // wyszukiwanie kontrahenta

function contractorsearch(searchid) {
    let element = document.querySelector("#" + searchid);
    let keyword = element.value;
    let contractortype = element.dataset.contractortype;
    if (element.dataset.contractortype === '') {
        let select = document.querySelector("#" + searchid)
        contractortype = select.options[select.selectedIndex].value;
    }

    let dataplaceval = element.dataset.dataplace;
    let resoultplace = document.querySelector("#" + dataplaceval);

    $.post('{{ route("customersearch.search") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            keyword: keyword,
            contractortype: contractortype
        },
        function (data) {
            resoultplace.innerHTML = ''
            resoultplace.appendChild(dataTable(data))
        });
}

function dataTable(data) {

    let tbl = document.createElement("table")
    let tblBody = document.createElement("tbody")
    // tbl.innerHTML=''
    // tblBody.innerHTML='' 

    if (data.contractors.length <= 0) {
        tblBody.innerHTML = `
                <tr>
                    <td colspan="2">Brak danych.</td>
                </tr>`;
    } else {


        data.contractors.forEach(element => {
            let newRow = tbl.insertRow()
            let radiobox = document.createElement("input")
            radiobox.type = "radio"
            radiobox.name = "contractor_id"
            radiobox.value = element.id
            let elementId = newRow.insertCell()
            elementId.appendChild(radiobox)
            // elementId.innerText = element.id
            let elementText = newRow.insertCell()
            let desc = "";
            if(element.name !=null){
                desc+=element.name + ' - ';
            }
            if(element.firstname !=null){
                desc+=element.firstname + ' ';
            }
            if(element.surname !=null){
                desc+=element.surname + ', ';
            }
            if(element.street !=null){
                desc+=element.street + ', ';
            }
            if(element.city !=null){
                desc+=element.city + ', ';
            }
            if(element.phone !=null){
                desc+='tel.: '+ element.phone + ', ';
            }
            if(element.email !=null){
                desc+='email.: '+ element.email + ', ';
            }
            if(element.www !=null){
                desc+='www.: '+ element.www + ', ';
            }
            elementText.innerText = desc;
            // let elementFirstName = newRow.insertCell()
            // elementFirstName.innerText = element.firstname + ' ' + element.surname + ' ' + element.street +' / ' + element.city

        })
    }

    console.log(tbl)
    return tbl
}

function eventElementContractorAdd() {
    let addElementContractorsList = document.querySelectorAll(".addElementContractorLink");
    for (let i = 0; i < addElementContractorsList.length; i++) {

        let addElementContractorLink = addElementContractorsList[i].querySelector('a');
        if(addElementContractorLink!=null){
        addElementContractorLink.addEventListener('click', function () {
            let elementId = document.querySelector('#event_element_id');
            elementId.value = addElementContractorLink.getAttribute('data-elementid');
        })
    }
    }
}



addAdvance()

function addAdvance(){
    let addAdvanceList = document.querySelectorAll('.add-advance-link');
    for(let i = 0; i<addAdvanceList.length; i++){
        let addAdvanceLink = addAdvanceList[i].querySelector('a');
        if(addAdvanceLink != null){
            addAdvanceLink.addEventListener('click', function(){
                let paymentId = document.querySelector('#addAdvancePId');
                paymentId.value = (addAdvanceLink.getAttribute('data-payment-id'));
                console.log(paymentId);
                console.log(addAdvanceLink.getAttribute('data-payment-id'));
            })
        }
    }
}

</script>
@endsection