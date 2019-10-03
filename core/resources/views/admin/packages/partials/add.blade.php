<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.package.store')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter Nouveau Package</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Titre Package </strong>
                     <input type="text" value="{{old('title')}}" class="form-control" id="name" name="title" placeholder="Titre package" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Description courte</strong>
                     <textarea class="form-control" name="s_desc" rows="3" cols="80" placeholder="Entrer une courte description">{{ old('s_desc') }}</textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Prix</strong>
                     <input type="text" value="{{old('price')}}" class="form-control" id="name" name="price" placeholder="Entrer le prix" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Produits</strong>
                     <input type="number" value="{{old('products')}}" class="form-control" id="name" name="products" placeholder="Entrer le nombre de produits" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Validité (en jours)</strong>
                     <input type="number" value="{{old('validity')}}" class="form-control" id="name" name="validity" placeholder="Entrez le nombre de jours valides" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                 <strong>Status</strong>
                 <select class="form-control" name="status">
                 <option value="1">Activer</option>
                 <option value="0">Desactiver</option>
                 </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">AJOUTER</button>
          </div>
      </form>
    </div>
  </div>
</div>
