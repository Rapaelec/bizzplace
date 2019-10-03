@extends('layout.master')

@section('title', $evenements->nom)

@section('headertxt', 'Detail Evenement')

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
                            @foreach($evenements->previewimages as $previewimage)
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
                              @foreach($evenements->previewimages as $previewimage)
                                <li class="owl-thumb-item">
                                    <img src="{{asset('assets/user/img/products/'.$previewimage->image)}}" alt="product details thumb">
                                </li>
                              @endforeach
                          </ul>
                      </div><!-- //.left content area -->
                  </div>
                  <div class="col-lg-6">
                      <div class="right-content-area" style="margin-top:50%;margin-left:5%"><!-- right content area -->
                          {{-- <a href="#" class="btn btn-outline-success">Contacter l'organisateur</a> --}}
                          <a href="{{ $evenements->site_prest }}" class="btn btn-outline-primary">Visiter le site de l'organisateur</a>
                      </div>
                      <!-- //. right content area -->
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
                                    <a class="nav-link {{session('success')=='Reviewed successfully'?'active':''}}" id="item-review-tab" data-toggle="tab" href="#item_review" role="tab" aria-controls="item_review" aria-selected="true">Evenement Similaire</a>
                                  </li>
                                  <li class="nav-item">
                                    <a class="nav-link" id="item-review-tab" data-toggle="tab" href="#vendor_info" role="tab" aria-controls="item_review" aria-selected="true">Information Annonceur</a>
                                  </li>
                              </ul>
                          </div>
                            <div class="tab-content" >
                              <div class="tab-pane fade {{session('success')=='Reviewed successfully'?'':'show active'}}" id="descr" role="tabpanel" aria-labelledby="descr-tab">
                                  <div class="descr-tab-content">
                                      @includeif('evenement.partials.description')
                                  </div>
                              </div>
                              <div class="tab-pane fade {{session('success')=='Reviewed successfully'?'show active':''}}" id="item_review" role="tabpanel" aria-labelledby="item-review-tab">
                                <div class="descr-tab-content">
                                    @includeif('evenement.partials.comments')
                                </div>
                              </div>
                              <div class="tab-pane fade" id="vendor_info" role="tabpanel" aria-labelledby="item-review-tab">
                                <div class="descr-tab-content">
                                    @includeif('evenement.partials.vendor_info')
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
                          <li>Evenements connexes</li>
                      </ul>
                  </div><!-- //.recently added nav menu -->
              </div>
              <div class="col-lg-12">
                  <div class="recently-added-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                    @foreach ($r_evenements as $key => $evenement)
                      <div class="single-new-collection-item "><!-- single new collections -->
                        <div class="thumb">
                            <img src="{{asset('assets/user/img/products/'.$evenement->previewimages()->first()->image)}}" alt="nouvelle collection image" class="border">
                            <div class="hover">
                              <a href="{{route('user.evenement.details', [$evenement->slug, $evenement->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                            </div>
                        </div>
                        <div class="content pt-1">
                          <div class="row mt-0">
                            <div class="col-md-12">
                              <span class="font-weight-bold"><u>Date</u></span><br>
                              <span class="font-weight-bold">Du </span> <span class="right">{{ $evenement->date_deb }} au {{ $evenement->date_fin }}</span>
                            </div>
                          </div>
                          <div class="row mt-2">
                            <div class="col-md-12">
                              <span class="font-weight-bold"><u>Lieu</u></span><br>
                              <span class="font-weight-bold">A </span> <span class="right">{{ $evenement->ville }}</span>
                            </div>
                          </div>
                          <div class="row mt-3">
                            <div class="col-md-12">
                              <a href="{{ route('user.evenement.details', [$evenement->slug, $evenement->id])}}" class="btn btn-outline-primary">Plus de detail</a>
                            </div>
                          </div>
                        </div> 
                      </div><!-- //. single new collections  -->
                    @endforeach
                    <div class="single-new-collection-item ">
                      <div class="view-all-wrapper">
                        <div class="view-all-inner">
                          <a class="view-all-icon-wrapper" href="{{route('user.search', [$evenements->category_id, $evenements->subcategory_id])}}">
                            <i class="fa fa-angle-right"></i>
                          </a>
                          <a class="d-block view-all-txt" href="{{route('user.search', [$evenements->category_id, $evenements->subcategory_id])}}">Voir tout</a>
                        </div>
                      </div>
                    </div>
                  </div><!-- //. recently added carousel -->
              </div>
          </div>
      </div>
  </div>
  <!-- recently added end -->
@includeif('evenements.partials.modal_send_message')
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
      var pid = {{$evenements->id}};
      $.get("{{route('user.avgrating', $evenements->id)}}", function(data){
        $("#ratingPro"+pid).rateYo({
          rating: data,
          readOnly: true,
          starWidth: "16px"
        });
      });
    });
  </script>

@endpush
