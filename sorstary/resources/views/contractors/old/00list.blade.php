@extends('layouts.app')
@section('content')

@php
@endphp
{{-- <x-modals.event-info-modal /> --}}
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
                <h4>Wyszukiwarka kontrahentów</h4> 
            </div>
            <div class="card-body">
                <x-layout-elements.contractor-search-form />
                {{-- {!! $data->appends(\Request::except('page'))->render() !!} --}}
            </div>
            <div class="container" id="eventsResoultsField">
               
            </div>
        </div>
        
    </div>
</div>

<script>
    searchContractors('contractorSearchForm')

    function searchContractors(searchFormId){

        let searchId = "#"+searchFormId
        let searchForm = document.querySelector(searchId)        
        let nameSearchInput = searchForm.querySelector('#listName')
        let firstnameSearchInput = searchForm.querySelector('#listFirstname')
        let surnameSearchInput = searchForm.querySelector('#listSurname')
        let streetSearchInput = searchForm.querySelector('#listStreet')
        let citySearchInput = searchForm.querySelector('#listCity')
        let phoneSearchInput = searchForm.querySelector('#listPhone')
        let emailSearchInput = searchForm.querySelector('#listEmail')
        let typeInput = searchForm.querySelector('#listType')

        nameSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        firstnameSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        surnameSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        streetSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        citySearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        phoneSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        emailSearchInput.addEventListener('keyup', function(){
            liveEventSearch()
        })
        typeInput.addEventListener('change', function(){
            liveEventSearch()
        })


    }

    

    function liveEventSearch(){
        let searchResoutsField = document.getElementById('eventsResoultsField')
        $.post('{{ route("livesearch.contractors") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            name: document.querySelector('#listName').value,
            firstname: document.querySelector('#listFirstname').value,
            surname: document.querySelector('#listSurname').value,
            street: document.querySelector('#listStreet').value,
            city: document.querySelector('#listCity').value,
            phone: document.querySelector('#listPhone').value,
            email: document.querySelector('#listEmail').value,
            type: document.querySelector('#listType').value
            },
            function (data){
                searchResoutsField.innerHTML ='';
                searchResoutsField.appendChild(contractorsTable(data))
        });      
    }

    function contractorsTable(data){
        console.log(data);
        let tbl = document.createElement("table");
        tbl.classList.add('table', 'table-stripped')
        let tblBody = document.createElement('tbody')
        

        if (data.contractors.length<=0){
            tblBody.innerHTML = `
            <tr>
                <td>Brak danych</td>
            </tr>`;            
        }
        else {
                let headerRow = tbl.insertRow();
                let nameCell = headerRow.insertCell();
                nameCell.innerText='Nazwa';
                let contactCell = headerRow.insertCell();
                contactCell.innerText='Kontakt';
                let adressCell = headerRow.insertCell();
                adressCell.innerText='Adres';
                let actionCell = headerRow.insertCell();
                actionCell.innerText='Akcje';


            

            data.contractors.forEach(contractor=>{
                let editUrlStr ='/contractors/'+contractor.id+'/edit';
                let editStr = '(edytuj)';
                let showUrlStr ='/contractors/'+contractor.id;
                let showStr = '(pokaż)';
                let contractorName = contractor.name
                let contractorFirstname = contractor.firstname
                let contractorSurname = contractor.surname
                let contractorStreet = contractor.street
                let contractorCity = contractor.city
                let contractorPhone = contractor.phone
                let contractorEmail = contractor.email
                let contractorNameLink = contractorName.link(editUrlStr)
                let newRow = tbl.insertRow();
                let contractorNameCell = newRow.insertCell();
                let contractorAdressCell = newRow.insertCell();
                let contractorContactCell = newRow.insertCell();
                let contractorActionsCell = newRow.insertCell(); 
                contractorNameCell.innerHTML = contractorName + '<br>' + contractorFirstname + ' ' + contractorSurname;
                contractorAdressCell.innerHTML = contractorStreet + '<br>' + contractorCity;
                contractorContactCell.innerHTML = contractorPhone + '<br>' + contractorEmail
                contractorActionsCell.innerHTML = editStr.link(editUrlStr) +'<br>' + showStr.link(showUrlStr);
            })
            
        }
        return tbl;
    }   
    
 
</script>
@endsection