@extends('layout.master')

@section('title', 'Produits commandés')

@section('headertxt', "Commande #$order->unique_id")

@push('styles')
<style media="screen">
  .sellers-product-content-area .seller-product-wrapper .sellers-product-inner {
      padding: 0px;
  }
  .sellers-product-content-area .seller-product-wrapper {
      background-color: #fff;
  }
  .thumb img {
      width: 70px;
  }
  .sellers-product-content-area .seller-product-wrapper .sellers-product-inner .bottom-content table tbody tr td .action li {
  	margin: 0px;
  }
  li.page-item {
      display: inline-block;
  }

  ul.pagination {
      width: 100%;
  }
  .product-img img {
    width: 100%;
  }
</style>
@endpush

@section('content')
  <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
          <div class="row mb-4">
            <div class="col-md-12">
              <h2 style="font-size: 32px;margin-bottom: 28px;" class="order-heading">Informations sur la commande</h2>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header base-bg">
                  <h6 class="white-txt no-margin">numéro de commande # {{$order->unique_id}}</h6>
                </div>
                <div class="card-body">
                  <p>
                    <strong>Order Status: </strong>
                    @if ($order->approve == 0)
                      <span class="badge badge-warning">en attente ...</span>
                    @elseif ($order->approve == 1)
                      <span class="badge badge-success">Accepté</span>
                    @elseif ($order->approve == -1)
                      <span class="badge badge-danger">Rejetée</span>
                    @endif
                  </p>
                  <p><strong>Date de commande: </strong> {{date('jS F, Y', strtotime($order->created_at))}}</p>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header base-bg">
                  <h6 class="white-txt no-margin">Paiement / Méthode d'envoi</h6>
                </div>
                <div class="card-body">
                  <p>
                    <strong>Méthode d'envoi: </strong>
                    @if ($order->shipping_method == 'around')
                      Arround {{$gs->main_city}}
                    @elseif ($order->shipping_method == 'world')
                      Arround the World
                    @elseif ($order->shipping_method == 'in')
                      In {{$gs->main_city}}
                    @endif
                  </p>
                  <p>
                    <strong>Mode de paiement: </strong>
                    @if ($order->payment_method == 1)
                    Paiement à la livraison
                    @elseif ($order->payment_method == 2)
                    Avance payée via <strong>{{$order->orderpayment->gateway->name}}</strong>
                    @endif
                  </p>
                  @if ($order->approve != -1)
                    <p>
                      <strong>Statut d'envoi: </strong>
                      @if ($order->shipping_status == 0)
                        <span class="badge badge-danger">En attente</span>
                      @elseif ($order->shipping_status == 1)
                        <span class="badge badge-warning">En cours </span>
                      @elseif ($order->shipping_status == 2)
                        <span class="badge badge-success">Livrée</span>
                      @endif
                    </p>
                  @endif
                </div>
              </div>
            </div>
          </div>

          {{-- @if (!empty($order->order_notes))
          <div class="row mb-4">
            <div class="col-md-6">
              <div class="card">
                <div class="card-header base-bg">
                  <h6 class="white-txt no-margin">Note commande</h6>
                </div>
                <div class="card-body">
                    <p>{{$order->order_notes}}</p>
                </div>
              </div>
            </div>
          </div>
          @endif --}}
          <div class="row">
              <div class="col-lg-8">
                  <div class="seller-product-wrapper">
                      <div class="seller-panel">
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>Produits</th>
                                              <th>Codes Produits</th>
                                              <th>Prix</th>
                                              <th>Quantité</th>
                                              <th>Total</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($orderedproducts as $key => $orderedproduct)
                                          <tr>
                                              <td>
                                                  <div class="single-product-item"><!-- single product item -->
                                                      <div class="thumb">
                                                          <img src="{{asset('assets/user/img/products/'.$orderedproduct->product->previewimages()->first()->image)}}" alt="seller product image">
                                                      </div>
                                                      <div class="content" style="padding-top:0px;">
                                                          <h4 class="title"><a href="{{route('user.product.details', [$orderedproduct->product->slug,$orderedproduct->product->id])}}" target="_blank">{{strlen($orderedproduct->product->title) > 30 ? substr($orderedproduct->product->title, 0, 30) . '...' : $orderedproduct->product->title}}</a></h4>
                                                          @php
                                                            $attrs = json_decode($orderedproduct->attributes, true);
                                                            // dd($attrs);
                                                          @endphp
                                                          @if (!empty($attrs))
                                                            <p>
                                                              @foreach ($attrs as $attrname => $attr)
                                                                  <strong>{{str_replace("_", " ", $attrname)}}:</strong>
                                                                  @foreach ($attr as $sattr)

                                                                    @if (!$loop->last)
                                                                      {{$sattr}},
                                                                    @else
                                                                      {{$sattr}}
                                                                    @endif
                                                                  @endforeach
                                                                  @if (!$loop->last)
                                                                    |
                                                                  @endif
                                                              @endforeach
                                                            </p>
                                                          @endif
                                                      </div>
                                                  </div><!-- //.single product item -->
                                              </td>
                                              <td class="">{{$orderedproduct->product->product_code}}</td>
                                              <td class="">
                                                @if (!empty($orderedproduct->offered_product_price))
                                                  <del>{{$gs->base_curr_symbol}} {{round($orderedproduct->product_price, 2)}}</del><br>
                                                  <span>{{$gs->base_curr_symbol}} {{round($orderedproduct->offered_product_price, 2)}}</span>
                                                @else
                                                    <span>{{$gs->base_curr_symbol}} {{round($orderedproduct->product->price, 2)}}</span>
                                                @endif
                                              </td>
                                              <td class="">{{$orderedproduct->quantity}}</td>
                                              <td class="">
                                                @if (!empty($orderedproduct->offered_product_price))
                                                  <del>{{$gs->base_curr_symbol}} {{round($orderedproduct->product_price, 2)*$orderedproduct->quantity}}</del><br>
                                                  <span>{{$gs->base_curr_symbol}} {{round($orderedproduct->offered_product_price, 2)*$orderedproduct->quantity}}</span>
                                                @else
                                                    <span>{{$gs->base_curr_symbol}} {{round($orderedproduct->product->price, 2)*$orderedproduct->quantity}}</span>
                                                @endif
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

              <div class="col-md-4">
                <div class="card order-summary">
                  <div class="card-header base-bg">
                    <h4 class="white-txt no-margin">Récapitulatif de la commande</h4>
                  </div>
                  <div class="card-body">
                    <ul>
                      <li><span class="left">MONTANT DU PANIER</span> <span class="right">{{$gs->base_curr_symbol}} {{$subtotal}}</span></li>
                      @if ($ccharge > 0)
                        <li><span class="left">COUPON CHARGE</span> <span class="right">- {{$gs->base_curr_symbol}} {{round($ccharge, 2)}}</span></li>
                      @else
                        <li><span class="left">COUPON CHARGE</span> <span class="right">- {{$gs->base_curr_symbol}} 0.00</span></li>
                      @endif
                      <li class="li-total"><span class="left total">TOTAL</span> <span class="right total">{{$gs->base_curr_symbol}} {{round($total, 2)}}</span></li>
                    </ul>
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <!-- sellers product content area end -->


@endsection
