<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="{{route('admin.subcategory1.store')}}" method="post">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Ajouter une nouvelle sous-catégorie</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
              {{csrf_field()}}
              <input type="hidden" name="subcategory_id" value="{{$subcategory->id}}">
              <div class="form-group">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <strong>Nom de la sous-catégorie</strong>
                      <input type="text" value="{{old('name')}}" class="form-control" id="name" name="name" placeholder="Entrez le nom de la sous-catégorie" >
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <strong>Les attributs (Option)</strong>
                      <div class="">
                        @foreach ($pas as $pa)
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" name="attributes[]" type="checkbox" id="pa{{$pa->id}}" value="{{$pa->id}}">
                            <label class="form-check-label" for="pa{{$pa->id}}">{{$pa->name}}</label>
                          </div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">ADD</button>
          </div>
      </form>
    </div>
  </div>
</div>
