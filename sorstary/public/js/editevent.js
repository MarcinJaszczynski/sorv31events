// $(document).ready(function() {
//     $("#editEventNote").summernote();
//     $('.dropdown-toggle').dropdown();
// });


//   $('#editEventNote').summernote({
//     placeholder: 'Hello Bootstrap 4',
//     tabsize: 2,
//     height: 100
//   });


$(document).ready(function() {
    $('.elementCreateBtn').on('click', function() {
        $('#createEventElementModal').modal('show');
    })
})

$(document).ready(function() {
    $('#btnAddHotel').on('click', function() {
        $('#createHotelModal').modal('show');
    })
})

$(document).ready(function() {
    $('#contractButton').on('click', function() {
        $('#contractModal').modal('show');
    })
})

const addTodoShow = () => {
    let showAddTodoModalBtn = document.getElementById('btnCreateTodoModal')
    showAddTodoModalBtn.addEventListener('click', function () {
            $('#todoCreateModal').modal('show')
        })
}

addTodoShow()


const addHotelShow = () => {
    let showAddHotelBtn = document.getElementById('btnAddEventHotel')
    let addHotelModal = document.getElementById('addEventHotelModal')
    showAddHotelBtn.addEventListener("click", function() {
        $('#addEventHotelModal').modal('show')
    })
}


addHotelShow()









// <!-- /////////////// Start - Obługa edycji hotelu w rezerwacji ///////////////////////////////// -->

$(document).ready(function() {
    $('.eventHotelEditBtn').on('click', function() {
        $('#eventHotelEditModal').modal('show');

        $tr = $(this).closest('tr');

        var eventHotelData = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        var eStartTime = new Date(eventHotelData[1]);
        var localHotelTime = eStartTime.getTimezoneOffset() / 60
        eStartTime.setHours(eStartTime.getHours() - localHotelTime);

        eStartTime = eStartTime.toISOString().slice(0, -1);
        console.log(eStartTime);
        var a = document.getElementById(
            "eHotelStart").defaultValue = eStartTime;


        var eEndTime = new Date(eventHotelData[2]);
        eEndTime.setHours(eEndTime.getHours() - localHotelTime);

        eEndTime = eEndTime.toISOString().slice(0, -1);
        console.log(eventHotelData);
        var b = document.getElementById(
            "eHotelEnd").defaultValue = eEndTime;

        // $('#eHotelEnd').val(eventHotelData[2]);

        $('#eHotelRooms').val(eventHotelData[7]);

        $('#eHotelNote').val(eventHotelData[8]);

        $('#eHotelId').val(eventHotelData[0]);

        document.getElementById('eHotelName') = eventHotelData[3].innerText;




    })
})


// <!-- /////////////// Koniec - Obługa edycji hotelu w rezerwacji ///////////////////////////////// -->

$(document).ready(function() {

    $('.editbtn').on('click', function() {

        $('#eventElementEditModal').modal('show');
        $tr = $(this).closest('tr');
        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();
        $('#elementId').val(data[0]);
        var startTime = new Date(data[1]);
        var localTime = startTime.getTimezoneOffset() / 60
        startTime.setHours(startTime.getHours() - localTime);
        console.log(startTime);
        startTime = startTime.toISOString().slice(0, -1);
        var c = document.getElementById(
            "elementStart").defaultValue = startTime;
        var endTime = new Date(data[2]);
        endTime.setHours(endTime.getHours() - localTime);
        endTime = endTime.toISOString().slice(0, -1);
        var d = document.getElementById(
            "elementEnd").defaultValue = endTime;

        // $('#elementEnd').val(data[2]);

        $('#elementName').val(data[3]);
        $('#elementDescription').val(data[4]);
        $('#elementContact').val(data[5]);
        $('#elementReservation').val(data[6]);
        $('#elementNote').val(data[7]);
        $('#elementHotelPrint').val(data[8]);
        document.getElementById("elementHotelPrint").innerHTML = data[8];
        $('#elementPilotPrint').val(data[9]);
        document.getElementById("elementPilotPrint").innerHTML = data[9];
        $('#elementBooking').val(data[10]);
        document.getElementById("elementBooking").innerHTML = data[10];






    });
});