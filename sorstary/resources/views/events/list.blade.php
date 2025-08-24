@extends('layouts.app')
@section('content')

@php
@endphp
{{-- TODO - zrobić podświetlanie wysłanych ofert po 7 dniach --}}
<x-modals.event-info-modal />
<div class="container">
    <div class="justify-content-center">
        {{-- @if (\Session::has('success'))
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @else
            <div class="alert alert-success">
                <p>{{ \Session::get('success') }}</p>
            </div>
        @endif --}}
        <div class="card">
            <div class="card-header">
                <h4>Wyszukiwarka imprez</h4> 
            </div>
            <div class="card-body">
                <x-layout-elements.event-search-form />
                {{-- {!! $data->appends(\Request::except('page'))->render() !!} --}}
            </div>
            <div class="container" id="eventsResoultsField">
               
            </div>
        </div>
        
    </div>
</div>

<script>
    searchEvents('eventSearchForm')

    
    function searchEvents(searchFormId){

        let searchId = "#"+searchFormId
        let searchForm = document.querySelector(searchId)        
        let nameSearchInput = searchForm.querySelector('#listEventName')
        let eventStart = document.querySelector('#listEventStart')
        let eventEnd = document.querySelector('#listEventEnd')
        let eventStatus = document.querySelector('#listEventStatus')
        let officeId = document.querySelector('#listEventOfficeId')
        let eventContractor = document.querySelector('#listEventContractor')
        let nameAsc = document.querySelector('#nameAsc')
        let nameDesc = document.querySelector('#nameDesc')
        let startAsc = document.querySelector('#startAsc')
        let startDesc = document.querySelector('#startDesc')
        let durAsc = document.querySelector('#durAsc')
        let durDesc = document.querySelector('#durDesc')
        let orderCreateAsc = document.querySelector('#orderCreateAsc')
        let orderCreateDesc = document.querySelector('#orderCreateDesc')
        let statusAsc = document.querySelector('#statusAsc')
        let statusDesc = document.querySelector('#statusDesc')
        let statusChangeAsc = document.querySelector('#statusChangeAsc')
        let statusChangeDesc = document.querySelector('#statusChangeDesc')
        


        nameSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        eventStart.addEventListener('input', function(){
            liveEventSearch()
        })
        eventEnd.addEventListener('input', function(){
            liveEventSearch()
        })
        officeId.addEventListener('keyup', function(){
            liveEventSearch()
        })
        eventStatus.addEventListener('change', function(){
            liveEventSearch()
        })
        eventContractor.addEventListener('change', function(){
            liveEventSearch()
        })
        nameAsc.addEventListener('click', function(){
            liveEventSearch('nameAsc')
        })
        nameDesc.addEventListener('click', function(){
            liveEventSearch('nameDesc')
        })
        startAsc.addEventListener('click', function(){
            liveEventSearch('startAsc')
        })
        startDesc.addEventListener('click', function(){
            liveEventSearch('startDesc')
        })
        durAsc.addEventListener('click', function(){
            liveEventSearch('durAsc')
        })
        durDesc.addEventListener('click', function(){
            liveEventSearch('durDesc')
        })
        orderCreateAsc.addEventListener('click', function(){
            liveEventSearch('createAsc')
        })
        orderCreateDesc.addEventListener('click', function(){
            liveEventSearch('createDesc')
        })
        statusAsc.addEventListener('click', function(){
            liveEventSearch('statusAsc')
        })
        statusDesc.addEventListener('click', function(){
            liveEventSearch('statusDesc')
        })
        statusChangeAsc.addEventListener('click', function(){
            liveEventSearch('statusChangeAsc')
        })
        statusChangeDesc.addEventListener('click', function(){
            liveEventSearch('statusChangeDesc')
        })

    }

    

    function liveEventSearch(order=''){
        let searchResoutsField = document.getElementById('eventsResoultsField')
        $.post('{{ route("livesearch.event") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            eventName: document.querySelector('#listEventName').value,
            start: document.querySelector('#listEventStart').value,
            end: document.querySelector('#listEventEnd').value,
            status: document.querySelector('#listEventStatus').value,
            eventOfficeId: document.querySelector('#listEventOfficeId').value,
            contractor: document.querySelector('#listEventContractor').value,
            order: order
            },
            function (data){
                searchResoutsField.innerHTML ='';
                searchResoutsField.appendChild(eventsTable(data))
        });      
    }

    function eventsTable(data){
        // console.log(data.events);
        let tbl = document.createElement("table");
        tbl.classList.add('table', 'table-stripped')
        let tblBody = document.createElement('tbody')
        

        if (data.events.length<=0){
            tblBody.innerHTML = `
            <tr>
                <td>Brak danych</td>
            </tr>`;            
        }
        else {
                let headerRow = tbl.insertRow();
                let nameCell = headerRow.insertCell();
                nameCell.innerText='Impreza';
                let startCell = headerRow.insertCell();
                startCell.innerText='Termin';
                let contractorsCell = headerRow.insertCell();
                contractorsCell.innerText='Kontrahenci';
                let statusCell = headerRow.insertCell();
                statusCell.innerText='Status';

            

            data.events.forEach(event=>{


                let urlStr ='/events/'+event.id+'/edit'
                let eventNameStr = event.eventName
                let eventName = eventNameStr.link(urlStr)
                let newRow = tbl.insertRow();
                let eventNameCell = newRow.insertCell();

                let purchaserStr = contractorsData(event, 4);
                let pilotStr = contractorsData(event, 5);
                let transportStr = contractorsData(event, 7);
                let driverStr =contractorsData(event,6);
                let hotelStr = contractorsData(event, 1);
                let lastChange = ''    
                if(event.statusChangeDatetime != null){
                lastChange = event.statusChangeDatetime.split('T')
                }

                
                 
                // let eventDataStr = event.eventName + '\n' + 'osób: ' + event.eventTotalQty
                let eventDataStr = eventName + '<br>' + 'osób: ' + event.eventTotalQty + '<br>' + event.eventOfficeId
                eventNameCell.innerHTML = eventName + ' (osób: ' + event.eventTotalQty +'), dni:' + event.duration+ '<br>' + '(' +  event.eventOfficeId +')' +'<br>' + purchaserStr;
                let eventStartCell = newRow.insertCell();
                eventStartCell.innerText = 'Start: ' + event.eventStartDateTime + '\n' + 'Koniec: ' + event.eventEndDateTime ;
                let eventContractorCell = newRow.insertCell();
                eventContractorCell.innerHTML = '<div><span class="font-weight-bold">T:</span>' + transportStr + '</div><div><span class="font-weight-bold">K:</span> ' +  driverStr + '</div><div><span class="font-weight-bold">P:</span> ' +  pilotStr + '</div><div><span class="font-weight-bold">H: </span>' +  hotelStr;                
                let eventStatusCell = newRow.insertCell();
                eventStatusCell.innerHTML = event.eventStatus + '<br /> od:' + event.statusChangeDatetime;
                          


            })
            
        }
        // console.log(tbl)
        return tbl;
    }

    function contractorsData(event, id){
        this.event = event
        let contractorsStr = ''
        let purchaserName = '';



        event.eventcontractors.forEach(contractor=>{
            // let contrArray = contractor.map({id}=>id);
            // console.log(contrArray)
            // console.log(contractor)
                    if(contractor.pivot.contractortype_id === id){

                        let name = contractor.name;
                        if(name === null){
                            name = ''
                        }
                        let firstname = contractor.firstname;
                        if(firstname === null){
                            firstname = ''
                        }
                        let surname = contractor.surname;
                        if(surname === null){
                            surname = ''
                        }
                        let city = contractor.city;
                        if(city === null){
                            city = ''
                        }
                        let street = contractor.street;
                        if(street === null){
                            street = ''
                        } 
                        let phone = contractor.phone;
                        if(phone === null){
                            phone = ''
                        } 
                        let email = contractor.email;
                        if(email === null){
                            email = ''
                        } 
                        if (id===4){
                            purchaserName = contractor.firstname + ' ' + contractor.surname;
                        }                        
                        contractorsStr = contractorsStr + '<span class="font-weight-bold text-muted"> ' + name + ', <br>' + purchaserName + '</span>' 
                                 
                    }
                })

                // console.log(contractorsStr);

                
                return contractorsStr;
    }
    
 
</script>
@endsection