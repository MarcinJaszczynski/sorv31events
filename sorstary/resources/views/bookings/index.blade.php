@extends('layouts.app')
@section('content')


<div id='card-container'></div>

<div class="container">
<h1> Rezerwacje - index </h1> 
                <table class="table table-hover table-head-fixed table-responsive">
                    <thead class="thead-dark">
                        <tr>
                            <th class="col-md-1">czas</th>
                            <th class="col-md-4">Impreze</th>
                            <th class="col-md-4">Element</th>
                            <th class="col-md-3">Płatności</th>
                        </tr>
            @php
                $oldday = new Date();
            @endphp  
                    </thead>
                    @foreach($data as $element)
                        @php
                        $newday = \Carbon\Carbon::parse($element->eventElementStart)->format('d-m-Y');
                        if($newday!=$oldday){
                            echo '<tr class="bg-success"><td colspan="5" class="bg-success"><h4>'.$newday.'</h4></td></tr>';
                            $oldday=$newday;
                        }             
                        @endphp
                    <x-layout-elements.booking-list-row :element='$element' />
                    @endforeach
</table>

</div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js""></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script></div>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



<script>
    $(document).ready(function() {
        $("#editEventNote").summernote();
        $('.dropdown-toggle').dropdown();
    });
</script>
@endsection