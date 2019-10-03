<!-- Modal Generate Carte Gift -->
<div class="modal fade" id="generateCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form class="" action="{{route('admin.cartgift.store')}}" method="post" enctype= "multipart/form-data">
    <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Générer vos Cartes Cadeaux</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Nombre de cartes <span style="color:red">*</span></strong>
                     <input type="text" class="form-control" id="nombre_carte" required name="nombre_carte" placeholder="Entrer le nombre de carte" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                       <strong>Pack carte</strong>
                       <select class="form-control" name="packgift" class="packgift">
                        @foreach($packgift as $packgifts)
                        <option value="{{ $packgifts->id }}">{{ $packgifts->title }}</option>
                        @endforeach
                       </select>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                    <div class="col-md-12">
                       <strong>Durée d'utilisation</strong>
                       <select class="form-control" name="dure_util" class="dure_util">
                        @foreach($packgift as $packgifts)
                        <option value="{{ $packgifts->validity }}">{{ $packgifts->validity }} jour(s)</option>
                        @endforeach
                       </select>
                    </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Nombre de caractère (NB: 32 caractères maximums)<span style="color:red">*</span></strong>
                     <input type="number" value="10" min="10" max="32" class="form-control" id="nbre_caractere" name="nbre_caractere">
                  </div>
                </div>
              </div>
            </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Générer les cartes</button>
          </div>
      </form>
    </div>
</div>

