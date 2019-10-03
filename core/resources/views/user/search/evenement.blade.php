@foreach ($r_evenements as $evenement)
                              <div class="col-lg-4 col-md-6">
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
                                      <a href="{{ route('user.evenement.details', [$evenement->slug, $evenement->id])}}" class="btn btn-outline-primary">Plus de détail</a>
                                    </div>
                                  </div>
                                </div> 
                               </div><!-- //. single new collections  -->
                              </div>
                              @endforeach