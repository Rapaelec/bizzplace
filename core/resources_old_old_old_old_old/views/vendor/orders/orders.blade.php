@extends('layout.master')

@section('title', 'Gérer les commandes')

@section('headertxt', 'Gérer les commandes')

@push('styles')
<link rel="stylesheet" href="{{asset('assets/user/css/vendor-orders.css')}}">
@endpush

@section('content')

  <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="order-track-page-content">
                    <div class="track-order-form-wrapper"><!-- track order form -->
                        <h3 class="title">Suivre votre commande ici</h3>
                        <form action="{{route('vendor.orders')}}" class="track-order-form" method="get">
                            <div class="form-element">
                                <input name="order_number" type="text" value="{{request()->input('order_number')}}" class="input-field" placeholder="Tapez votre numéro de commande ...">
                            </div>
                            <button type="submit" class="submit-btn"><i class="fas fa-truck"></i> Suivi de commande</button>
                        </form>
                    </div><!-- //. track order form -->
                  </div>
                  <div class="row py-5">
                    <div class="col-md-3">
                      <div class="card" style="width: 100%;">
                        <div class="user-sidebar">
                          <div class="card-header base-bg">
                            <h4 class="white-txt no-margin">Commande</h4>
                          </div>
                          <ul class="list-group list-group-flush">
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders')) active @endif" href="{{ route('vendor.orders') }}">Liste commande</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.progress')) active @endif" href="{{route('vendor.orders.progress')}}">En cours</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.accepted')) active @endif" href="{{route('vendor.orders.accepted')}}">Livrées</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.in_delivering')) active @endif" href="{{route('vendor.orders.in_delivering')}}">Acceptées</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.awaiting_delivery')) active @endif" href="{{route('vendor.orders.awaiting_delivery')}}">En attente de livraison</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.delivered')) active @endif" href="{{route('vendor.orders.delivered')}}">En cours de livraison</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.payment_on_delivery')) active @endif" href="{{route('vendor.orders.payment_on_delivery')}}">Payement à la livraison</a></li>
                            <li class="list-group-item"><a class="sidebar-links @if(route::is('vendor.orders.advance_paid')) active @endif" href="{{route('vendor.orders.advance_paid')}}">Avance payée</a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-9">
                    <div class="col-md-3 offset-md-9">
                  <form method="get"
                  action="
                  @if (request()->path() == 'vendor/orders/orders')
                    {{route('vendor.orders.orders')}}
                  @elseif (request()->path() == 'vendor/orders/confirmation/pending')
                      {{route('vendor.orders.progress')}}
                  @elseif (request()->path() == 'vendor/orders/confirmation/accepted')
                      {{route('vendor.orders.accepted')}}
                  @elseif (request()->path() == 'vendor/orders/delivery/pending')
                      {{route('vendor.orders.in_delivering')}}
                  @elseif (request()->path() == 'vendor/orders/delivery/inprocess')
                      {{route('vendor.orders.awaiting_delivery')}}
                  @elseif (request()->path() == 'vendor/orders/delivered')
                      {{route('vendor.orders.delivered')}}
                  @elseif (request()->path() == 'vendor/orders/cashondelivery')
                      {{route('vendor.orders.payment_on_delivery')}}
                  @elseif (request()->path() == 'vendor/orders/advance')
                      {{route('vendor.orders.advance')}}
                  @endif
                  ">
                    {{-- <input class="form-control" type="text" name="term" value="{{$term}}" placeholder="Search by order number"> --}}
                  </form>
                </div>
                      <div class="seller-product-wrapper">
                        <div class="seller-panel">
                            <div class="sellers-product-inner">
                                <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                        <tr>
                                            <th>Numéro de commande</th>
                                            <th>Date de commande</th>
                                            <th>Total</th>
                                            <th>Statut d'envoi</th>
                                            <th>Statut de la commande</th>
                                            <th>Mode de paiement</th>
                                            <th>Action</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($orders as $key => $order)
                                          <tr>
                                              <td class="padding-top-40">{{$order->unique_id}}</td>
                                              <td class="padding-top-40">{{date('jS F, o', strtotime($order->created_at))}}</td>
                                              <td class="padding-top-40">{{$gs->base_curr_symbol}} {{ getTotalOrderForVendor($order->id,Auth::guard('vendor')->user()->id) }}</td>
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
                                                @if ($order->approve == 0)
                                                  <span class="badge badge-warning">En attente</span>
                                                @elseif ($order->approve == 1)
                                                  <span class="badge badge-success">Acceptée</span>
                                                @elseif ($order->approve == -1)
                                                  <span class="badge badge-danger">Rejetée</span>
                                                @endif
                                              </td>
                                              <td class="padding-top-40">
                                                @if ($order->payment_method == 2)
                                                  Avance
                                                @elseif ($order->payment_method == 1)
                                                  Cash à la livraison
                                                @endif
                                              </td>
                                              <td class="padding-top-40">
                                              <a href="{{route('vendor.orderdetails', $order->id)}}" target="_blank" title="voir commande"><i class="text-primary fa fa-eye"></i></a>
                                              @if ($order->approve == 0)
                                                <span>
                                                  <a href="#" onclick="cancelOrder(event, {{$order->id}})" title="Rejeter commande">
                                                    <i class="fa fa-times text-danger"></i>
                                                  </a>
                                                  <a href="#" onclick="acceptOrder(event, {{$order->id}})" title="Accepter commande">
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
  
                                  <div class="text-center">
                                      {{$orders->links()}}
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
            url: '{{route('vendor.shippingchange')}}',
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
            url: '{{route('vendor.cancelOrder')}}',
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
            url: '{{route('vendor.acceptOrder')}}',
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
