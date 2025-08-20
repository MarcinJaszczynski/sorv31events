@extends('layouts.app')
@section('content')

@php
$executors=\App\Models\User::get();
$eventElements = \App\Models\EventElement::orderBy('eventElementStart', 'asc')->where('eventIdinEventElements', $event->id)->get();
$todos = \App\Models\Todo::orderBy('created_at', 'desc')->where('event_id', $event->id)->get();
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
<x-modals.edit-event-element-modal />
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
        <div class="col-sm-12">
            <h1>Edycja imprezy</h1>
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
                    1
                        <x-layout-elements.event-basic-data :event='$event' />
                </div>
                <div class="tab-pane fade" id="eventelement" role="tabpanel" aria-labelledby="eventelement-tab">
                    2
                    <x-layout-elements.event-elements-list :currencies='$currencies' :event='$event' :eventElements='$eventElements' :eventContractors='$eventContractors'  :payments='$payments' />
                </div>
                <div class="tab-pane fade" id="task" role="tabpanel" aria-labelledby="task-tab">
                    3             
                        <x-layout-elements.todo-collapse-list :myTodos='$myTodos' :pendingTodos='$pendingTodos' :finishedTodos='$finishedTodos' :myOrders='$myOrders' :pendingOrders='$pendingOrders' :finishedOrders='$finishedOrders' :newAllTodos='$newAllTodos' :pendingAllTodos='$pendingAllTodos' :finishedAllTodos='$finishedAllTodos'  />
                </div>
                <div class="tab-pane fade" id="payments" role="tabpanel" aria-labelledby="payments-tab">    
                                             
                        <x-layout-elements.event-payments :payments='$payments' :event='$event' :currencies='$currencies' :contractorstypes='$contractorstypes' :paymenttypes='$paymenttypes' />
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

eventElementContractorAdd();
eventElementPaymentAdd();
// contractorEdit();


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

eventElementEdit()
function eventElementEdit() {
    let eventEditList = document.querySelectorAll('.eventeditlink');
    for (let i = 0; i < eventEditList.length; i++) {

        let eventElement = eventEditList[i].querySelector('a');
        eventElement.addEventListener('click', function () {
            getElement(eventElement.getAttribute('data-element-id'))

        })
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