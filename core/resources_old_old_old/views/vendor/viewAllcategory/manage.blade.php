@extends('layout.master')

@section('title', 'Gestion des ' .$categoris)

@section('headertxt', 'Gerer vos ' . $categoris)

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
                                  <h4 style="padding-top: 15px;" class="d-inline-block text-white">VOS {{ strtoupper($categoris) }}</h4>
                                  <a href="{{ route('vendor.categoryAllcreate',strTolower($categoris)) }}" class="boxed-btn float-right">Créer un nouveau</a>
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>{{ $categoris }}</th>
                                              <th>Nom</th>
                                              <th>Prix</th>
                                              <th>Pays</th>
                                              <th>Date de creation</th>
                                              <th>&nbsp;</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($allcategoris as $allcategory)
                                          <tr>
                                              <td>
                                                  <div class="single-product-item"><!-- single product item -->
                                                      <div class="thumb">
                                                        <a href="#">
                                                          <img style="width:60px;" src="{{asset('assets/user/img/products/'.(App\Previewimage::where('allcategory_id',$allcategory->id)->first())->image)}}" alt="seller product image">
                                                        </a>
                                                      </div>
                                                      <div class="content">
                                                          <h4 class="title"><a target="_blank" href="#"></a></h4>
                                                      </div>
                                                  </div><!-- //.single product item -->
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $allcategory->title }}
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $allcategory->price }} &euro;
                                              </td>
                                              <td class="padding-top-40">{{ $allcategory->pays }}</td>
                                              <td class="padding-top-40">{{ $allcategory->created_at }}</td>
                                              <td class="padding-top-40">
                                                  <ul class="action">
                                                      <li><a href="{{route('vendor.categoryAlledit',$allcategory->id)}}"><i class="fas fa-pencil-alt"></i></a></li>
                                                      <li class="sp-close-btn"><a href="#" onclick="delAllcategory(event, {{ $allcategory->id}})"><i class="fas fa-times"></i></a></li>
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
    function delAllcategory(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sure ?",
        text: "Une fois supprimé, Toutes les publications associées à cet élément seront supprimées également!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('vendor.categoryAlldestroy')}}',
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