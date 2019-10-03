@extends('layout.master')

@section('title', 'Gestions des produits')

@section('headertxt', 'Gérer vos produits')

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
                                  <h4 style="padding-top: 15px;" class="d-inline-block text-white">VOS PRODUITS</h4>
                                  <a href="{{route('vendor.product.create')}}" class="boxed-btn float-right">Nouveau produit</a>
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>Produits</th>
                                              <th>Prix</th>
                                              <th>Quantité restante</th>
                                              <th>Total des gains</th>
                                              <th>Ventes</th>
                                              <th>&nbsp;</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($products as $product)
                                          @php
                                            $totalearning = \App\Orderedproduct::where('shipping_status', 2)
                                                                  ->where('refunded', '<>', 1)
                                                                  ->where('product_id', $product->id)->sum('product_total');
                                          @endphp
                                          @if($product->previewimages()->count()>0)
                                          <tr>
                                              <td>
                                                  <div class="single-product-item"><!-- single product item -->
                                                      <div class="thumb">
                                                        <a href="#">
                                                          <img style="width:60px;" src="{{asset('assets/user/img/products/'.$product->previewimages()->first()->image)}}" alt="seller product image">
                                                        </a>
                                                      </div>
                                                      <div class="content">
                                                          <h4 class="title"><a target="_blank" href="{{route('user.product.details', [$product->slug,$product->id])}}">{{strlen($product->title) > 28 ? substr($product->title, 0, 28) . '...' : $product->title}}</a></h4>
                                                      </div>
                                                  </div><!-- //.single product item -->
                                              </td>
                                              <td class="padding-top-40">
                                                @if (!empty($product->current_price))
                                                  <del>{{$gs->base_curr_symbol}} {{$product->price}}</del> <span class="text-secondary">{{$gs->base_curr_symbol}} {{$product->current_price}}</span>
                                                @else
                                                  <span>{{$gs->base_curr_symbol}} {{$product->price}}</span>
                                                @endif
                                              </td>
                                              <td class="padding-top-40">
                                                @if ($product->quantity==0)
                                                  <span class="badge badge-danger">En rupture de stock</span>
                                                @else
                                                  {{$product->quantity}}
                                                @endif
                                              </td>
                                              <td class="padding-top-40">{{$gs->base_curr_symbol}} {{$totalearning}}</td>
                                              <td class="padding-top-40">{{$product->sales}}</td>
                                              <td class="padding-top-40">
                                                  <ul class="action">
                                                      <li><a target="_blank" href="{{route('user.product.details', [$product->slug,$product->id])}}"><i class="far fa-eye"></i></a></li>
                                                      <li><a target="_blank" href="{{route('vendor.product.edit', $product->id)}}"><i class="fas fa-pencil-alt"></i></a></li>
                                                      <li class="sp-close-btn"><a href="#" onclick="delproduct(event, {{$product->id}})"><i class="fas fa-times"></i></a></li>
                                                  </ul>
                                              </td>
                                          </tr>
                                          @endif
                                        @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="text-center">
                                     {{$products->links()}}
                                  </div>
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
    function delproduct(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sure ?",
        text: "Une fois supprimé, vous ne pourrez plus récupérer ce produit et toutes les publications associées à ce produit seront supprimées!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('vendor.product.delete')}}',
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
