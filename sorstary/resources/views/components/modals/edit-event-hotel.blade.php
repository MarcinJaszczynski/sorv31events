<div class="modal fade" id="eventHotelEditModal" role="dialog" aria-labelledby="eventHotelEditModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            {{ Form::open(array('url' => 'eventhotel/update', 'method' => 'put')) }}
            @csrf
            <div class="modal-header">
                <h5>Edytuj noclegi</h5>
            </div>
            <div class="modal-body">
                <input type="hidden" name="event_id" value="{{ $event->id }}">
                <input type="hidden" name="hotel_id" id="eHotelId" value="">
                <div id="eHotelName"></div>
                {{ Form::label('eventHotelStartDate', 'Początek rezerwacji', array('class' => 'awesome')) }}
                {{ Form::input('dateTime-local', 'eventHotelStartDate', date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), ['class' => 'form-control', 'id'=>'eHotelStart', 'min' => date('Y-m-d\TH:i',  strtotime($event->eventStartDateTime)), 'max' => date('Y-m-d\TH:i',  strtotime($event->eventEndDateTime)) ]) }}

                {{ Form::label('eventHotelEndDate', 'koniec rezerwacji', array('class' => 'awesome')) }}
                {{ Form::input('dateTime-local', 'eventHotelEndDate', null, ['class' => 'form-control', 'id'=>'eHotelEnd']) }}

                {{ Form::label('eventHotelRooms', 'struktura pokojów', array('class' => 'awesome')) }}
                {!! Form::textarea('eventHotelRooms', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'eHotelRooms']) !!}

                {{ Form::label('eventHotelNote', 'notatki:', array('class' => 'awesome')) }}
                {!! Form::textarea('eventHotelNote', null, ['rows' => 4, 'class'=>'form-control', 'id'=>'eHotelNote']) !!}
              <!-- {{ Form::text('eventHotelNote', 'notatki', ['class'=>'form-control', 'id'=>'eHotelNote']) }} -->

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
