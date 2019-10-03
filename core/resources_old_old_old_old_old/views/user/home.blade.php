@extends('layout.master')

@section('title', 'home')

@section('navbar')
  @includeif('layout.partials.navbar')
@endsection

@section('headerarea')
  @includeif('layout.partials.headerarea')
@endsection

@section('content')
  <div id="home">
    <div class="body-overlay" id="body-overlay"></div>
    <div class="search-popup" id="search-popup">
        <form action="index.html" class="search-popup-form">
            <div class="form-element">
                <input type="text"  class="input-field" placeholder="Recherche .....">
            </div>
            <button type="submit" class="submit-btn"><i class="fas fa-search"></i></button>
        </form>
    </div>

    <!-- feature area home 6 start -->
    <div class="feature-area-home-6">
        <div class="container">
            <div class="row">
              @foreach($ads as $ad)
                <div class="col-lg-4 col-md-6">
                   <div class="img-wrapper">
                        {!! show_ad($ad->size) !!}
                   </div>
                </div>
              @endforeach
            </div>
        </div>
    </div>
    <!-- feature area home 6 end -->

    <div id="flashsaleContainer">
      @if (count($flashsales) > 0)
        <div class="trending-seller-area home-6" id="flashSale">
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header base-bg">
                    <h3 class="text-white">
                    Ventes flash
                      <div class="countdown">
                        <span id="hour" class="time-block base-txt"></span><span>:</span>
                        <span id="mins" class="time-block base-txt"></span><span>:</span>
                        <span id="seconds" class="time-block base-txt"></span>
                      </div>
                    </h3>
                  </div>
                  <div class="card-body">
                    <!-- recently added start -->
                    <div class="recently-added-area home-6" style="padding: 0px;">
                            <div class="row">
                                <div class="col-lg-12">
                                    {{-- already added flash sales --}}
                                    <div class="recently-added-carousel flash-sale-carousel"><!-- recently added carousel -->
                                      @foreach ($flashsales as $key => $flashsale)
                                        <div class="single-new-collection-item"><!-- single new collections -->
                                            <div class="thumb">
                                              <img src="{{asset('assets/user/img/products/'.$flashsale->previewimages()->first()->image->image)}}" alt="nouvelle collection image">
                                              <div class="hover">
                                                <a href="{{route('user.product.details', [$flashsale->slug,$flashsale->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                              </div>
                                              <span class="discount-badge"> -{{$flashsale->flash_type == 0 ? "$gs->base_curr_symbol" : ''}} {{$flashsale->flash_amount}}{{$flashsale->flash_type == 1 ? '%' : ''}}</span>
                                            </div>
                                            <div class="content">
                                                <span class="category">{{$flashsale->category->name}}</span>
                                                <a href="{{route('user.product.details', [$flashsale->slug,$flashsale->id])}}"><h4 class="title">{{strlen($flashsale->title) > 20 ? substr($flashsale->title, 0, 20) . '...' : $flashsale->title}}</h4></a>
                                                @if (empty($flashsale->current_price))
                                                  <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$flashsale->price}}</span></div>
                                                @elseif (!empty($flashsale->current_price))
                                                  <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$flashsale->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$flashsale->price}}</del></div>
                                                @endif
                                            </div>
                                        </div><!-- //. single new collections  -->
                                      @endforeach
                                    </div>
                                </div>
                            </div>
                    <!-- recently added end -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      @endif
    </div>
    <div class="trending-seller-area home-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 ">
                    <div class="home-six-trending-seller-filter"><!-- home six trending seller filter -->
                       <div class="row">
                           <div class="col-lg-12">
                             <div class="card">
                               <div class="card-header base-bg">
                                 <div class="home-six-trending-sellter-filter-nav">
                                         <ul class="nav nav-tabs"  role="tablist">
                                             <li class="nav-item">
                                                 <a class="nav-link active" id="bestseller-tab" data-toggle="tab" href="#bestseller" role="tab" aria-controls="bestseller" aria-selected="true">Meilleures ventes</a>
                                             </li>
                                             <li class="nav-item">
                                                 <a class="nav-link" id="trendeseller-tab" data-toggle="tab" href="#trendeseller" role="tab" aria-controls="trendeseller" aria-selected="false">Les mieux notés</a>
                                             </li>
                                             <li class="nav-item">
                                                 <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Spéciales</a>
                                             </li>
                                         </ul>
                                 </div>
                               </div>
                               <div class="card-body">
                                 <div class="home-six-trending-masonry">
                                         <div class="tab-content" >
                                             <div class="tab-pane fade show active" id="bestseller" role="tabpanel" aria-labelledby="bestseller-tab">
                                                 <div class="row">
                                                   @foreach ($topSoldPros as $key => $topSoldPro)
                                                   @if($topSoldPro->previewimages()->count()>0)
                                                     <div class="col-lg-3 col-md-6">
                                                       <div class="single-new-collection-item "><!-- single new collections -->
                                                           <div class="thumb">
                                                               <img src="{{asset('assets/user/img/products/'.$topSoldPro->previewimages()->first()->image) }}" alt="nouvelle collection image">
                                                               <div class="hover">
                                                                 <a href="{{route('user.productdetail.show', [$topSoldPro->slug, $topSoldPro->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                                               </div>
                                                           </div>
                                                           <div class="content">
                                                               <span class="category">{{ \App\Category::find($topSoldPro->category_id)->name}}</span>
                                                               <a href="{{route('user.productdetail.show', [$topSoldPro->slug, $topSoldPro->id])}}"><h4 class="title">{{strlen($topSoldPro->title) > 20 ? substr($topSoldPro->title, 0, 20) . '...' : $topSoldPro->title}}</h4></a>
                                                               @if (empty($topSoldPro->current_price))
                                                                 <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$topSoldPro->price}}</span></div>
                                                               @else
                                                                 <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$topSoldPro->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$topSoldPro->price}}</del></div>
                                                               @endif
                                                           </div>
                                                       </div><!-- //. single new collections  -->
                                                     </div>
                                                     @endif
                                                   @endforeach
                                                   <div class="col-12 text-center">
                                                     <a class="view-all-products" href="{{url('/shop').'?sort_by=sales_desc'}}">Voir tout <i class="fa fa-angle-right"></i></a>
                                                   </div>
                                                 </div>
                                             </div>
                                             <div class="tab-pane fade" id="trendeseller" role="tabpanel" aria-labelledby="trendeseller-tab">
                                               <div class="row">
                                                  @foreach ($topRatedPros as $key => $topRatedPro)
                                                  @if($topRatedPro->previewimages()->count()>0)
                                                  <div class="col-lg-3 col-md-6">
                                                    <div class="single-new-collection-item "><!-- single new collections -->
                                                        <div class="thumb">
                                                            <img src="{{asset('assets/user/img/products/'.$topRatedPro->previewimages()->first()->image)}}" alt="new collcetion image">
                                                            <div class="hover">
                                                              <a href="{{route('user.product.details', [$topRatedPro->slug, $topRatedPro->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                                            </div>
                                                        </div>
                                                        <div class="content">
                                                            <span class="category">{{\App\Category::find($topRatedPro->category_id)->name}}</span>
                                                            <a href="{{route('user.product.details', [$topRatedPro->slug, $topRatedPro->id])}}"><h4 class="title">{{strlen($topRatedPro->title) > 20 ? substr($topRatedPro->title, 0, 20) . '...' : $topRatedPro->title}}</h4></a>
                                                            @if (empty($topRatedPro->current_price))
                                                              <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$topRatedPro->price}}</span></div>
                                                            @else
                                                              <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$topRatedPro->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$topRatedPro->price}}</del></div>
                                                            @endif
                                                        </div>
                                                    </div><!-- //. single new collections  -->
                                                  </div>
                                                  @endif
                                                @endforeach
                                                 <div class="col-12 text-center">
                                                   <a class="view-all-products" href="{{url('/shop').'?sort_by=rate_desc'}}">Voir tout <i class="fa fa-angle-right"></i></a>
                                                 </div>
                                               </div>
                                             </div>
                                             <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                               <div class="row">
                                                 @foreach ($specialPros as $key => $specialPro)
                                                 @if($specialPro->previewimages()->count()>0)
                                                   <div class="col-lg-3 col-md-6">
                                                     <div class="single-new-collection-item "><!-- single new collections -->
                                                         <div class="thumb">
                                                           
                                                             <img src="{{asset('assets/user/img/products/'.$specialPro->previewimages()->first()->image)}}" alt="nouvelle collection image">
                                                             <div class="hover">
                                                               <a href="{{route('user.product.details', [$specialPro->slug, $specialPro->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                                             </div>
                                                         </div>
                                                         <div class="content">
                                                             <span class="category">{{\App\Category::find($specialPro->category_id)->name}}</span>
                                                             <a href="{{route('user.product.details', [$specialPro->slug, $specialPro->id])}}"><h4 class="title">{{strlen($specialPro->title) > 20 ? substr($specialPro->title, 0, 20) . '...' : $specialPro->title}}</h4></a>
                                                             @if (empty($specialPro->current_price))
                                                               <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$specialPro->price}}</span></div>
                                                             @else
                                                               <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$specialPro->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$specialPro->price}}</del></div>
                                                             @endif
                                                         </div>
                                                     </div><!-- //. single new collections  -->
                                                   </div>
                                                   @endif
                                                 @endforeach
                                                 <div class="col-12 text-center">
                                                   <a class="view-all-products" href="{{url('/shop').'?type=special'}}">Voir tout <i class="fa fa-angle-right"></i></a>
                                                 </div>
                                               </div>
                                             </div>
                                         </div>
                                 </div>
                               </div>
                             </div>
                        </div><!-- //.home six trending seller filter -->
                           </div>
                       </div>
                </div>
            </div>
        </div>
    </div>
    @foreach ($categories as $key => $cat)
      @if ($cat->products()->where('deleted', 0)->count() > 0)
        <!-- recently added start -->
        <div class="recently-added-area home-6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                            <ul>
                              <li>{{$cat->name}}</li>
                            </ul>
                        </div><!-- //.recently added nav menu -->
                    </div>
                    <div class="col-lg-2">
                      <ul class="home-subcategories">
                        @foreach ($cat->subcategories()->where('status', 1)->get() as $key => $subcategory)
                          <li><a href="{{route('user.search', [$cat->id, $subcategory->id])}}">{{$subcategory->name}}</a></li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-lg-10">
                        <div class="recently-added-carousel cat-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                          @foreach ($cat->products()->where('deleted', 0)->orderBy('id', 'DESC')->limit(6)->get() as $key => $product)
                          @if($product->previewimages()->count()>0)
                            <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{asset('assets/user/img/products/'.$product->previewimages()->first()->image)}}" alt="nouvelle collection image">
                                    <div class="hover">
                                      <a href="{{route('user.productdetail.show', [$product->slug, $product->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="category font-weight-bold" style="color:black;">{{\App\Category::find($product->category_id)->name}}</span>
                                    <a href="{{route('user.productdetail.show', [$product->slug, $product->id])}}"><h4 class="title">{{strlen($product->title) > 20 ? substr($product->title, 0, 20) . '...' : $product->title}}</h4></a>
                                    @if (empty($product->current_price))
                                      <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product->price}}</span></div>
                                    @else
                                      <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$product->price}}</del></div>
                                    @endif
                                </div> 
                            </div><!-- //. single new collections  -->
                            @endif
                          @endforeach
                          <div class="single-new-collection-item ">
                            <div class="view-all-wrapper">
                              <div class="view-all-inner">
                                <a class="view-all-icon-wrapper" href="{{route('user.search', $cat->id)}}">
                                  <i class="fa fa-angle-right"></i>
                                </a>
                                <a class="d-block view-all-txt" href="{{route('user.search', $cat->id)}}">Voir tout</a>
                              </div>
                            </div>
                          </div>
                        </div><!-- //. recently added carousel -->
                    </div>
                </div>
            </div>
        </div>
        <!-- recently added end -->
      @endif
      @if ($cat->evenements()->where('deleted', 0)->count() > 0)
        <!-- recently added start -->
        <div class="recently-added-area home-6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                            <ul>
                              <li>{{$cat->name}}</li>
                            </ul>
                        </div><!-- //.recently added nav menu -->
                    </div>
                    <div class="col-lg-2">
                      <ul class="home-subcategories">
                        @foreach ($cat->subcategories()->where('status', 1)->get() as $key => $subcategory)
                          <li><a href="{{route('user.search', [$cat->id, $subcategory->id])}}">{{$subcategory->name}}</a></li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-lg-10">
                        <div class="recently-added-carousel cat-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                          @foreach ($cat->evenements()->where('deleted', 0)->orderBy('id', 'DESC')->limit(6)->get() as $key => $evenement)
                          @if($evenement->previewimages()->count()>0)
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
                                      <a href="{{ route('user.evenement.details', [$evenement->slug, $evenement->id])}}" class="btn btn-outline-success">Plus de detail</a>
                                    </div>
                                  </div>
                                </div> 
                            </div><!-- //. single new collections  -->
                            @endif
                          @endforeach
                          <div class="single-new-collection-item ">
                            <div class="view-all-wrapper">
                              <div class="view-all-inner">
                                <a class="view-all-icon-wrapper" href="{{route('user.search', $cat->id)}}">
                                  <i class="fa fa-angle-right"></i>
                                </a>
                                <a class="d-block view-all-txt" href="{{route('user.search', $cat->id)}}">Voir tout</a>
                              </div>
                            </div>
                          </div>
                        </div><!-- //. recently added carousel -->
                    </div>
                </div>
            </div>
        </div>
        <!-- recently added end -->
      @endif
      @if ($cat->services()->where('deleted', 0)->count() > 0)
        <!-- recently added start -->
        <div class="recently-added-area home-6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                            <ul>
                              <li>{{$cat->name}}</li>
                            </ul>
                        </div><!-- //.recently added nav menu -->
                    </div>
                    <div class="col-lg-2">
                      <ul class="home-subcategories">
                        @foreach ($cat->subcategories()->where('status', 1)->get() as $key => $subcategory)
                          <li><a href="{{route('user.search', [$cat->id, $subcategory->id])}}">{{$subcategory->name}}</a></li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-lg-10">
                        <div class="recently-added-carousel cat-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                          @foreach ($cat->services()->where('deleted', 0)->orderBy('id', 'DESC')->limit(6)->get() as $key => $service)
                          @if($service->previewimages()->count()>0)
                            <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{asset('assets/user/img/products/'.$service->previewimages()->first()->image)}}" alt="nouvelle collection image">
                                    <div class="hover">
                                      <a href="{{route('user.service.details', [$service->slug, $service->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="category" style="color:black;">{{ $service->nom }}</span>
                                    <div class="row">
                                      <div class="col-md-12">
                                      {{ $service->ville}}
                                      <hr>
                                        <div class="price"><span class="sprice">{{$service->promotion}}</span></div>
                                      </div>
                                    </div>
                                </div> 
                            </div><!-- //. single new collections  -->
                            @endif
                          @endforeach
                          <div class="single-new-collection-item ">
                            <div class="view-all-wrapper">
                              <div class="view-all-inner">
                                <a class="view-all-icon-wrapper" href="{{route('user.search', $cat->id)}}">
                                  <i class="fa fa-angle-right"></i>
                                </a>
                                <a class="d-block view-all-txt" href="{{route('user.search', $cat->id)}}">Voir tout</a>
                              </div>
                            </div>
                          </div>
                        </div><!--  recently added carousel -->
                    </div>
                </div>
            </div>
        </div>
        <!-- recently added end -->
      @endif
      @if ($cat->immobiliers()->where('deleted', 0)->count() > 0)
        <!-- recently added start -->
        <div class="recently-added-area home-6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                            <ul>
                              <li>{{$cat->name}}</li>
                            </ul>
                        </div><!-- recently added nav menu -->
                    </div>
                    <div class="col-lg-2">
                      <ul class="home-subcategories">
                        @foreach ($cat->subcategories()->where('status', 1)->get() as $key => $subcategory)
                          <li><a href="{{route('user.search', [$cat->id, $subcategory->id])}}">{{$subcategory->name}}</a></li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-lg-10">
                        <div class="recently-added-carousel cat-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                          @foreach ($cat->immobiliers()->where('deleted', 0)->orderBy('id', 'DESC')->limit(6)->get() as $key => $immobilier)
                          @if($immobilier->previewimages()->count()>0)
                            <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{asset('assets/user/img/products/'.$immobilier->previewimages()->first()->image)}}" alt="nouvelle collection image">
                                    <div class="hover">
                                      <a href="{{ route('user.immobilier.details', [$immobilier->slug, $immobilier->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="category font-weight-bold" style="color:black;">{{\App\Category::find($immobilier->category_id)->name}}</span>
                                    <a href="{{route('user.immobilier.details', [$immobilier->slug, $immobilier->id])}}"><h4 class="title font-weight-bold" style="color:black;">{{strlen($immobilier->nom) > 20 ? substr($immobilier->nom, 0, 20) . '...' : $immobilier->nom}}</h4></a>
                                      <div class="price"><span class="sprice">{{-- {!! $gs->base_curr_symbol !!} --}} {{  $immobilier->prix}} &euro;</span></div>
                                      <div class="category bg-primary"><span class="text-white">En {{ $immobilier->type_offre }}</span></div>
                                </div> 
                            </div><!-- //. single new collections  -->
                            @endif
                          @endforeach
                          <div class="single-new-collection-item ">
                            <div class="view-all-wrapper">
                              <div class="view-all-inner">
                                <a class="view-all-icon-wrapper" href="{{route('user.search', $cat->id)}}">
                                  <i class="fa fa-angle-right"></i>
                                </a>
                                <a class="d-block view-all-txt" href="{{route('user.search', $cat->id)}}">Voir tout</a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- recently added end -->
      @endif
      {{-- @if ($cat->emplois()->where('deleted', 0)->count() > 0)
        <!-- recently added start -->
        <div class="recently-added-area home-6">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                            <ul>
                              <li>{{$cat->name}}</li>
                            </ul>
                        </div><!-- recently added nav menu -->
                    </div>
                    <div class="col-lg-2">
                      <ul class="home-subcategories">
                        @foreach ($cat->subcategories()->where('status', 1)->get() as $key => $subcategory)
                          <li><a href="{{route('user.search', [$cat->id, $subcategory->id])}}">{{$subcategory->name}}</a></li>
                        @endforeach
                      </ul>
                    </div>
                    <div class="col-lg-10">
                        <div class="recently-added-carousel cat-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                          @foreach ($cat->emplois()->where('deleted', 0)->orderBy('id', 'DESC')->limit(6)->get() as $key => $emploi)
                          @if($emploi->previewimages()->count()>0)
                            <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{asset('assets/user/img/products/'.$emploi->previewimages()->first()->image)}}" alt="nouvelle collection image">
                                    <div class="hover">
                                      <a href="{{ route('user.immobilier.details', [$emploi->slug, $emploi->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content">
                                    <span class="category font-weight-bold" style="color:black;">{{\App\Category::find($emplois->category_id)->name}}</span>
                                    <a href="{{route('user.immobilier.details', [$emploi->slug, $emploi->id])}}"><h4 class="title font-weight-bold" style="color:black;">{{strlen($immobilier->nom) > 20 ? substr($immobilier->nom, 0, 20) . '...' : $immobilier->nom}}</h4></a>
                                      <div class="price"><span class="sprice">{{  $emploi->prix}} &euro;</span></div>
                                      <div class="category bg-primary"><span class="text-white">En {{ $immobilier->type_offre }}</span></div>
                                </div> 
                            </div><!-- //. single new collections  -->
                            @endif
                          @endforeach
                          <div class="single-new-collection-item ">
                            <div class="view-all-wrapper">
                              <div class="view-all-inner">
                                <a class="view-all-icon-wrapper" href="{{route('user.search', $cat->id)}}">
                                  <i class="fa fa-angle-right"></i>
                                </a>
                                <a class="d-block view-all-txt" href="{{route('user.search', $cat->id)}}">Voir tout</a>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- recently added end -->
      @endif --}}
    @endforeach
  <!-- recently added start -->
  <div class="recently-added-area home-6">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="recently-added-nav-menu"><!-- recently added nav menu -->
                      <ul>
                          <li>Ajouté recemment</li>
                      </ul>
                  </div><!-- recently added nav menu -->
              </div>
              <div class="col-lg-12">
                  <div class="recently-added-carousel" id="recently-added-carousel"><!-- recently added carousel -->
                    @foreach ($latestPros as $key => $latestPro)
                      @if($latestPro->previewimages()->count())
                      <div class="single-new-collection-item "><!-- single new collections -->
                          <div class="thumb">
                              <img src="{{asset('assets/user/img/products/'.$latestPro->previewimages()->first()->image)}}" alt="nouvelle collection image">
                              <div class="hover">
                                <a href="{{route('user.product.details', [$latestPro->slug,$latestPro->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                              </div>
                          </div>
                          <div class="content">
                              <span class="category">{{\App\Category::find($latestPro->category_id)->name}}</span>
                              <a href="{{route('user.product.details', [$latestPro->slug,$latestPro->id])}}"><h4 class="title">{{strlen($latestPro->title) > 20 ? substr($latestPro->title, 0, 20) . '...' : $latestPro->title}}</h4></a>
                              @if (empty($latestPro->current_price))
                                <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$latestPro->price}}</span></div>
                              @else
                                <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$latestPro->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$latestPro->price}}</del></div>
                              @endif
                          </div>
                      </div><!--  single new collections  -->
                      @endif
                    @endforeach
                    <div class="single-new-collection-item ">
                      <div class="view-all-wrapper" style="height:405px;">
                        <div class="view-all-inner">
                          <a class="view-all-icon-wrapper" href="{{url('/').'/shop?sort_by=date_desc'}}">
                            <i class="fa fa-angle-right"></i>
                          </a>
                          <a class="d-block view-all-txt" href="{{url('/').'/shop?sort_by=date_desc'}}">Voir tout</a>
                        </div>
                      </div>
                    </div>
                  </div><!-- recently added carousel -->
              </div>
          </div>
      </div>
  </div>
  <!-- recently added end -->

  <!-- brand logo carousel area one start -->
  <div class="brand-logo-carousel-area-one">
      <div class="container-fluid">
          <div class="row">
              <div class="col-lg-12">
                  <div class="brand-logo-carousel-one" id="brand-logo-carousel-one"><!-- brand logo carousel one -->
                    @foreach ($partners as $key => $partner)
                      <div class="single-brang-logo-carousel-one-item">
                          <a href="{{$partner->url}}">
                              <img src="{{asset('assets/user/interfaceControl/partners/'.$partner->image)}}" alt="brand logo image">
                          </a>
                      </div>
                    @endforeach
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- brand logo carousel area one end -->
@endsection
@section('js-scripts')
<script>
      var home = new Vue({
        el: '#home',
        data: {

        },
        mounted() {
          this.countdown();
          this.flashsalecheck();
        },
        methods: {
          countdown() {
            // Set the date we're counting down to
            var countDownDate = new Date("{{!empty($countto) ? $countto : ''}}").getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

              // Get todays date and time
              var now = new Date().getTime();

              // Find the distance between now and the count down date
              var distance = countDownDate - now;

              // Time calculations for hours, minutes and seconds
              var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
              var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
              var seconds = Math.floor((distance % (1000 * 60)) / 1000);

              // Output the result in an element with id="demo"
              $("#hour").html(hours < 10 ? '0'+hours : hours);
              $("#mins").html(minutes < 10 ? '0'+minutes : minutes);
              $("#seconds").html(seconds < 10 ? '0'+seconds : seconds);

              // If the count down is over, write some text
              if (distance < 0) {
                clearInterval(x);
              }
            }, 1000);
          },
          flashsalecheck() {
            setInterval(function() {
              $.get("{{route('flashsalecheck')}}", (data) => {
                // console.log(data);
                if (data.status == 1) {
                  window.location = '{{url()->current()}}';
                }
              });
            }, 5000);
          }
        }
      });
</script>
@endsection
