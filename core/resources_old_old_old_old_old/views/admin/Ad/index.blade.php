@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Gestion des annonces</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($ads) == 0)
            <div class="tile">
              <div class="">
                <h2 style="display:inline-block;">Liste Annonces</h2>
                <a href="{{route('admin.ad.create')}}" class="float-right btn btn-outline-primary"><i class="fa fa-plus"></i> Nouveau</a>
                <p style="margin:0px;clear:both;"></p>
              </div>
              <hr>
              <h2 class="text-center">Aucune publicité trouvée</h2>
            </div>
          @else
            <div class="tile">
               <h3 class="tile-title float-left">Liste des annonces</h3>
               <a href="{{route('admin.ad.create')}}" class="btn btn-outline-primary float-right"><i class="fa fa-plus"></i> Ajouter un nouveau</a>
               <p style="margin:0px;clear:both;"></p>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">Taille de l'annonce</th>
                           <th scope="col">consulter</th>
                           <th scope="col">Impression</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach ($ads as $ad)
                          <tr>
                             <td data-label="Email">
                               @if ($ad->size == 1)
                                 <h6>350 X 250</h6>
                               @elseif ($ad->size == 2)
                                 <h6>1110 X 460</h6>
                               @elseif ($ad->size == 3)
                                 <h6>255 X 380</h6>
                               @endif
                             </td>
                             <td data-label="Username">
                               @if (empty($ad->views))
                                 0
                               @else
                                 {{$ad->views}}
                               @endif
                             </td>
                             <td data-label="Username">
                               @if (empty($ad->impression))
                                 0
                               @else
                                 {{$ad->impression}}
                               @endif
                             </td>
                             <td data-label="Mobile">
                               <button type="button" class="btn btn-outline-primary" onclick="showImageInModal(event, {{$ad->id}})"><i class="fa fa-eye"></i> Consulter</button>
                               <button type="button" class="btn btn-outline-danger" data-toggle="modal" data-target="#advertise-delete-data{{$ad->id}}"><i class="fa fa-trash"></i> Supprimer</button>
                             </td>
                          </tr>
                          <!--advertise delete modal-->
                          <div class="modal fade" id="advertise-delete-data{{$ad->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <h5 class="modal-title" id="exampleModalLongTitle">Annonce Supprimer</h5>
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <h3 class="text text-danger"><strong>Êtes-vous sûr de supprimer cette publicité?</strong></h3>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                                  <form style="display:inline-block;" action="{{route('admin.ad.delete')}}" method="post">
                                    {{csrf_field()}}
                                    <input type="hidden" name="adID" value="{{$ad->id}}">
                                    <button type="submit" class="btn btn-danger" id="delete_confirm">Confirmation de la suppression</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                          </div>
                        @endforeach
                     </tbody>
                  </table>
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>

  @includeif('admin.Ad.showImageModal')
@endsection

@push('scripts')
  <script>
    function showImageInModal(e, adID) {
      e.preventDefault();
      var fd = new FormData();
      fd.append('adID', adID);
      $.get(
        '{{route('admin.ad.showImage')}}',
        {
          adID: adID,
        },
        function(data) {
          $('#showImageModal').modal('show');
          if (data.script == null) {
            document.getElementById('adImage').style.display = 'block';
            document.getElementById('script').style.display = 'none';
            document.getElementById('adImage').src = '{{asset('assets/user/ad_images')}}'+'/'+data.image;
            alert(document.getElementById('adImage').src);
          }
          if (data.image == null) {
            document.getElementById('script').style.display = 'block';
            document.getElementById('adImage').style.display = 'none';
            document.getElementById('script').innerHTML = data.script;
          }
          console.log(data);
        }
      );
    }
  </script>
@endpush
