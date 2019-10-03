@extends('layout.master')

@section('title', 'Gestion des Immobiliers')

@section('headertxt', 'Gérer vos Immobiliers')

@push('styles')
<style media="screen">
li.page-item {
  display: inline-block;
}
</style>
@endpush

@section('content')
  <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="seller-product-wrapper">
                      <div class="seller-panel">
                          <div class="card-header clearfix">
                                  <h4 style="padding-top: 15px;" class="d-inline-block text-white">VOS IMMOBILIERS</h4>
                                  <a href="{{route('vendor.immobilier.create',strTolower($categoris->name))}}" class="boxed-btn float-right">Créer un nouveau</a>
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>Immobiliers</th>
                                              <th>Nom</th>
                                              <th>Prix</th>
                                              <th>Type d'offre</th>
                                              <th>Date de creation</th>
                                              <th>&nbsp;</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($immobiliers as $immobilier)
                                          <tr>
                                              <td>
                                                  <div class="single-product-item"><!-- single product item -->
                                                      <div class="thumb">
                                                        <a href="#">
                                                          <img style="width:60px;" src="{{asset('assets/user/img/products/'.(App\Previewimage::where('immobilier_id',$immobilier->id)->first())->image)}}" alt="seller product image">
                                                        </a>
                                                      </div>
                                                      <div class="content">
                                                          <h4 class="title"><a target="_blank" href="#"></a></h4>
                                                      </div>
                                                  </div><!-- //.single product item -->
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $immobilier->nom }}
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $immobilier->prix }} &euro;
                                              </td>
                                              <td class="padding-top-40">{{ $immobilier->type_offre }}</td>
                                              <td class="padding-top-40">{{ $immobilier->created_at }}</td>
                                              <td class="padding-top-40">
                                                  <ul class="action">
                                                      <li><a target="_blank" href="{{route('vendor.immobilier.edit',$immobilier->id)}}"><i class="fas fa-pencil-alt"></i></a></li>
                                                      <li class="sp-close-btn"><a href="#" onclick="delImmobilier(event, {{ $immobilier->id}})"><i class="fas fa-times"></i></a></li>
                                                  </ul>
                                              </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- sellers product content area end -->
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
    function delImmobilier(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sure ?",
        text: "Une fois supprimé, Toutes les publications associées à ce produit seront supprimées également!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('vendor.immobilier.delete')}}',
            type: 'POST',
            data: {
              id: pid
            },
            success: function(data) {
              console.log(data);
              if (data == "success") {
                  window.location = '{{url()->current()}}';
              }
            }
          });
        }
      });
    }
  </script>
@endpush
