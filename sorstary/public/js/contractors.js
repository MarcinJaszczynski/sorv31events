function addElementContractorLink() {
    let elements_list = document.querySelectorAll('.addElementContractorLink');
    for (let i = 0; i < elements_list.length; i++) {
        elements_list[i].addEventListener('click', () => {
            document.querySelector('#elementNameHeader').innerText = elements_list[i].dataset.elementname;
        })
    }

    let type_select_field = document.querySelector('#elementcontractortypefield');
    let contractor_name_search_field = document.querySelector('#elementcontractorsearchfield');

    type_select_field.addEventListener('click', () => {})

    contractor_name_search_field.addEventListener('keyup', () => {
        getContractor(type_select_field.value, contractor_name_search_field.value);
    })
}

function getContractor(type, keyword) {

    var root = window.location.protocol + '//' + window.location.host;

    let GET_USERS_URL = root + '/events';
    console.log(GET_USERS_URL)
    var params = 'type=' + type + '&amp;keyword=' + keyword




    let http = new XMLHttpRequest()
    http.open('POST', '/getcontractor')
    http.onload = function () {
        // const data = (JSON.parse(this.response));
        console.log(this.response)
    }
    http.send(params);





}


addElementContractorLink()
