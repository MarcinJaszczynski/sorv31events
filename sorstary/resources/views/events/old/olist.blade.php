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

    // function searchEvents(searchFormId){

    //     let searchId = "#"+searchFormId
    //     let searchForm = document.querySelector(searchId)        
    //     let nameSearchInput = searchForm.querySelector('#listEventName')
    //     let eventStart = document.querySelector('#listEventStart')
    //     let eventEnd = document.querySelector('#listEventEnd')
    //     let eventStatus = document.querySelector('#listEventStatus')
    //     nameSearchInput.addEventListener('keyup', function(){
    //         liveEventSearch(nameSearchInput.value, eventStart.value, eventEnd.value, eventStatus.value)
    //     })
    //     eventStart.addEventListener('input', function(){
    //         liveEventSearch(nameSearchInput.value, eventStart.value, eventEnd.value, eventStatus.value)
    //     })
    //     eventEnd.addEventListener('input', function(){
    //         liveEventSearch(nameSearchInput.value, eventEnd.value, eventEnd.value, eventStatus.value)
    //     })
    //     eventStatus.addEventListener('change', function(){
    //         liveEventSearch(nameSearchInput.value, eventEnd.value, eventEnd.value, eventStatus.value)
    //     })

    // }

    

    // function liveEventSearch(name, eventStart, eventEnd, eventStatus){
    //     let searchResoutsField = document.getElementById('eventsResoultsField')
    //     $.post('{{ route("livesearch.event") }}', {
    //         _token: $('meta[name="csrf-token"]').attr('content'),
    //         eventName: name,
    //         start: eventStart,
    //         end: eventEnd,
    //         status: eventStatus
    //         },
    //         function (data){
    //             searchResoutsField.innerHTML ='';
    //             searchResoutsField.appendChild(eventsTable(data))
    //     });      
    // }
    function searchEvents(searchFormId){

        let searchId = "#"+searchFormId
        let searchForm = document.querySelector(searchId)        
        let nameSearchInput = searchForm.querySelector('#listEventName')
        let eventStart = document.querySelector('#listEventStart')
        let eventEnd = document.querySelector('#listEventEnd')
        let eventStatus = document.querySelector('#listEventStatus')
        nameSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        eventStart.addEventListener('input', function(){
            liveEventSearch()
        })
        eventEnd.addEventListener('input', function(){
            liveEventSearch()
        })
        eventStatus.addEventListener('change', function(){
            liveEventSearch()
        })

    }

    

    function liveEventSearch(){
        let searchResoutsField = document.getElementById('eventsResoultsField')
        $.post('{{ route("livesearch.event") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            eventName: document.querySelector('#listEventName').value,
            start: document.querySelector('#listEventStart').value,
            end: document.querySelector('#listEventEnd').value,
            status: document.querySelector('#listEventStatus').value
            },
            function (data){
                searchResoutsField.innerHTML ='';
                searchResoutsField.appendChild(eventsTable(data))
        });      
    }

    function eventsTable(data){
        // console.log(data);
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
                let driverStr =contractorsData(event, 7);
                let hotelStr = contractorsData(event, 1); 
                let lastChange = ''    
                if(event.statusChangeDatetime != null){
                lastChange = event.statusChangeDatetime.split('T')
                }

                
                 
                // let eventDataStr = event.eventName + '\n' + 'osób: ' + event.eventTotalQty
                let eventDataStr = eventName + '\n' + 'osób: ' + event.eventTotalQty
                eventNameCell.innerHTML = eventName + ' (osób: ' + event.eventTotalQty +')' + purchaserStr;
                let eventStartCell = newRow.insertCell();
                eventStartCell.innerText = 'Start: ' + event.eventStartDateTime + '\n' + 'Koniec: ' + event.eventEndDateTime ;
                let eventContractorCell = newRow.insertCell();
                eventContractorCell.innerHTML = '<div><span class="font-weight-bold">Pilot:</span>' + pilotStr + '</div><div><span class="font-weight-bold">Przewoźnik:</span> ' +  driverStr + '</div><div><span class="font-weight-bold">Hotel: </span>' +  hotelStr;                
                let eventStatusCell = newRow.insertCell();
                eventStatusCell.innerText = event.eventStatus;
                          


            })
            
        }
        // console.log(tbl)
        return tbl;
    }

    function contractorsData(event, id){
        this.event = event
        let contractorsStr = ''
        event.eventcontractors.forEach(contractor=>{
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
                        contractorsStr = contractorsStr + '<div class="font-weight-bold text-muted">' + name + '</div>' 
                        + '<div>' + firstname + ' ' + surname + '</div>'
                        + '<div>' + city + ', ' +  street + '</div>'             
                        + '<div>' + phone + '/' +  email + '</div>'             
                    }
                })

                // console.log(contractorsStr);

                
                return contractorsStr;
    }
    
 
</script>
@endsection