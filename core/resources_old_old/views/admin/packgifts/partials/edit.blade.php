<!-- Modal -->
<div class="modal fade" id="editModal{{$packgifts->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.packgift.update')}}" method="post" enctype="multipart/form-data">
          <input type="hidden" name="packageID" value="{{$packgifts->id}}">
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
                     <input type="text" value="{{$packgifts->title}}" class="form-control" id="name" name="title" placeholder="Entrer titre package " >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Description Courte</strong>
                     <textarea class="form-control" name="s_desc" rows="3" cols="80" placeholder="Entrer une courte description">{{$packgifts->description}}</textarea>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Prix</strong>
                     <input type="text" value="{{$packgifts->price}}" class="form-control" id="name" name="price" placeholder="Entrer le prix" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Validité (en jours)</strong>
                     <input type="number" value="{{$packgifts->validity}}" class="form-control" id="name" name="validity" placeholder="Entrer le nombre de jours" >
                  </div>
                </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                     <strong>Image </strong>
                     <input type="file" class="form-control" value="{{ $packgifts->img_pack }}" id="img_pack" name="img_pack">
                  </div>
                </div>
              </div>
              <div class="form-group">
                 <strong>Status</strong>
                 <select class="form-control" name="status">
                 <option value="1" {{$packgifts->status == 1 ? 'selected' : ''}}>Activer</option>
                 <option value="0" {{$packgifts->status == 0 ? 'selected' : ''}}>Desactiver</option>
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
