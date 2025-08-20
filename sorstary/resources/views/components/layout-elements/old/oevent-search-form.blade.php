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
                <label for="eventName" class="awesome">Kontrahent </label>
                <input type="text" id="listEventContractor" name="eventName" class="form-control">
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
        {{-- <div class="row justify-content-between">
            <div class="col">
                <label for="eventName" class="awesome">Nazwa </label>
                <i class="bi bi-chevron-up"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Wyjazd </label>
                <i class="bi bi-chevron-up"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Ilość dni </label>
                <i class="bi bi-chevron-up"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Utworzono </label>
                <i class="bi bi-chevron-up"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Status </label>
                <i class="bi bi-chevron-up"></i>
                <i class="bi bi-chevron-down"></i>
            </div>
            <div class="col">
                <label for="eventName" class="awesome">Zmiany </label>
                <i class="bi bi-chevron-up"></i>
                <i class="bi bi-chevron-down"></i>
            </div>

            
        </div> --}}
        {{-- <button type="submit" class="btn btn-primary">
            wyślij
        </button> --}}
    </form>
</div>