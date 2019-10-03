@extends('layout.master')

@section('title', "$product->nom")

@section('headertxt', 'Detail Immobilier')

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

@section('content')
  <!-- product details content area  start -->
      <div class="product-details-content-area">
          <div class="container">
              <div class="row">
                  <div class="col-lg-6">
                      <div class="left-content-area"><!-- left content area -->
                          <div class="product-details-slider" id="product-details-slider" data-slider-id="1">
                            @foreach($product->previewimages as $previewimage)
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
                              @foreach($product->previewimages as $previewimage)
                                <li class="owl-thumb-item">
                                    <img src="{{asset('assets/user/img/products/'.$previewimage->image)}}" alt="product details thumb">
                                </li>
                              @endforeach
                          </ul>


                      </div><!-- //.left content area -->
                  </div>

                  <div class="col-lg-6">
                      <div class="right-content-area"><!-- right content area -->
                          <div class="top-content">
                              <ul class="review">
                                  <div class="ratingpro" id="ratingPro{{$product->id}}"></div>
                                 {{--  @if (\App\ProductReview::where('product_id', $product->id)->count() == 0)
                                    <li class="reviewes"><span class="badge badge-danger">Aucun avis</span> </li>
                                  @else
                                    <li class="reviewes">({{\App\ProductReview::where('product_id', $product->id)->count()}} <small>reviews</small>)</li>
                                  @endif --}}
                              </ul>
                              {{-- <span class="orders">Commande ({{$sales}})</span> --}}
                          </div>
                          <form class="bottom-content" id="attrform" enctype="multipart/form-data">
                            {{csrf_field()}}
                              <span class="cat">{{$product->category->name}}</span>
                              <h3 class="title">
                               
                                @if ($product->deleted == 1)
                                  <span class="badge badge-danger">Retirée</span>
                                @endif
                              </h3>
                              <div class="price-area">
                                  <div class="left">
                                      @if (empty($product->prix))
                                        <span class="sprice">{{$gs->base_curr_symbol}} {{round($product->prix, 2)}}</span>
                                      @endif
                                  </div>
                              </div>

                              <ul class="product-spec">
                                  
                                  <li>Sous categorie:  <span class="right">{{$product->subcategory->name}} </span></li>
                                  <li>Type Offre:  <span class="right">{{$product->type_offre}} </span></li>
                                  <li>Pays: <span class="right">{{$product->pays}}</span></li>
                                  <li>Departement: <span class="right">{{$product->departement}}</span></li>
                                  <li>Ville: <span class="right">{{$product->ville}}</span></li>
                                  <li>Etat: <span class="right">{{$product->etat}}</span></li>
                                  <li>Nombre de pièce: <span class="right">{{$product->pîece}}</span></li>
                                  <li>Charge: <span class="right">{{$product->charge}}</span></li>
                                  <li>Etage: <span class="right">{{$product->etage}}</span></li>
                                  <li>Terrain: <span class="right">{{$product->terrain}} m<sup>2</sup></span></li>
                                  <li>Surface: <span class="right">{{$product->surface}}</span></li>
                                  <li>Nombre de chambre: <span class="right">{{$product->chambre}}</span></li>
                                  <li>Chauffage: <span class="right">{{$product->chauffage}}</span></li>
                                  <li>Nombre de salle de bain: <span class="right">{{$product->salle_de_bain}}</span></li>
                              
                                  <li>Nom de l'annonceur:  <span class="right"><a href="{{route('vendor.shoppage', $product->vendor->id)}}" style="color:#{{$gs->base_color_code}};font-weight:700;">{{$product->vendor->shop_name}}</a> </span></li>
                                  <p class="text-danger" id="errattr"></p>
                              </ul>
                              <div class="paction">
                                 {{--  <div class="qty">
                                      <ul>
                                          <li><span class="qttotal" ref="qttotal" id="qttotal">1</span></li>
                                      </ul>
                                  </div> --}}
                                  <ul class="activities">
                                    {{-- @if (Auth::check())
                                      @php
                                        $count = \App\Favorit::where('user_id', Auth::user()->id)->where('product_id', $product->id)->count();
                                      @endphp
                                      @if ($count == 0)
                                        <li><a href="#" onclick="favorit(event, {{$product->id}})"><i id="heart" class="fas fa-heart"></i></a></li>
                                      @else
                                        <li><a href="#" onclick="favorit(event, {{$product->id}})"><i id="heart" class="fas fa-heart red"></i></a></li>
                                      @endif
                                    @else
                                      <li><a href="{{route('login')}}"><i id="heart" class="fas fa-heart"></i></a></li>
                                    @endif --}}
                                  </ul>
                              </div>
                          </form>
                      </div><!-- //. right content area -->
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
                                    <a class="nav-link {{session('success')=='Reviewed successfully'?'active':''}}" id="item-review-tab" data-toggle="tab" href="#item_review" role="tab" aria-controls="item_review" aria-selected="true">Immobilier Similaire</a>
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
                                      @includeif('immobilier.partials.description')
                                  </div>
                              </div>
                              <div class="tab-pane fade {{session('success')=='Reviewed successfully'?'show active':''}}" id="item_review" role="tabpanel" aria-labelledby="item-review-tab">
                                <div class="descr-tab-content">
                                    @includeif('immobilier.partials.comments')
                                </div>
                              </div>
                             {{--  @auth
                                @if (\App\ProductReview::where('user_id', Auth::user()->id)->where('product_id', $product->id)->count() == 0)
                                  @if (\App\Orderedproduct::where('user_id', Auth::user()->id)->where('product_id', $product->id)->where('shipping_status', 2)->count() > 0)
                                    <div class="tab-pane fade" id="write" role="tabpanel" aria-labelledby="write-tab">
                                        <div class="more-feature-content">
                                          @includeif('product.partials.writereview')
                                        </div>
                                    </div>
                                  @endif
                                @endif
                              @endauth --}}
                              <div class="tab-pane fade" id="vendor_info" role="tabpanel" aria-labelledby="item-review-tab">
                                <div class="descr-tab-content">
                                    @includeif('immobilier.partials.vendor_info')
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
                          <li>Immobiliers connexes</li>
                      </ul>
                  </div><!-- //.recently added nav menu -->
              </div>
             
              <div class="col-lg-12">
                  <div class="recently-added-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                    @foreach ($r_immobiliers as $key => $r_immobilier)
                      <div class="single-new-collection-item "><!-- single new collections -->
                          <div class="thumb">
                              <img src="{{asset('assets/user/img/products/'.$r_immobilier->previewimages()->first()->image)}}" alt="new collcetion image">
                              <div class="hover">
                                <a href="{{route('user.immobilier.details', [$r_immobilier->slug, $r_immobilier->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                              </div>
                          </div>
                          
                          <div class="content">
                              <span class="category text-dark font-weight-bold">{{ \App\Category::find($r_immobilier->category_id)->name}}</span>
                              <a href="{{route('user.immobilier.details', [$r_immobilier->slug, $r_immobilier->id])}}"><h4 class="title">{{strlen($r_immobilier->nom) > 25 ? substr($r_immobilier->nom, 0, 25) . '...' : $r_immobilier->nom}}</h4></a>
                              @if (empty($r_immobilier->prix))
                              <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$rproduct->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$rproduct->price}}</del></div>
                              @else
                              <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$r_immobilier->prix}}</span></div>
                              <div class="category bg-primary"><span class="text-white">En {{ $r_immobilier->type_offre }}</span></div>
                              @endif
                          </div>
                      </div><!-- //. single new collections  -->
                    @endforeach
                    <div class="single-new-collection-item ">
                      <div class="view-all-wrapper">
                        <div class="view-all-inner">
                          <a class="view-all-icon-wrapper" href="{{route('user.search', [$product->category_id, $product->subcategory_id])}}">
                            <i class="fa fa-angle-right"></i>
                          </a>
                          <a class="d-block view-all-txt" href="{{route('user.search', [$product->category_id, $product->subcategory_id])}}">Voir tout</a>
                        </div>
                      </div>
                    </div>
                  </div><!-- //. recently added carousel -->
              </div>
          </div>
      </div>
  </div>
  <!-- recently added end -->
@includeif('product.partials.modal_send_message')
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
      var pid = {{$product->id}};
      $.get("{{route('user.avgrating', $product->id)}}", function(data){
        $("#ratingPro"+pid).rateYo({
          rating: data,
          readOnly: true,
          starWidth: "16px"
        });
      });
    });
  </script>

@endpush
