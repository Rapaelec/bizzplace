@extends('layout.master')

@section('title', 'Evenements')

@section('headertxt', 'Gestion des Evenements')

@section('content')
    <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="seller-product-wrapper">
                      <div class="seller-panel">
                          <div class="card-header clearfix">
                                  <h4 style="padding-top: 15px;" class="d-inline-block text-white">VOS EVENEMENTS</h4>
                                  <a href="{{route('vendor.event.create',strTolower($categoris->name))}}" class="boxed-btn float-right">Créer un nouveau</a>
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>Evenement</th>
                                              <th>Nom</th>
                                              <th>Pays</th>
                                              <th>Departement</th>
                                              <th>Ville</th>
                                              <th>Date de creation</th>
                                              <th>&nbsp;</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($evenements as $evenement)
                                          <tr>
                                              <td>
                                                  <div class="single-product-item"><!-- single product item -->
                                                      <div class="thumb">
                                                        <a href="#">
                                                          <img style="width:60px;" src="{{asset('assets/user/img/products/'.(App\Previewimage::where('evenement_id',$evenement->id)->first())->image)}}" alt="seller evenement image">
                                                        </a>
                                                      </div>
                                                      <div class="content">
                                                          <h4 class="title"><a target="_blank" href="#"></a></h4>
                                                      </div>
                                                  </div><!-- //.single product item -->
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $evenement->nom }}
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $evenement->pays }} 
                                              </td>
                                              <td class="padding-top-40">{{ $evenement->departement }}</td>
                                              <td class="padding-top-40">{{ $evenement->ville }}</td>
                                              <td class="padding-top-40">{{ $evenement->created_at }}</td>
                                              <td class="padding-top-40">
                                                  <ul class="action">
                                                      <li><a target="_blank" href="{{route('vendor.event.edit',$evenement->id)}}"><i class="fas fa-pencil-alt"></i></a></li>
                                                      <li class="sp-close-btn"><a href="#" onclick="delEvent(event, {{ $evenement->id}})"><i class="fas fa-times"></i></a></li>
                                                  </ul>
                                              </td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- sellers product content area end -->
@endsection
@push('scripts')
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    });
    function delEvent(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sure ?",
        text: "Une fois supprimée, Toutes les publications associées à cet évènement seront supprimées également!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('vendor.event.delete')}}',
            type: 'POST',
            data: {
              id: pid
            },
            success: function(data) {
              console.log(data);
              if (data == "success") {
                  window.location = '{{url()->current()}}';
              }
            }
          });
        }
      });
    }
  </script>
@endpush