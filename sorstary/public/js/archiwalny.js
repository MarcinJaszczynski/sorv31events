$('#addEventDriverModal').on('keyup', function () {
    contractorsearch('driversearch');
});


$('#carriersearch').on('keyup', function () {
    contractorsearch('carriersearch');
});

$('#pilotsearch').on('keyup', function () {
    contractorsearch('pilotsearch');
});

$('#driversearch').on('keyup', function () {
    contractorsearch('driversearch');
});

$('#hotelsearch').on('keyup', function () {
    contractorsearch('hotelsearch');
});



$('.deleteconfirm').click(function () {
    return confirm("Czy na pewno chcesz usunąć element?");
});

// dodanie kontrahenta do elementu

// listener


console.log(document.querySelectorAll(".addelementcontractorlink"))







// koniec dodania kontrahenta do elementu

// wyszukiwanie kontrahenta

function contractorsearch(searchid) {
    let element = document.querySelector("#" + searchid);
    let keyword = element.value;
    let contractortype = element.dataset.contractortype;
    if (element.dataset.contractortype === '') {
        let select = document.querySelector("#" + searchid)
        contractortype = select.options[select.selectedIndex].value;
    }

    let dataplaceval = element.dataset.dataplace;
    let resoultplace = document.querySelector("#" + dataplaceval);

    $.post('{{ route("customersearch.search") }}', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            keyword: keyword,
            contractortype: contractortype
        },
        function (data) {
            resoultplace.innerHTML = ''
            resoultplace.appendChild(dataTable(data))
        });

}

function dataTable(data) {

    console.log(data)
    let tbl = document.createElement("table")
    let tblBody = document.createElement("tbody")
    // tbl.innerHTML=''
    // tblBody.innerHTML='' 

    if (data.contractors.length <= 0) {
        tblBody.innerHTML = `
                <tr>
                    <td colspan="3">Brak danych.</td>
                </tr>`;
    } else {


        data.contractors.forEach(element => {
            let newRow = tbl.insertRow()
            let radiobox = document.createElement("input")
            radiobox.type = "radio"
            radiobox.name = "contractor_id"
            radiobox.value = element.id
            let elementId = newRow.insertCell()
            elementId.appendChild(radiobox)
            // elementId.innerText = element.id
            let elementName = newRow.insertCell()
            elementName.innerText = element.name
            let elementFirstName = newRow.insertCell()
            elementFirstName.innerText = element.firstname
        })
    }

    console.log(tbl)
    return tbl
}

// koniec wyszukiwania kontrahenta

function paymentEdit() {
    let paymentEditList = document.querySelectorAll(".paymenteditlist");
    for (let i = 0; i < paymentEditList.length; i++) {
        let paymentElement = paymentEditList[i].querySelector('a')
        paymentElement.addEventListener('click', function () {
            getPayment(paymentElement.getAttribute('data-payment-id'))
        })
    };

}

function getPayment(paymentId) {
    let http = new XMLHttpRequest()
    http.open('GET', '/eventpayments/' + paymentId)
    http.onload = function () {
        const data = (JSON.parse(this.response));
        showEditPayment(data)
    }
    http.send();
}

function showEditPayment(data) {
    let payment = data.payment;
    let title = payment.paymentName
    let titleArea = document.querySelector("#paymentname")
    titleArea.value = title;
    let advanceArea = document.querySelector("#advanceAmount")
    console.log(payment)
}

paymentEdit()

eventElementEdit()

function eventElementEdit() {
    let eventEditList = document.querySelectorAll('.eventeditlink');
    for (let i = 0; i < eventEditList.length; i++) {

        let eventElement = eventEditList[i].querySelector('a');
        eventElement.addEventListener('click', function () {
            getElement(eventElement.getAttribute('data-element-id'))

        })
    }
}

function getElement(elementId) {

    let http = new XMLHttpRequest()
    http.open('GET', '/eventelement/' + elementId)
    http.onload = function () {
        const data = (JSON.parse(this.response));
        editElement(data)
    }
    http.send();
}

function editElement(data) {
    let eventElementEditModal = document.querySelector('#editEventElementModal')
    let elementName = eventElementEditModal.querySelector('#eventElementName')
    let elementBooking = eventElementEditModal.querySelector('#elementBooking')
    let pilotPrint = eventElementEditModal.querySelector('#pilotPrint')
    let hotelPrint = eventElementEditModal.querySelector('#hotelPrint')
    let elementStart = eventElementEditModal.querySelector('#elementStart')
    let elementEnd = eventElementEditModal.querySelector('#elementEnd')
    // let elementDescription = eventElementEditModal.querySelector('#elementDescription')
    elementName.value = data.element.element_name
    elementBooking.value = data.element.booking
    pilotPrint.value = data.element.eventElementPilotPrint
    hotelPrint.value = data.element.eventElementHotelPrint
    let start = getIsoDate(data.element.eventElementStart)
    let end = getIsoDate(data.element.eventElementEnd)
    elementStart.value = start
    elementEnd.value = end


    $('#elementDescription').summernote(
        'code', data.element.eventElementDescription
    )
    $('#elementNote').summernote(
        'code', data.element.eventElementNote
    )
    $('#elementReservation').summernote(
        'code', data.element.eventElementReservation
    )


    console.log(data.element)

}






//TODO - zrobić z tego normalną funkcję i napisać odwrotne śledzenie jak zmieni się datę
$('#elementduration').on('keyup', function () {
    let duration = document.querySelector("#elementduration").value.split(":")
    let datepicker = document.getElementById("elementEnd")
    let timestmp = new Date(document.getElementById("elementStart").value)
    let enddate = new Date(timestmp.getTime() + duration[0] * 60 * 60 * 1000 + duration[1] * 60 * 1000)

    let year = enddate.getFullYear();
    let month = enddate.getMonth() + 1;
    month = month <= 9 ? '0' + month : month;
    let day = enddate.getDate();
    day = day <= 9 ? '0' + day : day;
    let hour = enddate.getHours();
    hour = hour <= 9 ? '0' + hour : hour
    let minute = enddate.getMinutes();
    minute = minute <= 9 ? '0' + minute : minute

    let datetimeIso = year + "-" + month + "-" + day + "T" + hour + ":" + minute
    datepicker.value = datetimeIso

    elduration(timestmp, datetimeIso)

});

function getIsoDate(time) {
    date = new Date(time)
    console.log(date)
    let year = date.getFullYear();
    let month = date.getMonth() + 1;
    month = month <= 9 ? '0' + month : month;
    let day = date.getDate();
    day = day <= 9 ? '0' + day : day;
    let hour = date.getHours();
    hour = hour <= 9 ? '0' + hour : hour
    let minute = date.getMinutes();
    minute = minute <= 9 ? '0' + minute : minute

    let datetimeIso = year + "-" + month + "-" + day + "T" + hour + ":" + minute
    console.log(datetimeIso)
    return datetimeIso
}


$('#elementPaymentStatus').change(function () {
    let paymentStatus = document.querySelector('#elementPaymentStatus')
    let advanceArea = document.querySelector('#advanceArea')
    console.log(paymentStatus.value)

    if (paymentStatus.value == 2) {
        console.log('Zaliczka')
        advanceArea.className = "d-block"
    } else {
        advanceArea.className = "d-none"
    }


})

$('#paymentArea').on('keyup', function () {
    let totalPrice = 0
    let elementPrice = document.querySelector('#elementPrice')
    let elementQty = document.querySelector('#elementQty')
    let elementPriceTotal = document.querySelector('#elementPriceTotal')

    totalPrice = elementPrice.value * elementQty.value


    elementPriceTotal.innerText = parseFloat(totalPrice).toFixed(2);
})


$('#elementStart').on('keyup', function () {
    let duration = document.querySelector("#elementduration").value.split(":")
    let datepicker = document.getElementById("elementEnd")
    let timestmp = new Date(document.getElementById("elementStart").value)
    let enddate = new Date(timestmp.getTime() + duration[0] * 60 * 60 * 1000 + duration[1] * 60 * 1000)

    let year = enddate.getFullYear();
    let month = enddate.getMonth() + 1;
    month = month <= 9 ? '0' + month : month;
    let day = enddate.getDate();
    day = day <= 9 ? '0' + day : day;
    let hour = enddate.getHours();
    hour = hour <= 9 ? '0' + hour : hour
    let minute = enddate.getMinutes();
    minute = minute <= 9 ? '0' + minute : minute

    let datetimeIso = year + "-" + month + "-" + day + "T" + hour + ":" + minute
    datepicker.value = datetimeIso

})



function elduration(starttime, endtime) {

    let durationPlace = document.querySelector("#elementduration")
    let startTime = new Date(starttime)
    let endTime = new Date(endtime)
    let difference = endTime.getTime() - startTime.getTime()
    console.log(startTime.getTime() + " - " + endTime.getTime() + " = " + difference)

}
