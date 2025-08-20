function contractorsearch(searchid){
    let element = document.querySelector("#"+searchid);    
    let keyword = element.value;
    let contractortype = element.dataset.contractortype;
    let dataplaceval = element.dataset.dataplace;
    let resoultplace = document.querySelector("#"+dataplaceval);

     $.post('{{ route("customersearch.search") }}',
      {
         _token: $('meta[name="csrf-token"]').attr('content'),
         keyword:keyword,
         contractortype:contractortype
       },
       function(data){
            resoultplace.innerHTML = ''        
            resoultplace.appendChild(dataTable(data))
       });

       }

function dataTable(data){

    console.log(data)
    let tbl = document.createElement("table")
    let tblBody = document.createElement("tbody")

    if(data.contractors.length <= 0)
    {
        tblBody.innerHTML = `
        <tr>
            <td colspan="3">Brak danych.</td>
        </tr>`;                
    }
    else
    {
        data.contractors.forEach(element => {
            let newRow = tbl.insertRow() 
            let elementId = newRow.insertCell()
            elementId.innerText = element.id
            let elementName = newRow.insertCell()
            elementName.innerText = element.name
            let elementFirstName = newRow.insertCell()
            elementFirstName.innerText = element.firstname
        
        })


    }
    return tbl     
}   