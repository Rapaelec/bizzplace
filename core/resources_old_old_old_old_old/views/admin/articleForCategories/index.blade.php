@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Liste produit</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title float-left">Liste Produit soumis à validation </h3>
              <div class="float-right icon-btn">
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
                @if (count($products_cats) == 0)
                  <h2 class="text-center">Aucun produit trouvé</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Nom</th>
                           <th scope="col">Image</th>
                           <th>Validation produit</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($products_cats as $key => $cat)
                            <tr>
                               <td>{{$key+1}}</td>
                               <td>{{$cat->title}}</td>
                               <td>
                               <div class="thumb">
                                    <a href="#">
                                        <img style="width:60px;" src="{{asset('assets/user/img/products/'.$cat->previewimages()->first()->image)}}" alt="seller product image">
                                    </a>
                                </div>
                               </td>
                               <td>
                                 @if ($cat->category()->first()->product_validate == 1)
                                   <h4 style="display:inline-block;"><span class="badge badge-success">Activer</span></h4>
                                 @elseif ($cat->category()->first()->product_validate == 0)
                                   <h4 style="display:inline-block;"><span class="badge badge-danger">Desactiver</span></h4>
                                 @endif
                               </td>
                               <td>
                                 <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editModal{{$cat->id}}">Editer</button>
                                 {{-- <button type="button" class="btn btn-danger" onclick="deletesub(event,{{ $cat->id }})"><i class="fas fa-times"></i> Supprimer</button> --}}
                                </td>
                            </tr>
                            @includeif('admin.articleForCategories.partials.edit')
                          @endforeach
                     </tbody>
                  </table>
                @endif
              </div>
              <div class="text-center">
                {{$products_cats->links()}}
              </div>
           </div>
        </div>
     </div>
  </main>

  {{-- Gateway Add Modal --}}
  @includeif('admin.category.partials.add')
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
        title: "Êtes vous sûre de vouloir supprimer?",
        // text: "Une fois supprimé, vous ne pourrez plus récupérer cette catégorie.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('admin.category.delete')}}',
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
