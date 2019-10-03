<div class="row">
                          @include('user.search.product')
                            @if (count($products) == 0 and count($immobiliers)==0 and count($services)==0 and count($r_evenements)==0)
                              <div class="col-md-12 text-center">
                                <h4>Pas d'élément trouvé</h4>
                              </div>
                            @else
                              @foreach ($products as $key => $product)
                                <div class="col-lg-4 col-md-6">
                                  <div class="single-new-collection-item "><!-- single new collections -->
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
                              @include('user.search.immobilier')
                              @include('user.search.evenement')
                              @include('user.search.service')
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