@extends('admin.layout.master')


@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h3 class="page-title uppercase bold">
             @if (request()->path() == 'admin/refunds/all')
               Tous
             @elseif (request()->path() == 'admin/refunds/pending')
               En attente
             @elseif (request()->path() == 'admin/refunds/accepted')
               Accepté
             @elseif (request()->path() == 'admin/refunds/rejected')
               Rejecté
             @endif
                 Demandes
           </h3>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Tableau de bord</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
            <div class="tile">
              @if (count($refunds) == 0)
                <h1 class="text-center">AUCUNE DONNÉE DISPONIBLE !</h1>
              @else
                <table class="table table-bordered" style="width:100%;">
                  <thead>
                    <tr>
                      <th>Nom d'utilisateur</th>
                      <th>Téléphone client</th>
                      <th>Email client</th>
                      <th>Nom de la boutique</th>
                      <th>Téléphone du vendeur</th>
                      <th>Email du vendeur</th>
                      <th>Produit Titre</th>
                      <th>Argent à retourner</th>
                      <th>Raison</th>
                      <th>Date de commande</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($refunds as $key => $refund)
                      <tr>
                        <td><a href="{{route('admin.userDetails', $refund->orderedproduct->user_id)}}">{{$refund->orderedproduct->user->username}}</a></td>
                        <td>{{$refund->orderedproduct->user->phone}}</td>
                        <td>{{$refund->orderedproduct->user->email}}</td>
                        <td><a href="{{route('admin.vendorDetails', $refund->orderedproduct->vendor_id)}}">{{$refund->orderedproduct->vendor->shop_name}}</a></td>
                        <td>{{$refund->orderedproduct->vendor->phone}}</td>
                        <td>{{$refund->orderedproduct->vendor->email}}</td>
                        <td><a href="{{route('user.product.details', [$refund->orderedproduct->product->slug, $refund->orderedproduct->product->id])}}">{{$refund->orderedproduct->product->title}}</a></td>
                        <td>{{$gs->base_curr_symbol}} {{$refund->orderedproduct->product_total}}</td>
                        <td>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#refundModal{{$refund->id}}">Raison</button>
                        </td>
                        <td>{{date('j F, Y', strtotime($refund->orderedproduct->created_at))}}</td>
                        <td>
                          @if ($refund->status == 0)
                            <a href="#" title="Accept Request" onclick="accept(event, {{$refund->id}})" style="font-size: 20px;margin-right: 5px;">
                              <i class="fa fa-check-circle text-success"></i>
                            </a>
                            <a href="#" title="Reject Request" onclick="reject(event, {{$refund->id}})" style="font-size: 20px;">
                              <i class="fa fa-times-circle text-danger"></i>
                            </a>
                          @elseif ($refund->status == 1)
                            <span class="badge badge-success">Accepté</span>
                          @elseif ($refund->status == -1)
                            <span class="badge badge-danger">Rejecté</span>
                          @endif

                        </td>
                      </tr>

                      <!-- Reason Modal -->
                      <div class="modal fade" id="refundModal{{$refund->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLongTitle">Raison</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <textarea class="form-control" name="name" rows="5" cols="80" readonly>{{$refund->reason}}</textarea>
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermé</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    @endforeach
                  </tbody>
                </table>
              @endif

               <!-- print pagination -->
               <div class="row">
                 <div class="col-md-12">
                   <div class="text-center">
                      {{$refunds->links()}}
                   </div>
                 </div>
               </div>
               <!-- row -->
        </div>
     </div>
   </div>
  </main>

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

    function accept(e, rid) {
      e.preventDefault();
      swal({
        title: "Vous êtes sûr?",
        icon: "Attention",
        buttons: true,
        dangerMode: true,
      })
      .then((willAccept) => {
        if (willAccept) {
          $.ajax({
            url: '{{route('admin.refunds.accept')}}',
            type: 'POST',
            data: {
              rid: rid
            },
            success: function(data) {
              if (data == "success") {
                window.location = "{{url()->current()}}";
              }
            }
          });
        }
      });
    }

    function reject(e, rid) {
      e.preventDefault();
      swal({
        title: "Vous êtes sûr?",
        icon: "Attention",
        buttons: true,
        dangerMode: true,
      })
      .then((willReject) => {
        if (willReject) {
          $.ajax({
            url: '{{route('admin.refunds.reject')}}',
            type: 'POST',
            data: {
              rid: rid
            },
            success: function(data) {
              if (data == "success") {
                window.location = "{{url()->current()}}";
              }
            }
          });
        }
      });

    }
  </script>
@endpush
