@extends('layout.master')

@section('title', 'Produits')

@if(!empty(Request::route('category')) && !empty(request()->input('term')))
    @section('headertxt')
    Recherche sur {{\App\Category::find(Request::route('category'))->name}} @if(!empty(Request::route('subcategory'))) <i class="fa fa-arrow-right mx-1"></i> {{\App\Subcategory::find(Request::route('subcategory'))->name}} @endif
    @endsection
@elseif(!empty(Request::route('category')) && empty(request()->input('term')))
    @section('headertxt')
    {{ (\App\Category::find(Request::route('category'))->name) ?? '' }} @if(!empty(Request::route('subcategory'))) <i class="fa fa-arrow-right mx-1"></i> {{\App\Subcategory::find(Request::route('subcategory'))->name}} @endif
    @endsection
@elseif(empty(Request::route('category')) && !empty(request()->input('term')))  
    @section('headertxt')
    Recherche sur Shop
    @endsection
@else
    @section('headertxt')
    Recherche page
    @endsection
@endif


@push('styles')
<style media="screen">
  ul.subcategories {
      padding-left: 20px;
      display: none;
  }
  ul.subcategories.open {
    display: block;
  }
  .category-btn {
      display: block;
  }
  .subcategories a {
      display: block;
      cursor: pointer;
  }
  .js-input-from.form-control, .js-input-to.form-control {
      width: 24%;
  }

  .js-input-from.form-control {
      margin-right: 4%;
  }

  .category-content-area .category-compare {
      padding: 20px;
  }
  li.page-item {
      display: inline-block;
  }

  ul.pagination {
      width: 100%;
  }
</style>
<link rel="stylesheet" href="{{asset('assets/user/css/range-slider.css')}}">
@endpush

@section('content')
  <!-- category content area start -->
  <div class="category-content-area search-page">
  @include('user.menu_sousheader')
  <div class="container">
    <div class="row">
      @isset($counts)
      <div class="col-md-12 col-xs-12 col-lg-12 col-sm-12">
        <div class="alert text-white" style="background-color:#388385;">
          <strong>Resultat du filtre: {{ $counts }} {{ $counts >1 ? 'éléments' : 'élément' }} {{ str_plural('trouvé',$counts) }}</strong>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      </div>
      @endisset
    </div>
    <div class="row mb-4 mb-5;;" style="height:25%">
      <div class="col-md-3" style="padding-left:13%">
       <strong class="mr-0" style="font-size:15px;color:aliceblue">Recherche par : </strong>
    </div>
    <div class="col-md-3 {{ $items=='products' ? '' : 'offset-md-1' }}">
      <form class="wrapper" id="departement" action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}">
      <input type="hidden" name="departement" class="departement" value="{{ request()->input('departement') }}">
      <select name='departement' class="js-data-example-ajax" onchange="document.getElementById('departement').submit()">
        <option selected disabled>Choix Département</option>
        @foreach($departements as $departement)
        <option  value="{{ $departement['name'] }}">{{ $departement['name'] }}</option>
        @endforeach
      </select>
    </form>
    </div>
  <div class="col-md-3 {{ $items=='products' ? '' : 'offset-md-1' }}">
      <form class="wrapper" id="localite" action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}">
        <input type="hidden" name="localite" class="localite" value="{{ request()->input('localite') }}">
       <select name="localite" class="selectpicker input-field select" onchange="document.getElementById('localite').submit()">
          <option value="" selected disabled>Choix localité</option>
          @foreach($localites as $localite)
          <option value="{{ $localite['name'] }}">{{ $localite['name'] }}</option>
          @endforeach
       </select>
      </form>
  </div>
  @if($items=='products')
  <div class="col-md-3">
    <form class="wrapper" id="region" action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}">
      <input type="hidden" name="region" class="region" value="{{ request()->input('region') }}">
       <select name="region" class="selectpicker input-field select" onchange="document.getElementById('region').submit()">
          <option value="" selected disabled>Choix Region</option>
          @foreach($regions as $region )
          <option value="{{ $region['name'] }}">{{ $region['name'] }}</option>
          @endforeach
       </select>
    </form>
  </div>
  @endif
    </div>
  </div>
      <div class="container">
          <div class="row">
              <div class="col-lg-3">
                  <div class="category-sidebar"><!-- category sidebar -->
                      <div class="category-filter-widget"><!-- category-filter-widget -->
                        <div class="sidebar-header">
                          <h4>Categories</h4>
                        </div>
                          <ul class="cat-list">
                            <li>
                              <a href="{{url('/').'/shop'}}" class="{{!Request::route('category') ? 'base-txt' : '' }}">TOUS CATEGORIES </a>
                            </li>
                            @foreach ($categories as $key => $category)
                              <li>
                                <a href="#" class="category-btn {{Request::route('category') == $category->id ? 'base-txt' : '' }}">{{$category->name}} <span class="right"><i class="fa fa-caret-down"></i></span></a>
                                <ul class="subcategories {{Request::route('category') == $category->id ? 'open' : '' }}">
                                  @foreach ($category->subcategories()->where('status', 1)->get() as $key => $subcategory)
                                    <li><a href="{{route('user.search', [$category->id, $subcategory->id])}}" class="{{Request::route('subcategory') == $subcategory->id ? 'base-txt' : '' }}">{{$subcategory->name}}</a></li>
                                  @endforeach
                                </ul>
                              </li>
                            @endforeach
                          </ul>
                      </div><!-- //.category-filter-widget -->
                  </div><!-- //. category sidebar -->
                  @if($items=='products')
                  <div class="category-compare margin-bottom-30">
                     <div class="sidebar-header">
                        <h4>Filtres</h4>
                     </div>
                     <div class="">
                        <form class="wrapper" action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}">
                          <input type="hidden" name="sort_by" value="{{request()->input('sort_by')}}">
                          <input type="hidden" name="type" value="{{request()->input('type')}}">
                          <input type="hidden" name="term" value="{{request()->input('term')}}">
                          <p style="margin-bottom: 5px;"><strong>Prix</strong></p>
                           <div class="range-slider">
                              <input type="text" class="js-range-slider" value="" />
                           </div>
                           <div class="extra-controls form-inline">
                              <div class="form-group">
                                <div class="row">
                                 <input id="minprice" name="minprice" type="text" class="js-input-from form-control" value="0" />
                                 <input id="maxprice" name="maxprice" type="text" class="js-input-to form-control" value="0" />
                                </div>
                              </div>
                           </div>
                           @if (Request::route('subcategory'))
                             @if (\App\Subcategory::find(Request::route('subcategory'))->attributes != '[]')
                               @php
                                 $attrs = \App\Subcategory::find(Request::route('subcategory'))->attributes;
                                 $arrattr = json_decode($attrs, true);

                                 $attributes = \App\ProductAttribute::whereIn('id', $arrattr['attributes'])->get();
                               @endphp
                               @foreach ($attributes as $attribute)
                                 <p style="margin-bottom: 5px;"><strong>{{$attribute->name}}</strong></p>
                                 @foreach (\App\Option::where('product_attribute_id', $attribute->id)->get() as $key => $option)
                                   <div class="form-check">
                                     <input name="{{$attribute->attrname}}[]" class="form-check-input" type="checkbox" value="{{$option->name}}" id="defaultCheck{{$option->id}}" @if(array_key_exists("$attribute->attrname", $reqattrs)) {{in_array($option->name, $reqattrs["$attribute->attrname"]) ? 'checked' : ''}}  @endif>
                                     <label class="form-check-label" for="defaultCheck{{$option->id}}">
                                       {{$option->name}}
                                     </label>
                                   </div>
                                 @endforeach
                               @endforeach
                             @endif
                          @endif
                           <div class="text-right pt-2">
                             <button type="submit" class="btn btn-sm btn-warning">Appliquer</button>
                           </div>
                        </form>
                     </div>
                  </div>
                  @else
                  <div class="category-compare margin-bottom-30">
                     <div class="sidebar-header">
                        <h4>Recherche</h4>
                     </div>
                     <div class="">
                        <form class="wrapper" action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}">
                          <p style="margin-bottom: 5px;"><strong>Mot clé</strong></p>
                           <div class="extra-controls form-inline">
                              <div class="form-group">
                                <div class="row">
                                  <div class="col-md-12">
                                    <input id="keyword" name="keyword" type="text" placeholder="Recherche par mot clé ..." class="form-control"/>
                                  </div>
                                </div>
                              </div>
                           </div>
                           <div class="text-right pt-2">
                             <button type="submit" class="btn btn-sm btn-primary">Recherche</button>
                           </div>
                        </form>
                     </div>
                  </div>
                  @endif
                  <div class="banner-img">
                      {!! show_ad(3) !!}
                  </div>
              </div>
              <div class="col-lg-9">
                  <div class="right-content-area"><!-- right content area -->
                      <div class="top-content"><!-- top content -->
                          {{-- @if (Request::route('category')) --}}
                            <div class="left-conent">
                              @if (Request::route('category'))
                                <span class="cat">{{\App\Category::find(Request::route('category'))->name}} @if(!empty(Request::route('subcategory'))) <i class="fa fa-arrow-right mx-1"></i> {{\App\Subcategory::find(Request::route('subcategory'))->name}} @endif</span>
                              @else
                                <span class="cat">TOUS CATEGORIES</span>
                              @endif
                            </div>
                          <div class="right-content">
                              <ul>
                                  <li>
                                      <div class="form-element has-icon">
                                          <form id="sortForm" action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}">
                                            <input type="hidden" name="minprice" value="{{request()->input('minprice')}}">
                                            <input type="hidden" name="maxprice" value="{{request()->input('maxprice')}}">
                                            <input type="hidden" name="type" value="{{request()->input('type')}}">
                                            @if (Request::route('subcategory'))
                                              @if (\App\Subcategory::find(Request::route('subcategory'))->attributes != '[]')
                                                @php
                                                  $attrs = \App\Subcategory::find(Request::route('subcategory'))->attributes;
                                                  $arrattr = json_decode($attrs, true);

                                                  $attributes = \App\ProductAttribute::whereIn('id', $arrattr['attributes'])->get();
                                                @endphp
                                                @foreach ($attributes as $attribute)
                                                  @foreach (\App\Option::where('product_attribute_id', $attribute->id)->get() as $key => $option)
                                                    <div class="form-check" style="display: none;">
                                                      <input name="{{$attribute->attrname}}[]" class="form-check-input" type="checkbox" value="{{$option->name}}" id="defaultCheck{{$option->id}}" @if(array_key_exists("$attribute->attrname", $reqattrs)) {{in_array($option->name, $reqattrs["$attribute->attrname"]) ? 'checked' : ''}}  @endif>
                                                      <label class="form-check-label" for="defaultCheck{{$option->id}}">
                                                        {{$option->name}}
                                                      </label>
                                                    </div>
                                                  @endforeach
                                                @endforeach
                                              @endif
                                            @endif
                                            <select name="sort_by" class="selectpicker input-field select" onchange="document.getElementById('sortForm').submit()">
                                                <option value="" selected disabled>Trier par</option>
                                                <option value="date_desc" {{$sortby == 'date_desc' ? 'selected' : ''}}>Date: Le plus récent</option>
                                                <option value="date_asc" {{$sortby == 'date_asc' ? 'selected' : ''}}>Date: Le plus vieux en haut</option>
                                            </select>
                                          </form>
                                          <div class="the-icon">
                                                  <i class="fas fa-angle-down"></i>
                                          </div>
                                      </div>
                                  </li>
                              </ul>
                          </div>
                      </div><!-- //. top content -->
                      <div class="bottom-content"><!-- top content -->
                          <div class="row">
                            @if (count($products) == 0 and count($immobiliers)==0 and count($services)==0 and count($r_evenements)==0)
                              <div class="col-md-12 text-center">
                                <h4>Pas d'élément trouvé</h4>
                              </div>
                            @else
                              @foreach ($products as $key => $product)
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
                                  <span class="badge badge-info mb-1" style="margin-left: 65%; font-size: 91%;"><i class="fa fa-eye"></i> Vues {{$product->number_views}}</span>  
                                    <div class="thumb">
                                          <img src="{{asset('assets/user/img/products/'.$product->previewimages()->first()->image)}}" alt="new collcetion image">
                                          <div class="hover">
                                              <a href="{{route('user.product.details', [$product->slug, $product->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                          </div>
                                      </div>
                                      <div class="content">
                                          <span class="category">{{\App\Category::find($product->category_id)->name}}</span>
                                          <a href="{{route('user.product.details', [$product->slug,$product->id])}}"><h4 class="title">{{strlen($product->title) > 25 ? substr($product->title, 0, 25) . '...' : $product->title}}</h4></a>
                                          @if (empty($product->current_price))
                                            <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product->price}}</span></div>
                                          @else
                                            <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$product->price}}</del></div>
                                          @endif
                                      </div>
                                  </div><!-- //. single new collections  -->
                                </div>
                                @endforeach
                              @foreach ($immobiliers as $key => $immobilier)
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
                                      <div class="thumb">
                                          <img src="{{asset('assets/user/img/products/'.$immobilier->previewimages()->first()->image)}}" alt="new collcetion image">
                                          <div class="hover">
                                              <a href="{{route('user.immobilier.details', [$immobilier->slug, $immobilier->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                          </div>
                                      </div>
                                      <div class="content">
                                          <span class="category text-dark font-weight-bold" >{{\App\Category::find($immobilier->category_id)->name}}</span>
                                          <a href="{{route('user.immobilier.details', [$immobilier->slug,$immobilier->id])}}"><h4 class="title">{{strlen($immobilier->nom) > 25 ? substr($immobilier->nom, 0, 25) . '...' : $immobilier->nom}}</h4></a>
                                          @if (empty($immobilier->prix))
                                          <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$product->price}}</del></div>
                                          @else
                                          <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$immobilier->prix}}</span></div>
                                          <div class="category bg-primary text-dark"><span class="text-white">En {{ $immobilier->type_offre }}</span></div>
                                          @endif
                                      </div>
                                  </div><!-- //. single new collections  -->
                                </div>
                              @endforeach
                              @foreach ($r_evenements as $evenement)
                              <div class="col-lg-4 col-md-6">
                               <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{ asset('assets/user/img/shop-logo/'.$evenement->vendor->logo) }}" alt="nouvelle collection image" class="border">
                                    <div class="hover">
                                      <a href="{{route('user.evenement.details', [$evenement->slug, $evenement->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content pt-1">
                                  <div class="row mt-2">
                                    <div class="col-md-12">
                                      <span class="font-weight-bold">
                                      {{ $evenement->vendor->description }}
                                      </span>
                                    </div>
                                  </div>
                                  <div class="row mt-3">
                                    <div class="col-md-12">
                                      <a href="{{ route('user.evenement.details', [$evenement->slug, $evenement->id])}}" class="btn btn-outline-primary">Plus d'information</a>
                                    </div>
                                  </div>
                                </div> 
                               </div><!-- //. single new collections  -->
                              </div>
                              @endforeach
                              @foreach ($services as $key => $service)
                                <div class="col-lg-4 col-md-6">
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
                                </div>
                              @endforeach
                              @php
                                $parameters = ['keyword' => request()->input('keyword'),'region' => request()->input('region'),'localite' => request()->input('localite'),'departement' => request()->input('departement'),'term' => $term, 'sort_by'=>request()->input('sort_by'), 'type'=>request()->input('type'), 'minprice'=>request()->input('minprice'), 'maxprice' => request()->input('maxprice')];
                              @endphp
                              @if(!empty($reqattrs))
                                  @foreach ($reqattrs as $attrkey => $reqattr)
                                    @foreach ($reqattr as $optionkey => $option)
                                      @php
                                        $parameters["$attrkey"][] = $option;
                                      @endphp
                                    @endforeach
                                  @endforeach
                              @endif
                              <div class="col-md-12">
                                <div class="text-center">
                                    {{$products->appends($parameters)->links()}}
                                </div>
                              </div>
                            @endif
                          </div>


                      </div><!-- //.top content -->
                  </div><!-- //. right content area -->
              </div>
          </div>
      </div>
  </div>
  <!-- category content area end -->

@endsection


@section('js-scripts')
  <script>
    $(document).ready(function() {
      $(document).on('click','.category-btn',function(e) {
        e.preventDefault();

        $('.category-btn').removeClass('base-txt');
        $('.category-btn').next('.subcategories').removeClass('open');

        $(this).toggleClass('base-txt');
        $(this).next('.subcategories').toggleClass('open');

      });
    });
  </script>

  {{-- variables for range slider --}}
  <script>
    var minprice = {{$minprice}};
    var maxprice = {{$maxprice}};
    var curr = '{{$gs->base_curr_symbol}}';
  </script>

  <script src="{{asset('assets/user/js/range-slider.js')}}"></script>
@endsection
