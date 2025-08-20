<div id="eventSearchForm">
    <form action="#" method="POST">
        @csrf
        <div class="row justify-content-between mb-3">
            <div class="col">
                <label for="eventStartDateTime" class="awesome">Od</label>
                <input type="datetime-local" id="listEventStart" name="eventSearchDateTime" class="form-control">
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Do</label>
                <input type="datetime-local" id="listEventEnd" name="eventName" class="form-control">
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Nazwa</label>
                <input type="text" id="listEventName" name="eventName" class="form-control">
            </div>
            <div class="col">
                <label for="eventOfficeId" class="awesome">Kod imprezy </label>
                <input type="text" id="listEventOfficeId" name="eventOfficeId" class="form-control">
            </div>
            <div class="col">
                <label for="eventContractor" class="awesome">Kontrahent </label>
                <input type="text" id="listEventContractor" name="contractor" class="form-control">
            </div>

            <div class="col">
            <label for="listEventStatus">Status: </label>
                <select class="custom-select form-control form-control-border" id="listEventStatus">
                    <option value="">---</option>
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
        </div>
        <div class="row justify-content-between">
            <div class="col">
                <label for="eventName" class="awesome">Nazwa </label>
                <a href="#" id="nameAsc"><i class="bi bi-chevron-up"></i></a>
                <a href="#" id="nameDesc"><i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Wyjazd </label>
                <a href="#" id="startAsc"><i class="bi bi-chevron-up"></i></a>
                <a href="#" id="startDesc"><i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Ilość dni </label>
                <a href="#" id="durAsc"><i class="bi bi-chevron-up"></i></a>
                <a href="#" id="durDesc"><i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Utworzono </label>
                <a href="#" id="orderCreateAsc"><i class="bi bi-chevron-up"></i></a>
                <a href="#" id="orderCreateDesc"><i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Status </label>
                <a href="#" id="statusAsc"><i class="bi bi-chevron-up"></i></a>
                <a href="#" id="statusDesc"><i class="bi bi-chevron-down"></i></a>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Zmiany statusu</label>
                <a href="#" id="statusChangeAsc"><i class="bi bi-chevron-up"></i></a>
                <a href="#" id="statusChangeDesc"><i class="bi bi-chevron-down"></i></a>
            </div>

            
        </div>
        {{-- <button type="submit" class="btn btn-primary">
            wyślij
        </button> --}}
    </form>
</div>