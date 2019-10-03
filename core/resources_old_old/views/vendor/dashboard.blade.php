@extends('layout.master')

@section('title', 'Dashboard')

@section('headertxt', 'Dashboard')

@section('content')
  <!-- seller dashboard content area start -->
  <div class="seller-dashboard-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="card dashboard-content-wrapper card-default gray-bg">
                      <div class="card-header">
                          Dashboard
                      </div>
                      <div class="mini-card-wrapper">
                          <div class="row">
                              <div class="col-lg-4 col-md-6">
                                  <div class="single-mini-card-item bg-light-blue">
                                      <div class="bg-icon">
                                          <i class="fas fa-euro-sign"></i>
                                      </div>
                                      <h4 class="title">Solde actuel</h4>
                                      <div class="counterup">&euro;<span class="count">{{\App\Vendor::find(Auth::guard('vendor')->user()->id)->balance}}</span></div>
                                  </div>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                  <a href="{{route('vendor.orders')}}" class="single-mini-card-item bg-light-orange">
                                      <div class="bg-icon">
                                          <i class="fas fa-shopping-cart"></i>
                                      </div>
                                      <h4 class="title">Total Commande</h4>
                                      <div class="counterup"><span class="count">{{count(\App\Orderedproduct::join('orders', 'orders.id', '=', 'orderedproducts.order_id')->select('order_id', DB::raw('count(order_id) as total'))->where('vendor_id', Auth::guard('vendor')->user()->id)->whereIn('orders.approve', [0, 1])->groupBy('order_id')->get())}}</span></div>
                                  </a>
                              </div>
                              <div class="col-lg-4 col-md-6">
                                  <a href="{{route('vendor.product.manage')}}" class="single-mini-card-item bg-light-gray">
                                      <div class="bg-icon">
                                          <i class="fab fa-product-hunt"></i>
                                      </div>
                                      <h4 class="title">Produits</h4>
                                      {{-- {{ dd(Auth::guard('vendor')->user()->id) }} --}}
                                      <div class="counterup"><span class="count">{{\App\Product::where('vendor_id', Auth::guard('vendor')->user()->id)->count()}}</span></div>
                                  </a>
                              </div>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-6 col-lg-4">
                                  <a href="{{ route('vendor.charge.index') }}" class="single-mini-card-item bg-light-blue">
                                      <div class="bg-icon"></div>
                                      <h3 class="title">GERER VOS TAXES</h3>
                                      <div class=""><span class=""></span></div>
                                  </a>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                  <a href="{{ route('vendor.annonce.index') }}" class="single-mini-card-item bg-light-orange">
                                      <div class="bg-icon"></div>
                                      <h3 class="title">GERER VOS ANNONCES</h3>
                                      <div class=""><span class=""></span></div>
                                  </a>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                  <a href="{{ route('vendor.partenaire.index') }}" class="single-mini-card-item bg-light-gray">
                                      <h3 class="title"><i class="fas fa-users"></i> PARTENARIAT</h3>
                                      <div class="mt-2"><span class=""></span></div>
                                  </a>
                            </div>
                          </div>
                      </div>
                      <div class="panel-wrapper">
                          <div class="row">
                              <div class="col-lg-12">
                                 <div class="row">
                                     <div class="col-lg-6 col-md-6">
                                          <div class="seller-card">
                                              <div class="card-header">
                                               Produits les plus vendus
                                              </div>
                                              <div class="card-body">
                                                <table class="table table-responsive seller-dashboard-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Titre</th>
                                                            <th>Ventes</th>
                                                            <th>Prix</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach ($products as $key => $product)
                                                        <tr>
                                                            <td><a href="{{route('user.product.details', [$product->slug,$product->id])}}">{{strlen($product->title) > 20 ? substr($product->title, 0, 20) . '...' : $product->title}}</a></td>
                                                            @php
                                                              $date = \Carbon\Carbon::now()->subDays(30);
                                                              $sales = \App\Orderedproduct::where('shipping_status', 2)
                                                                                     ->where('refunded', '<>', 1)
                                                                                     ->where('product_id', $product->id)
                                                                                     ->where('shipping_date', '>=' ,$date)
                                                                                     ->sum('quantity');
                                                            @endphp
                                                            <td><span class="base-color">{{$sales}}</span> </td>
                                                            <td>
                                                              @if (empty($product->current_price))
                                                                <span class="sprice">{{$gs->base_curr_symbol}} {{$product->price}}</span>
                                                              @else
                                                                <span class="sprice">{{$gs->base_curr_symbol}} {{$product->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$product->price}}</del>
                                                              @endif
                                                            </td>
                                                        </tr>
                                                      @endforeach
                                                    </tbody>
                                                </table>
                                              </div>

                                          </div>
                                     </div>
                                     <div class="col-lg-6 col-md-6">
                                          <div class="seller-card">
                                              <div class="card-header">
                                              Produits les mieux notés
                                              </div>
                                              <div class="card-body">
                                                <table class="table table-responsive seller-dashboard-table">
                                                    <thead>
                                                        <tr>
                                                            <th>Titre</th>
                                                            <th>Évaluation</th>
                                                            <th>Prix</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                      @foreach ($topRatedPros as $key => $topRatedPro)
                                                        <tr>
                                                            <td><a href="{{route('user.product.details', [$topRatedPro->slug,$topRatedPro->id])}}">{{strlen($topRatedPro->title) > 20 ? substr($topRatedPro->title, 0, 20) . '...' : $topRatedPro->title}}</a></td>
                                                            <td><span class="base-color">{{round($topRatedPro->productreviews()->avg('rating'), 2)}}</span> </td>
                                                            <td>
                                                              @if (empty($topRatedPro->current_price))
                                                                <span class="sprice">{{$gs->base_curr_symbol}} {{$topRatedPro->price}}</span>
                                                              @else
                                                                <span class="sprice">{{$gs->base_curr_symbol}} {{$topRatedPro->current_price}}</span> <del class="dprice">{{$gs->base_curr_symbol}} {{$topRatedPro->price}}</del>
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
                          </div>
                          <div class="row">
                              <div class="col-lg-12">
                                  <div class="latest-order">
                                    <div class="table-panel">
                                    <div class="card-header">Dernières commandes</div>
                                          <div class="card-body">
                                              <table class="table table-responsive seller-dashboard-table">
                                                  <thead>
                                                    <tr>
                                                        <th>Id Commande</th>
                                                        <th>Date Commande</th>
                                                        <th>Total</th>
                                                        <th>Statut d'envoi</th>
                                                        <th>Statut de la commande</th>
                                                        <th>Mode de paiement</th>
                                                        <th>Action</th>
                                                    </tr>
                                                  </thead>
                                                  <tbody>
                                                    @foreach ($lorders as $key => $lorder)
                                                      <tr>
                                                          <td class="padding-top-40">{{$lorder->unique_id}}</td>
                                                          <td class="padding-top-40">{{date('j F, o', strtotime($lorder->created_at))}}</td>
                                                          <td class="padding-top-40">{{$gs->base_curr_symbol}} {{$lorder->total}}</td>
                                                          <td class="padding-top-40">
                                                            @if ($lorder->shipping_status == 0)
                                                              <span class="badge badge-danger">En attente</span>
                                                            @elseif ($lorder->shipping_status == 1)
                                                              <span class="badge badge-warning">En cours</span>
                                                            @elseif ($lorder->shipping_status == 2)
                                                              <span class="badge badge-success">Livrée</span>
                                                            @endif
                                                          </td>
                                                          <td class="padding-top-40">
                                                            @if ($lorder->approve == 0)
                                                              <span class="badge badge-warning">En attente</span>
                                                            @elseif ($lorder->approve == 1)
                                                              <span class="badge badge-success">Accepté</span>
                                                            @elseif ($lorder->approve == -1)
                                                              <span class="badge badge-danger">Rejecté</span>
                                                            @endif
                                                          </td>
                                                          <td class="padding-top-40">
                                                            @if ($lorder->payment_method == 2)
                                                              Avance
                                                            @elseif ($lorder->payment_method == 1)
                                                              Cash à la livraison
                                                            @endif
                                                          </td>
                                                          <td class="padding-top-40">
                                                              <a href="{{route('vendor.orderdetails', $lorder->id)}}" target="_blank"><i class="text-primary fa fa-eye"></i></a>
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
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- seller dashboard content area end -->
@endsection
