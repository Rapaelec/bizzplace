@extends('admin.layout.master')

@push('styles')
<style media="screen">
  h3, h5 {
    margin: 0px;
  }
  .testimonial img {
    height: 100px;
    width: 100px;
    border-radius: 50%;
  }
</style>
@endpush

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1> Section Témoignage Client </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">

          <div class="tile">
            <div class="row">

              <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form role="form" method="POST" action="{{route('admin.testm.testmUpdate')}}">
                    {{ csrf_field() }}
                   <div class="form-group">
                            <label for="testm_title"><strong>Titre de la section de témoignage</strong></label>
                                <input type="text" value="{{$gs->testm_title}}" name="title" class="form-control">
                            </div>
                             <div class="form-group">
                                <label for="testm_details"><strong>Détails du témoignage</strong></label>
                               <input name="details" class="form-control" value="{{$gs->testm_details}}">
                            </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-lg btn-success btn-block" >Mettre à jour</button>
                    </div>
                </form>
              </div>

            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header bg-primary">
                    <h5 style="color:white;display:inline-block;">TÉMOIGNAGES</h5>
                    <button type="button" class="btn btn-sm btn-default float-right" data-toggle="modal" data-target="#addtest">
                      <i class="fa fa-plus"></i>
                        Nouveau témoignage
                    </button>
                  </div>
                  <div class="card-body">
                      @if (count($testims) == 0)
                        <h3 class="text-center"> PAS DE TÉMOIGNAGE TROUVÉ</h3>
                      @else
                        @foreach ($testims as $testim)
                          @if ($loop->iteration % 3 == 1)
                          <div class="row"> {{-- .row start --}}
                          @endif
                          <div class="col-md-4">
                            <div class="card testimonial">
                              <div class="card-header bg-primary">
                                <h5 style="color:white">Testimonial</h5>
                              </div>
                              <div class="card-body text-center">
                                <img src="{{asset('assets/user/interfaceControl/testimonial/'.$testim->image)}}" alt="">

                                <h3 style="margin-top:20px;">{{$testim->name}}</h3>
                                <p>{{$testim->company}}</p>
                                <p>
                                  "{{$testim->comment}}"
                                </p>
                              </div>
                              <div class="card-footer text-center">
                                <button style="color:white;" type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#edittest{{$testim->id}}">
                                  <i class="fa fa-pencil-square"></i>
                                  Editer
                                </button>
                                <form action="{{route('admin.testim.destroy')}}" method="POST" style="display: inline-block;">
                               {{csrf_field()}}
                               {{-- {{ method_field('DELETE') }} --}}
                               <input type="hidden" name="testimID" value="{{$testim->id}}">
                               <button style="color:white;" type="submit" class="btn btn-danger btn-sm" name="button">
                                 <i class="fa fa-trash"></i>
                                 Supprimer
                               </button>
                             </form>

                              </div>
                            </div>
                          </div>
                          @if ($loop->iteration % 3 == 0)
                          </div> {{-- .row end --}}
                          <br>
                          @endif

                          <!-- Edit Modal -->
                          <div class="modal fade" id="edittest{{$testim->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalCenterTitle">Editer Témoignage {{$testim->name}}</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <form role="form" method="POST" action="{{route('admin.testim.update',$testim)}}" enctype="multipart/form-data">
                                   {{ csrf_field() }}
                                      <div class="form-group">
                                         <div class="fileinput fileinput-new" data-provides="fileinput">
                                          <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('assets/user/interfaceControl/testimonial') }}/{{$testim->image}}" alt="" /> </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 80px; max-height: 80px;"> </div>
                                            <div>
                                              <span class="btn btn-success btn-file">
                                                <span class="fileinput-new"> Changer Image </span>
                                                <span class="fileinput-exists"> Changer </span>
                                                <input type="file" name="photo"> </span>
                                                <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Supprimer </a>
                                              </div>
                                            </div>
                                      </div>
                                  <div class="form-group">
                                      <label for="name">Nom</label>
                                      <input type="text" class="form-control" value="{{$testim->name}}" id="name" name="name" >
                                  </div>
                                  <div class="form-group">
                                      <label for="company">Compagnie</label>
                                      <input type="text" class="form-control" value="{{$testim->company}}"  id="company" name="company" >
                                  </div>
                                  <div class="form-group">
                                      <label for="comment" >Commentaire</label>
                                      <input type="text" name="comment" value="{{$testim->comment}}" class="form-control">
                                  </div>
                                      <div class="form-group">
                                          <button type="submit" class="btn btn-lg btn-block btn-success" >Mettre à jour</button>
                                      </div>
                                  </form>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                      @endif

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
     </div>
  </main>

  <!-- Add Modal -->
  <div class="modal fade" id="addtest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalCenterTitle">Ajouter nouveau témoignage</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form role="form" method="POST" action="{{route('admin.testim.store')}}" enctype="multipart/form-data">
           {{ csrf_field() }}
              <div class="form-group">
              <div class="fileinput fileinput-new" data-provides="fileinput">
              <div class="fileinput-new thumbnail">
                <img src="http://via.placeholder.com/100X100" alt="" /> </div>
                <div class="fileinput-preview fileinput-exists thumbnail" style="max-width: 80px; max-height: 80px;"> </div>
                <div>
                  <span class="btn btn-success btn-file">
                    <span class="fileinput-new"> Changer Image </span>
                    <span class="fileinput-exists"> Changer</span>
                    <input type="file" name="photo"> </span>
                    <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Supprimer </a>
                  </div>
                </div>
              </div>
              <div class="form-group">
                  <label for="name">Nom</label>
                  <input type="text" class="form-control" id="name" name="name" >
              </div>
              <div class="form-group">
                  <label for="company">Compagnie</label>
                  <input type="text" class="form-control" id="company" name="company" >
              </div>
              <div class="form-group">
                  <label for="comment" >Commentaire</label>
                  <textarea class="form-control" name="comment" rows="5" cols="80"></textarea>
              </div>
              <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-success btn-block" >Enregistrer</button>
              </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>
@endsection
