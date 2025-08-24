<div class="modal fade" id="addEventHotelModal" role="dialog" aria-labelledby="addEventHotelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4>Dodaj nocleg</h4>
            </div>
            {{ Form::open(array('url' => 'eventhotel/store', 'method' => 'post')) }}
            @csrf
            <div class="modal-body">

                <input type="hidden" name="event_id" value="{{ $event->id }}">


                {{-- <select name="hotel_id" class="form-select form-select">

                    @foreach($allHotels as $hotel)

                    <option value="{{ $hotel->id }}">{{ $hotel->hotelName }}, {{ $hotel->hotelStreet }} {{ $hotel->hotelCity }}, {{ $hotel->hotelRegion }}</option>
                    @endforeach
                </select> --}}


                {{ Form::label('eventHotelStartDate', 'Początek rezerwacji', array('class' => 'awesome')) }}
                {{ Form::input('dateTime-local', 'eventHotelStartDate', date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), ['class' => 'form-control', 'min' => date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime)) ]) }}

                {{ Form::label('eventHotelEndDate', 'koniec rezerwacji', array('class' => 'awesome')) }}
                {{ Form::input('dateTime-local', 'eventHotelEndDate', date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime)), ['class' => 'form-control', 'min' => date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime)) ]) }}

                {{ Form::label('eventHotelRooms', 'struktura pokojów', array('class' => 'awesome')) }}
                {!! Form::textarea('eventHotelRooms', null, ['rows' => 4, 'class'=>'form-control']) !!}

                {{ Form::label('eventHotelNote', 'notatki:', array('class' => 'awesome')) }}
                {{ Form::text('eventHotelNote', 'notatki', ['class'=>'form-control']) }}

            </div>
            <div class="modal-bottom">
                <div class="btn-group float-end form-control" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-outline-success"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>
            {{ Form::close() }}
        </div>
    </div>
</div>
</div>