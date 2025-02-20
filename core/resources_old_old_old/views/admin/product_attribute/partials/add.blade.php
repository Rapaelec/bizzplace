<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.productattr.store')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter un attribut de produit</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12 mb-10">
                     <strong>Nom de l'attribut du produit</strong>
                     <input type="text" value="" class="form-control" id="name" name="name" placeholder="Entrez le nom de l'attribut du produit" >
                  </div>
                  <div class="col-md-12 mb-10">
                    <strong>Status</strong>
                    <select class="form-control" name="status">
                      <option value="1">Active</option>
                      <option value="0">Deactive</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">AJOUTER</button>
          </div>
      </form>
    </div>
  </div>
</div>
