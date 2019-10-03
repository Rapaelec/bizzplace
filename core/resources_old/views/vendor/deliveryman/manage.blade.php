@extends('layout.master')

@section('title', 'Gestions de vos Livreurs')

@section('headertxt', 'Gestions de vos Livreurs')

@push('styles')
<style media="screen">
li.page-item {
  display: inline-block;
}
</style>
@endpush

@section('content')
  <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="seller-product-wrapper">
                      <div class="seller-panel">
                          <div class="card-header clearfix">
                                  <h4 style="padding-top: 15px;" class="d-inline-block text-white">VOS LISTES DE LIVREURS</h4>
                                  <a href="{{route('vendor.deliveryman.create')}}" class="boxed-btn float-right">Nouveau livreur</a>
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>Nom</th>
                                              <th>Téléphone</th>
                                              <th>Email</th>
                                              <th>Lieu de résidence</th>
                                              <th>Poids Colis</th>
                                              <th>Distance</th>
                                              <th>Prix de livraison</th>
                                              <th>Status</th>
                                              <th>Action</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($livreurs as $livreur)
                                      <tr>
                                        <td class="padding-top-40">{{ $livreur->name }}</td>
                                        <td class="padding-top-40">{{ $livreur->phone }}</td>
                                        <td class="padding-top-40">{{ $livreur->email }}</td>
                                        <td class="padding-top-40">{{ $livreur->place_of_residence }}</td>
                                        <td class="padding-top-40">{{ $livreur->command_weight }}</td>
                                        <td class="padding-top-40">{{ $livreur->distance }} km</td>
                                        <td class="padding-top-40">{{ $livreur->delivery_price }} euro</td>
                                        <td class="padding-top-40">
                                          @if($livreur->status==0)
                                              <span class="badge badge-danger">Non actif</span>
                                          @elseif($livreur->status==1)
                                              <span class="badge badge-success">Actif</span>
                                          @endif
                                        </td>
                                        <td class="padding-top-40">
                                        <ul class="action">
                                             <li><a href="{{ route('vendor.deliveryman.edit',$livreur->id) }}"><i class="fas fa-pencil-alt"></i></a></li>
                                             <li class="sp-close-btn"><a href="#" onclick="deldeliveryman(event,{{ $livreur->id }})"><i class="fas fa-times"></i></a></li>
                                        </ul>
                                        </td>
                                      </tr>
                                      @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="text-center">
                                      {{ $livreurs->links()}}
                                  </div>
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
    function deldeliveryman(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sûre de vouloir le supprimer ?",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('vendor.deliveryman.destroy')}}',
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
