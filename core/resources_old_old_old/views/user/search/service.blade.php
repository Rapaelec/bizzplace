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