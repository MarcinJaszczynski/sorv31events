<div class="modal fade" id="createPilotModal" tabindex="-1" role="dialog" aria-labelledby="createPilotModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">            
            <div class="modal-header">
                <div class="modal-title">
                    <h4>Dodaj pilota</h4>
                </div>
            </div>

            <div class="modal-body m-3">
                <form action="/contractors" method="POST">
                @csrf
                <input type="hidden" name="contractortype[]" value="5">

 


            <div class="row">
                <div class="col-md-6">
                  <label>Dane kontrahenta</label>
                  <div class="form-group">
                  <input type="text" class="form-control form-control-border" name="name" placeholder="Imię i nazwisko/Nazwa kontrahenta">
                  </div>

                  <div class="form-group">
                  <input type="text" class="form-control form-control-border" name="firstname" placeholder="Imię"> 
                  </div>

                  <div class="form-group">        
                  <input type="text" class="form-control form-control-border" name="surname" placeholder="Nazwisko">  
                  </div>

                  <div class="form-group ">               
                  <input type="text" class="form-control form-control-border" name="street" placeholder="Ulica"> 
                  </div>
                  <div class="form-group">             
                  <input type="text" name="city" class="form-control form-control-border" placeholder="Miasto">
                  </div>                  

                  <div class="form-group">
                  <input type="text" class="form-control form-control-border" name="nip" placeholder="nip">
                  </div>                  
                </div>
                <div class="col-md-6">
                  <label>Kontakt</label>
                  <div class="form-group">
                  <input type="text" class="form-control form-control-border" name="phone" placeholder="telefon">
                  </div>
                  <div class="form-group">
                  <input type="email" class="form-control form-control-border" name="email" placeholder="email">
                  </div>
                  <div class="form-group">
                  <input type="text" class="form-control form-control-border" name="www" placeholder="www">
                  </div>

                
                  <label for="name">Komentarz:</label>
                  <textarea class="summernoteeditor m-3" name="description"></textarea>
                </div>

                    

                </div>
                
            </div>
            <div class="modal-bottom">
                <div class="btn-group m-3 float-end" role="group" aria-label="Basic example">
                    <button type="submit" class="btn btn-primary"><i class="bi bi-hdd"></i> Zapisz</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                </div>
            </div>

        </div>
    </form>
    </div>
</div>

