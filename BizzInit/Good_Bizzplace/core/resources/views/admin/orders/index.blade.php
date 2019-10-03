@extends('admin.layout.master')


@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h3 class="page-title uppercase bold">
             @if (request()->path() == 'admin/orders/all')
               TOUT
             @elseif (request()->path() == 'admin/orders/confirmation/pending')
                 En attente
             @elseif (request()->path() == 'admin/orders/confirmation/accepted')
                 Acceptée
             @elseif (request()->path() == 'admin/orders/confirmation/rejected')
                 Rejetée
             @elseif (request()->path() == 'admin/orders/delivery/pending')
                 Livraison en Attente
             @elseif (request()->path() == 'admin/orders/delivery/inprocess')
                 Livraison en cours
             @elseif (request()->path() == 'admin/orders/delivered')
                 Livrée
             @elseif (request()->path() == 'admin/orders/cashondelivery')
                 Cash à la livraison
             @elseif (request()->path() == 'admin/orders/advance')
                 Avance payée
             @endif
             Orders
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
              <div class="row mb-4">
                <div class="col-md-3 offset-md-9">
                  <form method="get"
                  action="
                  @if (request()->path() == 'admin/orders/all')
                    {{route('admin.orders.all')}}
                  @elseif (request()->path() == 'admin/orders/confirmation/pending')
                      {{route('admin.orders.cPendingOrders')}}
                  @elseif (request()->path() == 'admin/orders/confirmation/accepted')
                      {{route('admin.orders.cAcceptedOrders')}}
                  @elseif (request()->path() == 'admin/orders/confirmation/rejected')
                      {{route('admin.orders.cRejectedOrders')}}
                  @elseif (request()->path() == 'admin/orders/delivery/pending')
                      {{route('admin.orders.pendingDelivery')}}
                  @elseif (request()->path() == 'admin/orders/delivery/inprocess')
                      {{route('admin.orders.pendingInprocess')}}
                  @elseif (request()->path() == 'admin/orders/delivered')
                      {{route('admin.orders.delivered')}}
                  @elseif (request()->path() == 'admin/orders/cashondelivery')
                      {{route('admin.orders.cashOnDelivery')}}
                  @elseif (request()->path() == 'admin/orders/advance')
                      {{route('admin.orders.advance')}}
                  @endif
                  "
                  >
                    <input class="form-control" type="text" name="term" value="{{$term}}" placeholder="Recherche de la commande par numéro ...">
                  </form>
                </div>
              </div>
              @if (count($orders) == 0)
                <h1 class="text-center"> Aucune commande trouvée !</h1>
              @else
                <table class="table table-bordered" style="width:100%;">
                  <thead>
                    <tr>
                        <th> #id Commande</th>
                        <th>Date Commande</th>
                        <th>Nom</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Total</th>
                        <th>Statut d'envoi</th>
                        <th>Mode de paiement</th>
                        <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($orders as $key => $order)
                      <tr>
                          <td class="padding-top-40">{{$order->unique_id}}</td>
                          <td class="padding-top-40">{{date('j F o', strtotime($order->created_at))}}</td>
                          <td class="padding-top-40">{{$order->first_name . ' ' . $order->last_name}}</td>
                          <td class="padding-top-40">{{$order->phone}}</td>
                          <td class="padding-top-40">{{$order->email}}</td>
                          <td class="padding-top-40">{{$gs->base_curr_symbol}} {{$order->total}}</td>
                          <td class="padding-top-40">
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="shipping{{$order->id}}" id="inlineRadio{{$order->id}}1" value="0" onchange="shippingChange(event, this.value, {{$order->id}})" {{$order->shipping_status==0?'checked':''}} disabled>
                              <label class="form-check-label" for="inlineRadio{{$order->id}}1">En attente</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="shipping{{$order->id}}" id="inlineRadio{{$order->id}}2" value="1" onchange="shippingChange(event, this.value, {{$order->id}})" {{$order->shipping_status==1?'checked':''}} {{$order->shipping_status==1 || $order->shipping_status==2?'disabled':''}}>
                              <label class="form-check-label" for="inlineRadio{{$order->id}}2">En cours</label>
                            </div>
                            <div class="form-check form-check-inline">
                              <input class="form-check-input" type="radio" name="shipping{{$order->id}}" id="inlineRadio{{$order->id}}3" value="2" onchange="shippingChange(event, this.value, {{$order->id}})" {{$order->shipping_status==2?'checked':''}} {{$order->shipping_status==2?'disabled':''}}>
                              <label class="form-check-label" for="inlineRadio{{$order->id}}3">Livrée</label>
                            </div>
                          </td>
                          <td class="padding-top-40">
                            @if ($order->payment_method == 2)
                              Advance
                            @elseif ($order->payment_method == 1)
                              Cash on delivery
                            @endif
                          </td>
                          <td class="padding-top-40">
                              <a href="{{route('admin.orderdetails', $order->id)}}" target="_blank" title="View Order"><i class="text-primary fa fa-eye"></i></a>
                              @if ($order->approve == 0)
                                <span>
                                  <a href="#" onclick="cancelOrder(event, {{$order->id}})" title="Reject Order">
                                    <i class="fa fa-times text-danger"></i>
                                  </a>
                                  <a href="#" onclick="acceptOrder(event, {{$order->id}})" title="Accept Order">
                                    <i class="fa fa-check text-success"></i>
                                  </a>
                                </span>
                              @elseif ($order->approve == 1)
                                <span class="badge badge-success">Accepté</span>
                              @elseif ($order->approve == -1)
                                <span class="badge badge-danger">Rejecté</span>
                              @endif

                          </td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              @endif

               <!-- print pagination -->
               <div class="row">
                 <div class="col-md-12">
                   <div class="text-center">
                      {{$orders->appends(['term' => $term])->links()}}
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

    function shippingChange(e, value, orderid) {

      var fd = new FormData();
      fd.append('value', value);
      fd.append('orderid', orderid);

      swal({
        title: "Vous êtes sûr?",
        text: "Une fois que le statut d'envoi a été modifié, l'e-mail sera envoyé au client.",
        icon: "Attention",
        buttons: true,
        dangerMode: true,
      })
      .then((willChange) => {

        if (willChange) {
          $.ajax({
            url: '{{route('admin.shippingchange')}}',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
              console.log(data);
              if (data == "success") {
                e.target.disabled = true;
                toastr["success"]("<strong>Success!</strong> Statut d'envoi a été mis à jour!");
              }
            }
          });

        } else {
          window.location = '{{url()->current()}}';
        }
      });

    }

    function cancelOrder(e, orderid) {
      e.preventDefault();
      console.log(orderid);

      var fd = new FormData();
      fd.append('orderid', orderid);

      swal({
        title: "Vous êtes sûr?",
        text: "Une fois annulée, vous ne pourrez plus récupérer cette commande!",
        icon: "Attention",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('admin.cancelOrder')}}',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
              console.log(data);
              if (data == "success") {
                window.location = '{{url()->full()}}';
              }
            }
          });

        }
      });
    }

    function acceptOrder(e, orderid) {
      e.preventDefault();
      console.log(orderid);

      var fd = new FormData();
      fd.append('orderid', orderid);

      swal({
        title: "Vous êtes sûr?",
        text: "Une fois accepté, vous ne pourrez pas refuser cette commande.!",
        icon: "Attention",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('admin.acceptOrder')}}',
            type: 'POST',
            data: fd,
            contentType: false,
            processData: false,
            success: function(data) {
              console.log(data);
              if (data == "success") {
                window.location = '{{url()->full()}}';
              }
            }
          });

        }
      });
    }
  </script>
@endpush
