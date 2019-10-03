@extends('layout.master')

@section('title', 'Produits')

@if(!empty(Request::route('category')) && !empty(request()->input('term')))
    @section('headertxt')
    Search on {{ \App\Category::find(Request::route('category'))->name}} @if(!empty(Request::route('subcategory'))) <i class="fa fa-arrow-right mx-1"></i> {{\App\Subcategory::find(Request::route('subcategory'))->name}} @endif
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
    <div class="alert text-white" style="background-color:#388385;">
    <form action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}" method="GET">
    <div class="form-group">
      <div class="row">
        <div class="col-md-12">
          <input id="keyword" name="keyword" type="text" placeholder="Recherche par mot clé ..." class="form-control"/>
        </div>
      </div>
    </div>
<div class="row" style="height:25%">
    <div class="col-md-4"  style="padding-top:1%;">
      <label for="categories" ><strong>Categorie</strong></label>
      <select name='categories' class="categories" style="width:100%">
      <option value="">Sélectionner une catégorie</option>
        @foreach ($categories as $categorie)
            <option value="{{ $categorie->true_name }}">{{ $categorie->name }}</option>
        @endforeach
      </select>
    </div>
    <div class="col-md-4"  style="padding-top:1%;">
      <label for="categories"><strong>Pourcentage de reduction</strong></label>
        <input class="form-control" style="height:45%" name="pourcentage_reduct" placeholder=" % (En pourcentage) ">
    </div>
</div>
<div class="row" style="height:25%">
    <div class="col-md-4" style="padding-top:1%;">
      <label for="regions_sect" ><strong>Region</strong></label>
      <select name='regions_sect' class="regions_sect" style="width:100%">
      </select>
    </div>
    <div class="col-md-4" style="padding-top:1%;">
      <label for="departement_sect" ><strong>Département</strong></label>
      <select name='departement_sect' class="departement_sect" style="width:100%;height:150%;">
      </select>
    </div>
    <div class="col-md-4" style="padding-top:1%;">
      <label for="ville_sect" ><strong>Ville</strong></label>
      <select name='ville_sect' class="ville_sect" style="width:100%"></select>
    </div>
</div>
<div class="row mt-2">
  <div class="col-md-4 offset-4">
     <button class="btn btn-lg btn-block" style="margin:auto;font-size:15px;background-color:darkgray;color:white"><strong>Recherche</strong></button>
  </div>
  </div>
  </form>
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
                                <span class="cat">{{ \App\Category::find(Request::route('category'))->name}} @if(!empty(Request::route('subcategory'))) <i class="fa fa-arrow-right mx-1"></i> {{\App\Subcategory::find(Request::route('subcategory'))->name}} @endif</span>
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
                                                <option value="date_asc"  {{$sortby == 'date_asc' ? 'selected' : ''}}>Date: Le plus vieux en haut</option>
                                                
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
                            @php
                               $i=0; 
                            @endphp
                            @foreach ($products as $keys => $product)
                            {{-- {{dump($product[0])}} --}}
                            {{-- {{dump((\App\PreviewImage::where('product_id',$product[0]->id)->first()->product_validate))}} --}}
                            @if(\App\PreviewImage::where('product_id',$product[0]->id)->first()->product_validate == 1)
                            @if (!Request::route('category'))
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
                                      <div class="thumb">
                                        <img src="{{ asset('assets/user/img/shop-logo/'.$product->unique('vendor_id')[0]->vendor->logo) }}" alt="new collcetion image">
                                          <div class="hover"> 
                                          <a href="{{route('user.productdetail.show', ['produits', $product->unique('vendor_id')[0]->vendor->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                        </div>
                                      </div>
                                      <div class="content">
                                          <span class="category" style="color:black;">Boutique</span>
                                          <a class="btn btn-outline-primary" href="{{route('user.productdetail.show', [Illuminate\Support\Str::slug($product->unique('vendor_id')[0]->category->true_name),$product->unique('vendor_id')[0]->vendor->id])}}">Plus d'information</a>
                                          {{-- <a href="{{route('user.product.details', [Illuminate\Support\Str::slug($product->unique('vendor_id')[0]->slug),$product->unique('vendor_id')[0]->vendor->id])}}"><h4 class="title">{{strlen($product->unique('vendor_id')[0]->vendor->title) > 25 ? substr($product->unique('vendor_id')[0]->vendor->title, 0, 25) . '...' : $product->unique('vendor_id')[0]->vendor->title}}</h4></a> --}}
                                      </div>
                                  </div><!-- //. single new collections  -->
                                </div>
                              @else
                              {{-- {{dd($keys)}} --}}
                              {{-- {{dump($product[0]->id)}} --}}
                              {{-- {{dd(\App\PreviewImage::find($product->id)->first()->image)}} --}}
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
                                      <div class="thumb">
                                          <img src="{{asset('assets/user/img/products/'. \App\PreviewImage::where('product_id',$product[0]->id)->first()->image )}}" alt="new collcetion image">
                                          <div class="hover">
                                              <a href="{{route('user.productdetail.show', [$product[0]->slug, $product[0]->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                          </div>
                                      </div>
                                      <div class="content">
                                          <span class="category">{{\App\Category::find($product[0]->category_id)->name}}</span>
                                          <a href="{{route('user.productdetail.show', [$product[0]->slug,$product[0]->id])}}"><h4 class="title">{{strlen($product[0]->title) > 25 ? substr($product[0]->title, 0, 25) . '...' : $product[0]->title}}</h4></a>
                                          @if (empty($product->current_price))
                                            <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product[0]->price}}</span></div>
                                          @else
                                            <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$product[0]->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$product[0]->price}}</del></div>
                                          @endif
                                      </div>
                                  </div><!-- //. single new collections  -->
                                </div>
                              @endif
                              @else
                              
                              @endif
                            @endforeach
                            {{-- {{dd('')}} --}}
                              @foreach ($immobiliers as $key => $immobilier)
                              @if(\App\PreviewImage::where('immobilier_id',$immobilier[0]->id)->first()->product_validate == 1)
                              {{-- {{dd($immobilier)}} --}}
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
                                      <div class="thumb">
                                          <img src="{{ !Request::route('category') ? asset('assets/user/img/shop-logo/'.$immobilier->unique('vendor_id')[0]->vendor->logo) :  asset('assets/user/img/products/'. \App\PreviewImage::where('immobilier_id',$immobilier[0]->id)->first()->image ) }}" alt="new collcetion image">
                                          <div class="hover">
                                              <a href="{{route('user.immobilier.details', [Illuminate\Support\Str::slug($immobilier->unique('vendor_id')[0]->category->true_name), $immobilier->unique('vendor_id')[0]->vendor->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                          </div>
                                      </div>
                                      <div class="content">
                                        <span class="category" style="color:black;">{{ $immobilier[0]->category->name }}</span>
                                        {{-- <a href="{{ route('items.show', [$evenement->unique('vendor_id')[0]->vendor->slug,$evenement->unique('vendor_id')[0]->vendor->id])}}" class="btn btn-outline-primary">Plus d'information</a> --}}
                                        <a class="btn btn-outline-primary" href="{{route('user.immobilier.details', [Illuminate\Support\Str::slug($immobilier->unique('vendor_id')[0]->category->true_name),$immobilier->unique('vendor_id')[0]->vendor->id])}}">Plus d'information</a>
                                        {{-- <a href="{{route('user.immobilier.details', [Illuminate\Support\Str::slug($immobilier->unique('vendor_id')[0]->vendor->slug),$immobilier->unique('vendor_id')[0]->vendor->id])}}"><h4 class="title">{{strlen($immobilier->unique('vendor_id')[0]->nom) > 25 ? substr($immobilier->unique('vendor_id')[0]->nom, 0, 25) . '...' : $immobilier->unique('vendor_id')[0]->nom}}</h4></a> --}}
                                          {{-- @if (empty($immobilier->unique('vendor_id')[0]->vendor->prix))
                                          <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{$immobilier->unique('vendor_id')[0]->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{ $immobilier->unique('vendor_id')[0]->prix }}</del></div>
                                          @else
                                          <div class="price"><span class="sprice">{{$gs->base_curr_symbol}} {{ $immobilier->unique('vendor_id')[0]->prix}}</span></div>
                                          <div class="category bg-primary text-dark"><span class="text-white">En {{ $immobilier->unique('vendor_id')[0]->type_offre }}</span></div>
                                          @endif --}}
                                      </div>
                                  </div><!-- //. single new collections  -->
                                </div>
                               @endif
                              @endforeach
                              @foreach ($r_evenements as $evenement)
                              @if(\App\PreviewImage::where('evenement_id',$evenement[0]->id)->first()->product_validate == 1)
                              <div class="col-lg-4 col-md-6">
                               <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                    <img src="{{ !Request::route('category') ? asset('assets/user/img/shop-logo/'.$evenement->unique('vendor_id')[0]->vendor->logo)  : asset('assets/user/img/products/'. \App\PreviewImage::where('evenement_id',$evenement[0]->id)->first()->image )  }}" alt="nouvelle collection image" class="border">
                                    <div class="hover">
                                      <a href="{{route('user.evenement.details', [Illuminate\Support\Str::slug($evenement->unique('vendor_id')[0]->category->true_name), $evenement->unique('vendor_id')[0]->vendor->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content pt-1">
                                  <div class="row mt-2">
                                    <div class="col-md-12">
                                        <span class="category" style="color:black;">Evenements</span>
                                    </div>
                                  </div>
                                  <div class="row mt-3">
                                    <div class="col-md-12">
                                      <a href="{{ route('user.evenement.details', [Illuminate\Support\Str::slug($evenement->unique('vendor_id')[0]->category->true_name),$evenement->unique('vendor_id')[0]->vendor->id])}}" class="btn btn-outline-primary">Plus d'information</a>
                                    </div>
                                  </div>
                                </div> 
                               </div><!-- //. single new collections  -->
                              </div>
                              @endif
                              @endforeach
                              @foreach ($allcategories as $allcategorie)
                              @if(\App\PreviewImage::where('allcategory_id',$allcategorie[0]->id)->first()->product_validate == 1)
                              <div class="col-lg-4 col-md-6">
                               <div class="single-new-collection-item "><!-- single new collections -->
                                <div class="thumb">
                                  @if(!empty($allcategorie[0]->vendor->logo))
                                    <img src="{{ !Request::route('category') ? asset('assets/user/img/shop-logo/'.$allcategorie->unique('vendor_id')[0]->vendor->logo)  : asset('assets/user/img/products/'. \App\PreviewImage::where('evenement_id',$allcategorie[0]->id)->first()->image ) }}" alt="nouvelle collection image" class="border">
                                  @else
                                  <img src="{{ asset('assets/user/img/shop-logo/1568628250.jpg') }}" alt="nouvelle collection image" class="border">
                                  @endif
                                    <div class="hover">
                                       <a href="{{ route('user.categoryAlldetail.show', [Illuminate\Support\Str::slug($allcategorie->unique('vendor_id')[0]->category->true_name),$allcategorie->unique('vendor_id')[0]->vendor->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                                <div class="content pt-1">
                                  <div class="row mt-2">
                                    <div class="col-md-12">
                                        <span class="category" style="color:black;">{{ App\Category::where('id',$allcategorie[0]->category_id)->first()->name }}</span>
                                    </div>
                                  </div>
                                  <div class="row">
                                    <div class="col-md-12">
                                     <a href="{{ route('user.categoryAlldetail.show', [Illuminate\Support\Str::slug($allcategorie->unique('vendor_id')[0]->category->true_name),$allcategorie->unique('vendor_id')[0]->vendor->id])}}" class="btn btn-outline-primary">Plus d'information</a>
                                    </div>
                                  </div>
                                </div> 
                               </div><!-- //. single new collections  -->
                              </div>
                              @endif
                              @endforeach
                              @foreach ($services as $key => $service)
                              @if(\App\PreviewImage::where('service_id',$service[0]->id)->first()->product_validate == 1)
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
                                    <div class="thumb">
                                        <img src="{{ !Request::route('category') ? asset('assets/user/img/shop-logo/'.$service->unique('vendor_id')[0]->vendor->logo)  : asset('assets/user/img/products/'. \App\PreviewImage::where('service_id',$service[0]->id)->first()->image )  }}" alt="nouvelle collection image">
                                        <div class="hover">
                                          <a href="{{route('user.service.details', [Illuminate\Support\Str::slug($service->unique('vendor_id')[0]->category->true_name), $service->unique('vendor_id')[0]->vendor->id])}}" class="view-btn"><i class="fa fa-eye"></i></a>
                                        </div>
                                    </div>
                                    <div class="content">
                                        <span class="category" style="color:black;">Services</span>
                                        <div class="row">
                                            <div class="col-md-12">
                                                  <a href="{{ route('user.service.details', [Illuminate\Support\Str::slug($service->unique('vendor_id')[0]->category->true_name),$service->unique('vendor_id')[0]->vendor->id])}}" class="btn btn-outline-primary">Plus d'information</a>
                                            </div>
                                        </div>
                                    </div> 
                                </div><!-- //. single new collections  -->
                                </div>
                                @endif
                              @endforeach
                              @php
                                $parameters = ['keyword' => request()->input('keyword'),'region' => request()->input('regions_sect'),'ville' => request()->input('ville_sect'),'departement' => request()->input('departement'),'term' => $term, 'sort_by'=>request()->input('sort_by'), 'type'=>request()->input('type'), 'minprice'=>request()->input('minprice'), 'maxprice' => request()->input('maxprice')];
                              @endphp
                              @if(!empty($reqattrs))
                                  @foreach ($reqattrs as $attrkey => $reqattr)
                                   @if($reqattr!='')
                                    @foreach ($reqattr as $optionkey => $option)
                                      @php
                                        $parameters["$attrkey"][] = $option;
                                      @endphp
                                    @endforeach
                                    @endif
                                  @endforeach
                              @endif
                              <div class="col-md-12">
                                <div class="text-center">
                                    {{-- <!-- {{$products->appends($parameters)->links()}} --> --}}
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
      $('.categories').select2();
      $(".ville_sect").select2({
        placeholder: 'Entrer votre ville',
        language: "fr",
     ajax: {
      url: "{{ route('get.cities') }}",
      dataType: 'JSON',
      delay: 100,
    processResults: function (data) {
    return {
      results:  $.map(data, function (item) {
        return {
                text: item.name,
                id: item.id
            }
        })
    };
  },
  cache: true,
}
    });
  $(".departement_sect").select2({
        placeholder: 'Entrer votre departement',
        language: "fr",
     ajax: {
      url: "{{ route('get.departement') }}",
      dataType: 'JSON',
      delay: 250,
    processResults: function (data) {
    return {
      results:  $.map(data, function (item) {
        return {
                text: item.name,
                id: item.code
            }
        })
    };
  },
  cache: true,
  }
});
      $(".regions_sect").select2({
        placeholder: 'Entrer votre regions',
        language: "fr",
     ajax: {
      url: "{{ route('get.regions') }}",
      dataType: 'JSON',
      delay: 250,
    processResults: function (data) {
    return {
      results:  $.map(data, function (item) {
        return {
                text: item.name,
                id: item.code
            }
        })
    };
  },
  cache: true,
}
});
    $('.departement_sect').on('select2:select', function (e){
    var cod_depart = e.params.data.id;
    $.ajax({
        url:'{{ route('test') }}',
        dataType:'JSON',
        method:'GET',
        data:{
          'cod_depart': cod_depart
        }
    })
    .done(function(data){
      var newOptions='';
      if(cod_depart!=''){
        $.each(data, function(key,value){
         newOptions += '<option value="' + value.id + '">' + value.name + '</option>';
        })
          $('.ville_sect').select2('destroy').html(newOptions).prop("disabled", false).select2();
    }
    })
});
    $('.regions_sect').on('select2:select', function (e){
    var datas = e.params.data.id;
    $.ajax({
        url:'{{ route('get.region.query') }}',
        dataType:'JSON',
        method:'GET',
        data:{
          'cod_region': datas
        }
    })
    .done(function(data){
      var newOptions='';
      if(datas!=''){
        $.each(data, function(key,value){
         newOptions += '<option value="' + value.id + '">' + value.name + '</option>';
        })
          $('.departement_sect').select2('destroy').html(newOptions).prop("disabled", false).select2();
    }
      })
});
      $(document).on('click','.category-btn',function(e) {
        e.preventDefault();
        $('.category-btn').removeClass('base-txt');
        $('.category-btn').next('.subcategories').removeClass('open');
        $(this).toggleClass('base-txt');
        $(this).next('.subcategories').toggleClass('open');
      });
    });

 function myFunction() {
  var x = document.getElementById("fname");
  x.value = x.value.toUpperCase();
}
</script>

  {{-- variables for range slider --}}
  <script>
    var minprice = {{$minprice}};
    var maxprice = {{$maxprice}};
    var curr = '{{$gs->base_curr_symbol}}';
  </script>

  <script src="{{asset('assets/user/js/range-slider.js')}}"></script>
@endsection