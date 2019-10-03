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