@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Sous-catégorie sous <strong>{{$category->name}}</strong> Categorie</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title pull-left">Liste sous-categorie</h3>
              <div class="pull-right icon-btn">
                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
                   <i class="fa fa-plus"></i> Ajout sous-categorie
                 </button>
              </div>
              <p style="clear:both;margin:0px;"></p>
              <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              </div>
              <div class="table-responsive">
                @if (count($subcats) == 0)
                  <h2 class="text-center">AUCUNE SOUS-CATÉGORIE TROUVÉE</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Nom</th>
                           <th scope="col">Status</th>
                           <th scope="col">Sous-categories</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($subcats as $key => $subcat)
                            <tr>
                               <td>{{$key+1}}</td>
                               <td>{{$subcat->name}}</td>
                               <td>
                                 @if ($subcat->status == 1)
                                   <h4 style="display:inline-block;"><span class="badge badge-success">Activer</span></h4>
                                 @elseif ($subcat->status == 0)
                                   <h4 style="display:inline-block;"><span class="badge badge-danger">Desactiver</span></h4>
                                 @endif
                               </td>
                               <td>
                                 <a href="{{route('admin.subcategory.index', $subcat->id)}}" class="btn btn-info"><i class="fa fa-eye"></i> consulter</a>
                               </td>
                               <td>
                                 <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$subcat->id}}"><i class="fa fa-pencil-square"></i> Editer</button>
                                 <button type="button" class="btn btn-danger" onclick="deletesub(event,{{ $subcat->id }})"><i class="fas fa-times"></i> Supprimer</button>
                                </td>
                            </tr>
                            @includeif('admin.subcategory.partials.edit')
                          @endforeach
                     </tbody>
                  </table>
                @endif
              </div>

           </div>
        </div>
     </div>
  </main>

  @includeif('admin.subcategory.partials.add')
@endsection
@push('scripts')
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    });
    function deletesub(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sûre ?",
        text: "Une fois supprimé, vous ne pourrez plus récupérer cette catégorie.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('admin.subcategory2.destroy')}}',
            type: 'POST',
            data: {
              id: pid
            },
            success: function(data) {
              console.log(data);
              if (data.result== "success") {
                  window.location = '{{url()->current()}}';
              }
            }
          });
        }
      });
    }
  </script>
@endpush
