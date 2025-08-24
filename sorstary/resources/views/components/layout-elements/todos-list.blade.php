

<div class="container">
    <div class="row justify-content-between">
        <div class="col">
            <h1 class="m-0">Zadania</h1>
        </div>
        <div class="col text-right">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventElementModal"><i class="bi bi-plus"></i>Nowy punkt programu</button>
        </div>
    </div>
</div>

<div class="invoice p-3 mb-3">
    <div class="row justify-content-between">
        <div class="container">
            <div class="row justify-content-between mb-3">
                <div class="col">
                    <h4 class="m-0">Wydatki</h4>
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventPaymentModal"><i class="bi bi-plus"></i> nowy wydatek</button>

                </div>
            </div>
        </div>


    @foreach($todos as $todo)
        <x-layout-elements.todos-list-row :todo='$todo' />
    @endforeach
</div>
        </div>
</div>
