<!-- Modal -->
<div class="modal fade" id="editModal{{$package->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.package.update')}}" method="post">
          <input type="hidden" name="packageID" value="{{$package->id}}">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Editer Package</h5>
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
                     <input type="text" value="{{$package->title}}" class="form-control" id="name" name="title" placeholder="Entrer titre package " >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Description Courte</strong>
                     <textarea class="form-control" name="s_desc" rows="3" cols="80" placeholder="Enter short description">{{$package->s_desc}}</textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Prix</strong>
                     <input type="text" value="{{$package->price}}" class="form-control" id="name" name="price" placeholder="Entrer prix" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Products</strong>
                     <input type="number" value="{{$package->products}}" class="form-control" id="name" name="products" placeholder="Entrer le numéro de produit" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Validité (en jours)</strong>
                     <input type="number" value="{{$package->validity}}" class="form-control" id="name" name="validity" placeholder="Entrez le nombre de jours valides" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                 <strong>Status</strong>
                 <select class="form-control" name="status">
                 <option value="1" {{$package->status == 1 ? 'selected' : ''}}>Activer</option>
                 <option value="0" {{$package->status == 0 ? 'selected' : ''}}>Désactiver</option>
                 </select>
              </div>

          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">METTRE A JOUR</button>
          </div>
      </form>
    </div>
  </div>
</div>
