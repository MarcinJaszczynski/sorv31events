@php
    $types=\App\Models\ContractorType::get();
@endphp

<div id="contractorSearchForm">
    <form action="#" method="POST">
        @csrf
        <div class="row justify-content-between mb-3">

            <div class="col">
                <label for="name" class="awesome">nazwa</label>
                <input type="text" id="listName" name="name" class="form-control">
            </div>
            <div class="col">
                <label for="firstname" class="awesome">imię</label>
                <input type="text" id="listFirstname" name="firstname" class="form-control">
            </div>
            <div class="col">
                <label for="surname" class="awesome">nazwisko</label>
                <input type="text" id="listSurname" name="surname" class="form-control">
            </div>
            <div class="col">
                <label for="street" class="awesome">ulica</label>
                <input type="text" id="listStreet" name="street" class="form-control">
            </div>
            <div class="col">
                <label for="city" class="awesome">miejscowość</label>
                <input type="text" id="listCity" name="city" class="form-control">
            </div>
            <div class="col">
                <label for="phone" class="awesome">telefon</label>
                <input type="text" id="listPhone" name="phone" class="form-control">
            </div>
            <div class="col">
                <label for="email" class="awesome">email</label>
                <input type="text" id="listEmail" name="email" class="form-control">
            </div>
            <div class="col">
                <label for="type" class="awesome">rodzaj</label>
                <select id="listType" name="type" class="form-control">
                    <option value="">---</option>
                    @foreach($types as $type)
                    <option value="{{$type->id}}">{{$type->name}}</option>
                    @endforeach
                </select>

            </div>


        </div>        
    </form>
</div>