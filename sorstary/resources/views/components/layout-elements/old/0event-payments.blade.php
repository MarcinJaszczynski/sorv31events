{{-- Start Modals --}}
<x-modals.add-event-payment-modal :event='$event' :currencies='$currencies'  />
<x-modals.add-payment-contractor-modal :contractorstypes='$contractorstypes' />
<x-modals.edit-event-payment-modal :event='$event' :currencies='$currencies' />
<x-modals.add-advance-modal :currencies='$currencies' :paymenttypes='$paymenttypes' />

{{-- End Modals --}}

@php
$plannedOffice = $event->plannedTotalSum($event->id) - $event->plannedPilotSum($event->id);
$office = $event->totalSum($event->id) - $event->pilotSum($event->id);                            
@endphp

<div class="invoice p-3 mb-3">
    <div class="row justify-content-between">
        <div class="container">
            <div class="row justify-content-between mb-3">
                <div class="col">
                    <h4 class="m-0">Wydatki</h4>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventPaymentModal"><i class="bi bi-plus"></i> dodaj wydatek</button>

                </div>
            </div>
        </div>
    <table class="table table-striped table-hover table-bordered" width="100%">
                <thead>
                    <th scope="col" class="align-top">
                        <div>Data</div>
                        <div>Faktura</div>
                    </th>
                    <th class="align-top">
                        <div>Wydatek/</div>
                        <div>Opis</div>
                    </th>
                    <th scope="col" class="align-top">Kontrahent</th>
                    <th>
                        <div>Płatnik/</div>
                        <div>Status</div>
                    </th>
                    <th scope="col" class="align-top">Zaliczka</th>

                    <th scope="col" class="align-top">
                        <div>Wydatki</div>
                        <div>planowane</div>
                    </th>
                    <th class="align-top">
                        <div>Wydatki</div>
                        <div>rzeczywiste</div>
                    </th>

                </thead>

                    @foreach($payments as $payment)
                    <x-layout-elements.event-payment-row :payment='$payment' :currencies='$currencies' />
                    @endforeach
    </table>
    
            <section>

                <div class="row">
                    <div class="col"><h4>Podsumowanie wydatków:</h4></div>
                </div>

                <table class="table table-sm" width="100%">
                    <tr class="table-active p-3">
                        <th>
                    </th>
                    <th class="p-3">Planowane</th>
                    <th class="p-3">Rzeczywiste</th></tr>
                    <tr>
                    <th class="table-active p-3">Pilot</th>
                        <td class="p-3">
                            {!! $event->plannedPilotSum($event->id) !!} PLN (Zaliczka: {!! $event->eventAdvancePayment !!} PLN)
                        </td>
                        <td class="p-3"> {!! $event->pilotSum($event->id) !!} PLN</td>
                    </tr>
                    <tr>
                        <th class="table-active p-3">Biuro:</th>
                        <td class="p-3">
                            {!! $plannedOffice !!} PLN
                        </td>
                        <td class="p-3">{!! $office !!} PLN</td>
                    </tr>                        
                    <tr class="table-active">
                        <th class="p-3">Suma:</th>
                        <th class="p-3">{!! $event->plannedTotalSum($event->id) !!} PLN</th>
                        <th class="p-3">{!! $event->totalSum($event->id) !!} PLN</th>
                    </tr>                        
                </table>
                                
            </section>
</div>
</div>

<script>

    function addAdvanceEventListener(){
        let addAdvanceLinksList = document.querySelectorAll('.add-advance-link');
        let addAdvancePayment=document.querySelector("#addAdvancePaymentId")
        for(let i=0; i<addAdvanceLinksList.length; i++){
            addAdvanceLinksList[i].addEventListener('click', function(){
                addAdvancePayment.value = addAdvanceLinksList[i].getAttribute('data-payment-id')
            })
        }
    }

    function getEventPayment(payment_id){
        $.post('{{ route("getpayment") }}', {
        _token: $('meta[name="csrf-token"]').attr('content'),
        id: payment_id,        
    },
    function (data) {
        let name = document.querySelector("#eventPaymentEditName");
        name.value = data.payment.paymentName;
        $('#eventPaymentEditDesc').summernote(
        'code', data.payment.paymentDescription);
        let paymentId = document.querySelector('#eventPaymentEditPaymentId');
        paymentId.value = data.payment.id; 
        let payer = document.querySelector('#eventPaymentEditPayer');
        payer.value = data.payment.payer;
        let status = document.querySelector('#eventPaymentEditStatus');
        status.value = data.payment.paymentStatus;    
        let invoice = document.querySelector('#eventPaymentEditInvoice');
        invoice.value = data.payment.invoice;
        let paymentDate = document.querySelector('#eventPaymentEditPaymentDate');
        paymentDate.value = data.payment.paymentDate;
        let plannedPrice = document.querySelector('#eventPaymentEditPlannedPrice');
        plannedPrice.value = data.payment.plannedPrice;
        let plannedQty = document.querySelector('#eventPaymentEditPlannedQty');
        plannedQty.value = data.payment.plannedQty;
        let plannedCurrencyId = document.querySelector('#eventPaymentEditPlanned_currency_id');
        plannedCurrencyId.value = data.payment.planned_currency_id;
        let price = document.querySelector('#eventPaymentEditPrice');
        price.value = data.payment.price;
        let qty = document.querySelector('#eventPaymentEditQty');
        qty.value = data.payment.qty;
        let currency_id = document.querySelector('#eventPaymentEditCurrency_id');
        currency_id.value = data.payment.currency_id;
    });

    }

    function addPaymentEditEventListener(){
        let paymentEditLinksList = document.querySelectorAll(".paymenteditlink");
        for(let i=0; i<paymentEditLinksList.length; i++){
            paymentEditLinksList[i].addEventListener('click', function(){
                let payment_id = paymentEditLinksList[i].getAttribute('data-payment-id');
                edit_payment_modal_update(payment_id);
            })
        }
        
    }

    function edit_payment_modal_update(payment_id){
        let event_payment = getEventPayment(payment_id);
        console.log(event_payment)

    }

    function update_modal_payment_id(){
        let links_list = document.querySelectorAll('.add-payment-contractor-link');
        let form_payment_id = document.querySelector("#addContractorPaymentPaymentId");
        for(let i=0; i<links_list.length; i++){
            links_list[i].addEventListener('click', function (){
                let payment_id = links_list[i].getAttribute('data-payment-id');
                form_payment_id.value = payment_id;
            })
        }
    }

    function search_contractor(elementId){

        // Wyszukiwanie kontrahenta do elementu
        // elementId - selector id pola wyszukiwania
        // data-contractortype - selector pola wyboru typu kontrachenta
        // data-dataplace - selector pola w którym ma być umieszczony wynik wyszukiwania
        // WZÓR 
        // <select name=" " id="selecttype"><option>...</option></select>
        // <input type="text" data-contractortype="selecttype" data-dataplace="searchresultplace">

        let element = document.querySelector("#" + elementId);
        let keyword = element.value;

        let typeelement = element.getAttribute('data-contractortype');
        let type = document.querySelector("#"+typeelement);
        let contractortype = type.value;

        let dataplaceval = element.getAttribute('data-dataplace');
        let resoultplace = document.querySelector("#" + dataplaceval);

        console.log('keyword: '+ keyword + ' contractortype: ' + contractortype)

        $.post('{{ route("customersearch.search") }}', {
                _token: $('meta[name="csrf-token"]').attr('content'),
                keyword: keyword,
                contractortype: contractortype
            },
            function (data) {
                resoultplace.innerHTML = ''
                resoultplace.appendChild(contractorSearchResoultTable(data))
            });
    }

    function contractorSearchResoultTable(data){
    let tbl = document.createElement("table")
    let tblBody = document.createElement("tbody")
 

    if (data.contractors.length <= 0) {
        tblBody.innerHTML = `
                <tr>
                    <td colspan="3">Brak danych.</td>
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
            let elementName = newRow.insertCell()
            elementName.innerText = element.name
            let elementFirstName = newRow.insertCell()
            elementFirstName.innerText = element.firstname
        })
    }
    console.log(tbl)
    return tbl

    }

    function add_payment_contractor_search_listener(){
        let searchfield = document.querySelector("#payment_contractor_search");
        searchfield.addEventListener('keyup', function(){
            search_contractor("payment_contractor_search");
        })
    }

    function payment_sum_display(totalId){
        let element = document.querySelector("#"+totalId);
        let price = document.querySelector("#"+element.getAttribute('data-price')).value;
        let qty = document.querySelector("#"+element.getAttribute('data-qty')).value;
        let currency = document.querySelector("#"+element.getAttribute('data-currency_id'));        
        element.innerText = (price * qty);
    }

    function payment_display_change(){
        let inputs_list = document.querySelectorAll(".totalinput");
        for(let i=0; i<inputs_list.length; i++){
            inputs_list[i].addEventListener('keyup', function (){
                payment_sum_display("planned_total");
                payment_sum_display("total"); 
            })
        }
    }

    function init_payment(){
        payment_sum_display("planned_total"); 
        payment_sum_display("eventPaymentEditPlanned_total"); //TODO - nie działa
        payment_sum_display("total");
        payment_sum_display("eventPaymentEditTotal"); //TODO - nie działa
        payment_display_change();
        add_payment_contractor_search_listener();
        update_modal_payment_id();
        addPaymentEditEventListener();
        addAdvanceEventListener();
    }

    init_payment()

    </script>

