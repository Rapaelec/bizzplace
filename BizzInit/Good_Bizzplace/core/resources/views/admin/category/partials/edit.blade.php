<!-- Modal -->
<div class="modal fade" id="editModal{{$cat->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form class="" action="{{route('admin.category.update')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Modifier la catégorie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <input type="hidden" name="statusId" value="{{$cat->id}}">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12 mb-10">
                     <strong>Nom de catégorie</strong>
                     <input type="text" value="{{$cat->name}}" class="form-control" id="name" name="name" placeholder="Enter category name" >
                  </div>
                  <div class="col-md-12 mb-10">
                    <strong>Status</strong>
                    <select class="form-control" name="status">
                      <option value="1" {{($cat->status==1) ? 'selected' : ''}}>Activer</option>
                      <option value="0" {{($cat->status==0) ? 'selected' : ''}}>Desactiver</option>
                    </select>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Confirmer</button>
          </div>
      </form>
    </div>
  </div>
</div>
