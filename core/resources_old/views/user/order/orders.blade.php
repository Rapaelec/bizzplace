@extends('layout.profilemaster')

@section('title', 'Commandes')

@section('headertxt', 'Commandes')

@push('styles')
<style media="screen">
  li.page-item {
      display: inline-block;
  }

  ul.pagination {
      width: 100%;
  }
  .order-track-page-content {
    padding: 0px;
  }
  .order-track-page-content .track-order-form-wrapper {
    margin: 0px 0 25px 0;
  }
</style>
@endpush

@section('content')

    <div class="row">
      <div class="col-md-12">
        <div class="order-track-page-content">
          <div class="track-order-form-wrapper"><!-- track order form -->
              {{-- <h3 class="title">Tracker votre commande depuis ici</h3>
              <form action="{{route('user.orders',$orders->id)}}" class="track-order-form" method="get">
                  <div class="form-element">
                      <input name="order_number" type="text" value="{{$on}}" class="input-field" placeholder="Tapez votre numéro de commande ...">
                  </div>
                  <button type="submit" class="submit-btn"><i class="fas fa-truck"></i> Track commande</button>
              </form> --}}
          </div><!-- //. track order form -->
        </div>
      </div>
      <div class="col-md-12">
        <div class="seller-product-wrapper">
            <div class="seller-panel">
                <div class="sellers-product-inner">
                    <div class="bottom-content">
                        <table class="table table-default" id="datatableOne">
                            <thead>
                                <tr>
                                    <th>Commande id</th>
                                    <th>Date commande</th>
                                    <th>Total</th>
                                    <th>Methode de paiement</th>
                                    <th>Status commande</th>
                                    <th>Status livraison</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                              @foreach ($orders as $key => $order)
                                <tr>
                                    <td class="padding-top-40">{{$order->unique_id}}</td>
                                    <td class="padding-top-40">{{ date('j F o',strtotime($order->created_at)-1) }}</td>
                                    <td class="padding-top-40">{{$gs->base_curr_symbol}} {{$order->total}}</td>
                                    <td class="padding-top-40">
                                      @if ($order->payment_method == 2)
                                        Avance
                                      @elseif ($order->payment_method == 1)
                                        Payer à la livraison
                                      @endif
                                    </td>
                                    <td class="padding-top-40">
                                      @if ($order->approve == 0)
                                        <span class="badge badge-warning">En attente</span>
                                      @elseif ($order->approve == 1)
                                        <span class="badge badge-success">Acceptée</span>
                                      @elseif ($order->approve == -1)
                                        <span class="badge badge-danger">Rejétée</span>
                                      @endif
                                    </td>
                                    <td class="padding-top-40">
                                      @if ($order->shipping_status == 0)
                                        <span class="badge badge-danger">En attente</span>
                                      @elseif ($order->shipping_status == 1)
                                        <span class="badge badge-warning">En cours</span>
                                      @elseif ($order->shipping_status == 2)
                                        <span class="badge badge-success">Expédiée</span>
                                      @endif
                                    </td>
                                    <td class="padding-top-40">
                                      <a class="btn btn-primary" data-toggle="tooltip" data-placement="bottom" href="{{ ($order->shipping_status == 2) ? route('user.view_facture',[$order->id,$order->vendor_id]) : route('user.orderdetails', $order->id) }}">
                                        <i class='fa fa-{{ ($order->shipping_status == 2) ? "print" : "eye" }}' title="{{ ($order->shipping_status == 2 && $order->approve == 1) ? 'Imprimer la facture' : 'Voir la commande' }}"></i>
                                        {{ ($order->shipping_status == 2 && $order->approve == 1) ? 'Imprimer la facture' : 'Voir la commande' }}
                                      </a>
                                      <a class="btn btn-info" data-toggle="tooltip" title="Adresse de facturation" href="{{  route('billing.detail',$order->vendor_id) }}"><i class="fa fa-address-card" aria-hidden="true"></i>Adresse de facturation</a>
                                    </td>
                                </tr>
                              @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
      {{ $orders->links()}}
    </div>
    <br>
@endsection
