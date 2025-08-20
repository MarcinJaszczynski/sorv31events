$('#search').on('keyup', function(){
    search();
});
search();
function search(){
     var keyword = $('#search').val();
     $.post('{{ route("customersearch.search") }}',
      {
         _token: $('meta[name="csrf-token"]').attr('content'),
         keyword:keyword
       },
       function(data){
        table_post_row(data);
          console.log(data);
       });
}
// table row with ajax
function table_post_row(res){
let htmlView = '';
let contractorCard = '';
if(res.contractors.length <= 0){
    htmlView+= `
       <tr>
          <td colspan="4">Brak danych.</td>
      </tr>`;
}
for(let i = 0; i < res.contractors.length; i++){
    htmlView += `
        <tr>
           <td>`+ (i+1) +`</td>
              <td>`+res.contractors[i].name+`</td>
               <td>`+res.contractors[i].phone+`</td>
        </tr>`;

    contractorCard += `
        <div class="card">
            <div class="card-header">
                <h5><input name="purchaser_id" type="radio" value="`+res.contractors[i].id+`">
`+res.contractors[i].name+`</h5>            
            </div>
            <dic class="card-body">
                <div>Imię: `+res.contractors[i].firstname+`</div>
                <div>Nazwisko: `+res.contractors[i].surname+`</div>
                <div>tel: `+res.contractors[i].phone+`</div>
                <div>email: `+res.contractors[i].email+`</div>
                <div>ul: `+res.contractors[i].street+`</div>
                <div>województwo: `+res.contractors[i].region+`</div>
                <div>
            </div>

        </div>`;    

        $('#eventPurchaserName').val(res.contractors[i].name)
        $('#eventPurchaserPhone').val(res.contractors[i].phone)
        $('#eventPurchaserEmail').val(res.contractors[i].email)
        $('#eventPurchaserStreet').val(res.contractors[i].street)
        $('#eventPurchaserCity').val(res.contractors[i].city)
        $('#eventPurchaserRegion').val(res.contractors[i].region)

}
     $('tbody').html(htmlView);
     $('#contractorsCards').html(contractorCard);
}