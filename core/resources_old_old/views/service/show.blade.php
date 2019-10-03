@extends('layout.master')

@section('title', "Detail service")
@push('styles')
  <style media="screen">
  div.ratingpro {
      display: inline-block;
  }
  .product-details-slider.owl-carousel .owl-item img {
    width: auto;
  }
  @media only screen and (max-width: 575px) {
    .product-details-slider.owl-carousel .owl-item img {
      width: 100%;
    }
  }
  </style>
  <link rel="stylesheet" href="{{asset('assets/user/css/comments.css')}}">
<link rel="stylesheet" href="{{asset('assets/user/css/easyzoom.css')}}">
@endpush

@section('headertxt', 'Detail Service')

@section('content')
  <!-- product details content area  start -->
      <div class="product-details-content-area">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="left-content-area"><!-- left content area -->
                          <div class="product-details-slider" id="product-details-slider" data-slider-id="1">
                            @foreach($services->previewimages as $previewimage)
                              <div class="single-product-thumb">
                              <div class="easyzoom easyzoom--overlay">
                        				<a href="{{asset('assets/user/img/products/'.$previewimage->big_image)}}">
                        					<img class="single-image" src="{{asset('assets/user/img/products/'.$previewimage->image)}}" alt=""/>
                        				</a>
                        			</div>
                              </div>
                            @endforeach
                          </div>
                          <ul class="owl-thumbs product-deails-thumb" data-slider-id="1">
                              @foreach($services->previewimages as $previewimage)
                                <li class="owl-thumb-item">
                                    <img src="{{asset('assets/user/img/products/'.$previewimage->image)}}" alt="product details thumb">
                                </li>
                              @endforeach
                          </ul>
                      </div><!-- //.left content area -->
                  </div>
                  <div class="col-lg-6">
                      <div class="contaner" style="margin-top:28%;margin-left:5%">
                      <div class="row">
                          <div class="col-md-6 font-weight-bold text-primary">
                           Sous categorie:
                          </div>
                          <div class="col-md-6">
                          {{$services->subcategory->name}}
                          </div>
                      </div>
                      <div class="row mt-2">
                          <div class="col-md-6 font-weight-bold text-primary">
                          Pays:
                          </div>
                          <div class="col-md-6">
                          {{$services->pays}}
                          </div>
                      </div>
                      <div class="row mt-2">
                          <div class="col-md-6 font-weight-bold text-primary">
                          Departement: 
                          </div>
                          <div class="col-md-6">
                          {{$services->departement}}
                          </div>
                      </div>
                      <div class="row mt-2">
                          <div class="col-md-6 font-weight-bold text-primary">
                          Ville: 
                          </div>
                          <div class="col-md-6">
                          {{$services->ville}}
                          </div>
                      </div>
                      <div class="row mt-2">
                          <div class="col-md-6 font-weight-bold text-primary">
                          Code postale: 
                          </div>
                          <div class="col-md-6">
                          {{$services->cod_postal}}
                          </div>
                      </div>
                      <div class="row mt-2">
                          <div class="col-md-6 font-weight-bold text-primary">
                          Rue: 
                          </div>
                          <div class="col-md-6">
                          {{$services->rue}}
                          </div>
                      </div>
                      <div class="row mt-5">
                          <div class="col-md-6 font-weight-bold text-primary">
                          Mots clés: 
                          </div>
                          <div class="col-md-6">
                          {{$services->keywords}}
                          </div>
                      </div>
                      <div class="row mt-5">
                          <div class="col-md-6 font-weight-bold text-primary">
                          <a href="#" class="btn btn-outline-success" data-toggle="modal" data-target="#sendMessageAnnonceur"><i class="fa fa-paper-plane" aria-hidden="true"></i> Contacter l'annonceur</a>
                        </div>
                      </div>
                  </div>
                </div>
              </div>
              <div class="row">
                  <div class="col-lg-12">
                      <div class="product-details-area">
                          <div class="product-details-tab-nav">
                              <ul class="nav nav-tabs" role="tablist">
                                  <li class="nav-item">
                                    <a class="nav-link {{session('success')=='Reviewed successfully'?'':'active'}}" id="descr-tab" data-toggle="tab" href="#descr" role="tab" aria-controls="descr" aria-selected="false">description</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link {{session('success')=='Reviewed successfully'?'active':''}}" id="item-review-tab" data-toggle="tab" href="#item_review" role="tab" aria-controls="item_review" aria-selected="true">Service Similaire</a>
                                  </li>
                                 {{--  @auth
                                    @if (\App\ProductReview::where('user_id', Auth::user()->id)->where('product_id', $product->id)->count() == 0)
                                      @if (\App\Orderedproduct::where('user_id', Auth::user()->id)->where('product_id', $product->id)->where('shipping_status', 2)->count() > 0)
                                        <li class="nav-item">
                                          <a class="nav-link" id="write-tab" data-toggle="tab" href="#write" role="tab" aria-controls="write" aria-selected="false">Écrire des commentaires</a>
                                        </li>
                                      @endif
                                    @endif
                                  @endauth --}}
                                  <li class="nav-item">
                                    <a class="nav-link" id="item-review-tab" data-toggle="tab" href="#vendor_info" role="tab" aria-controls="item_review" aria-selected="true">Information Agence</a>
                                  </li>
                              </ul>
                          </div>
                            <div class="tab-content" >
                              <div class="tab-pane fade {{session('success')=='Reviewed successfully'?'':'show active'}}" id="descr" role="tabpanel" aria-labelledby="descr-tab">
                                  <div class="descr-tab-content">
                                      @includeif('service.partials.description')
                                  </div>
                              </div>
                              <div class="tab-pane fade {{session('success')=='Reviewed successfully'?'show active':''}}" id="item_review" role="tabpanel" aria-labelledby="item-review-tab">
                                <div class="descr-tab-content">
                                    @includeif('service.partials.comments')
                                </div>
                              </div>
                             {{--  @auth
                                @if (\App\ProductReview::where('user_id', Auth::user()->id)->where('product_id', $product->id)->count() == 0)
                                  @if (\App\Orderedproduct::where('user_id', Auth::user()->id)->where('product_id', $product->id)->where('shipping_status', 2)->count() > 0)
                                    <div class="tab-pane fade" id="write" role="tabpanel" aria-labelledby="write-tab">
                                        <div class="more-feature-content">
                                          @includeif('service.partials.writereview')
                                        </div>
                                    </div>
                                  @endif
                                @endif
                              @endauth --}}
                              <div class="tab-pane fade" id="vendor_info" role="tabpanel" aria-labelledby="item-review-tab">
                                <div class="descr-tab-content">
                                    @includeif('service.partials.vendor_info')
                                </div>
                              </div>
                            </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  <!-- product details content area end -->
  <!-- recently added start -->
  <div class="recently-added-area product-details">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                      <ul>
                          <li>Services connexes</li>
                      </ul>
                  </div><!-- //.recently added nav menu -->
              </div>
             
              <div class="col-lg-12">
                  <div class="recently-added-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                    @foreach ($r_services as $key => $service)
                    <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{asset('assets/user/img/products/'.$service->previewimages()->first()->image)}}" alt="nouvelle collection image">
                                    <div class="hover">
                                      <a href="{{route('user.service.details', [$service->slug, $service->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="category" style="color:black;">{{ $service->nom}}</span>
                                    <div class="row">
                                      <div class="col-md-12">
                                      {{ $service->ville}}
                                      <hr>
                                        <div class="price"><span class="sprice">{{$service->promotion}}</span></div>
                                      </div>
                                    </div>
                                </div> 
                    </div><!-- //. single new collections  -->
                    @endforeach
                    <div class="single-new-collection-item ">
                      <div class="view-all-wrapper">
                        <div class="view-all-inner">
                          <a class="view-all-icon-wrapper" href="{{route('user.search', [$services->category_id, $services->subcategory_id])}}">
                            <i class="fa fa-angle-right"></i>
                          </a>
                          <a class="d-block view-all-txt" href="{{route('user.search', [$services->category_id, $services->subcategory_id])}}">Voir tout</a>
                        </div>
                      </div>
                    </div>
                  </div><!-- //. recently added carousel -->
              </div>
          </div>
      </div>
  </div>
  <!-- recently added end -->
@includeif('service.partials.modal_send_message')
@endsection

@push('scripts')
  <script src="{{asset('assets/user/js/easyzoom.js')}}"></script>
  <script>
  $(document).ready(function() {
    var $easyzoom = $('.easyzoom').easyZoom();
  });

  </script>
  <script>
    function favorit(e, productid) {
      e.preventDefault();
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      var fd = new FormData();
      fd.append('productid', productid);
      $.ajax({
        url: '{{route('user.favorit')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
          if (data == "favorit") {
            toastr["success"]("Ajouté à la liste de souhaits!");
            $("#heart").addClass('red');
          } else if (data == "unfavorit") {
            $("#heart").removeClass('red');
          }
        }
      })
    }

    function qtchange(status) {
      var qt = $("#qttotal").text();
      if (status == 'plus') {
        var newqt = parseInt(qt) + 1;
      } else if (status == 'minus' && qt>=2) {
        var newqt = parseInt(qt) - 1;
      } else {
        var newqt = 1;
      }
      $("#qttotal").html(newqt);
      console.log(newqt);
    }
  </script>

  <script>
    var globalrating;

    $(function () {
      $("#writeRateYo").rateYo({
        onChange: function (rating, rateYoInstance) {
          $(this).next().text(rating);
          globalrating = rating;
          console.log(rating);
        },
      });
    });

    function reviewsubmit(e) {
      e.preventDefault();
      // console.log(globalrating);
      var form = document.getElementById('reviewform');
      var fd = new FormData(form);
      if (globalrating) {
        fd.append('rating', globalrating);
      } else {
        fd.append('rating', '');
      }

      $.ajax({
        url: '{{route('user.review.submit')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: (data) => {
          console.log(data);

          if(typeof data.error != 'undefined') {
              if (typeof data.rating != 'undefined') {
                document.getElementById('errrating').innerHTML = data.rating[0];
              }
          } else {
            window.location = '{{url()->current()}}';
          }
        }
      });
    }

    $(document).ready(function() {
      var pid = {{$services->id}};
      $.get("{{route('user.avgrating', $services->id)}}", function(data){
        $("#ratingPro"+pid).rateYo({
          rating: data,
          readOnly: true,
          starWidth: "16px"
        });
      });
    });
  </script>

@endpush