<div class="invoice p-3 mb-3">
    <div class="row justify-content-between">
        <div class="container">
            <div class="row justify-content-between mb-3">
                <div class="col">
                    <h4 class="mb-1">Dokumenty</h4>
                </div>
            </div>
        </div>
        <div class="row justify-content-between">
            <div class="card card-info p-0 m-0 col-xs-12 col-md-4">
                <div class="card-header"><i class="bi bi-plus"></i> dodaj dokument</div>
                    <div class="card-body">
                    <form action="{{ route('events.fileStore') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="card-text">
                            <input type="hidden" name="eventId" value={{ $event->id }}>
                            <div class="form-group">
                                <strong>Nazwa pliku</strong>
                                {!! Form::text('fileName', null, array('placeholder' => 'Nazwa pliku','class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Opis pliku</strong>
                                {!! Form::text('FileNote', null, array('placeholder' => 'opis pliku','class' => 'form-control')) !!}
                            </div>
                            <div class="form-group">
                                <strong>Wydruk dla pilota:</strong>
                                <select name="filePilotSet" id="filePilotPrint" class="form-control">
                                    <option value="nie">Nie</option>
                                    <option value="tak">Tak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <strong>Wydruk dla hotelu:</strong>
                                <select name="fileHotelSet" id="fileHotelPrint" class="form-control">
                                    <option value="nie">Nie</option>
                                    <option value="tak">Tak</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <strong>Dodaj plik:</strong><br>
                                <input type="file" name="eventFile" class="form-control" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success form-control"> Wyślij </button>
                    </form>
                </div>
            </div>

        <div class="col-xs-12 col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Pliki</h4>
                </div>
                <div class="card-body">
                    <div class="card-text">
                        <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <th>nazwa</th>
                                <th>notatki</th>
                                <th>pilot</th>
                                <th>hotel</th>
                                <th>operacje</th>
                            </thead>

                            @foreach($event->files as $file)
                            <tr>
                                <td>
                                    <a href="/storage/{{ $file->fileName }}" download>{{ $file->fileName }}</a>
                                </td>
                                {{ Form::open(array('url'=> 'eventfileupdate', 'method' => 'put')) }}
                                @csrf
                                <input type="hidden" name="id" value="{{ $file->id }}">
                                <input type="hidden" name="eventId" value="{{ $event->id }}">
                                <td>
                                    {{ Form::text('FileNote', $file->FileNote , ['class'=>'form-control']) }}
                                </td>
                                <td>
                                    <select class="form-select" name="filePilotSet">
                                        <option value="{{ $file->filePilotSet }}">{{ $file->filePilotSet }}</option>
                                        <option value="nie">nie</option>
                                        <option value="tak">tak</option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-select" name="fileHotelSet">
                                        <option value="{{ $file->fileHotelSet }}">{{ $file->fileHotelSet }}</option>
                                        <option value="nie">nie</option>
                                        <option value="tak">tak</option>
                                    </select>
                                </td>
                                <td>
                                    <div class="btn-group float-end" role="group" aria-label="Basic example">

                                        <button type="submit" class="btn btn-outline-success">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>
                                        {{ Form::close() }}

                                        {{ Form::open(array('url'=> 'filedelete', 'method' => 'post')) }}
                                        <input type="hidden" name="id" value="{{ $file->id }}">

                                        <button type="submit" class="btn btn-outline-danger float-end"><i class="bi bi-trash3"></i></button>
                                        {{ Form::close() }}
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<