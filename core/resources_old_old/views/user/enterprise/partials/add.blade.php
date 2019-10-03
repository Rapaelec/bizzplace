<!-- Modal -->
<div class="modal fade" id="AddNumCard" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('user.employees.addcartgift')}}" method="post">
          {{csrf_field()}}
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">ATTRIBUTION D'UN CODE</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <strong>Matricule<span class="text-danger">*</span></strong>
                      <input type="text" class="form-control" id="matricule" name="matricule" placeholder="Matricule" >
                      <br><strong>Nom<span class="text-danger">*</span></strong>
                      <input type="text" class="form-control" id="nom" name="nom" placeholder="Nom" >
                      <br><strong>Prenom<span class="text-danger">*</span></strong>
                      <input type="text" class="form-control" id="prenom" name="prenom" placeholder="Prenom" >
                      <br><strong>Téléphone<span class="text-danger">*</span></strong>
                      <input type="text" class="form-control" id="telephone" name="telephone" placeholder="Téléphone" >
                      <br><strong>Email<span class="text-danger">*</span></strong>
                      <input type="text" class="form-control" id="email" name="email" placeholder="Email" >
                      <br><strong> Choix code<span class="text-danger">*</span> </strong>
                      <select name="num_cartgift" class="form-control">
                        <option>Sélectionner un code</option>
                        @foreach ($cartgifts as $cartgift)
                        <option value="{{ $cartgift->num_cartgift }}">{{  mb_substr($cartgift->num_cartgift,0,12) }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary"><i class=""></i>Enregistrer</button>
          </div>
      </form>
    </div>
  </div>
</div>