
    <!-- support bar area two start -->
    <div class="support-bar-two bg-white home-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="left-content">
                        <a href="{{route('user.home')}}" class="logo main-logo">
                            <img src="{{asset('assets/user/interfaceControl/logoIcon/logo.jpg')}}" alt="logo">
                        </a>
                    </div>
                    <div class="right-content">
                        <ul>
                            <li>
                                <div class="support-search-area">
                                    <form action="{{url('/').'/shop'.'/'.Request::route('category').'/'.Request::route('subcategory')}}" class="search-form">
                                        <div class="form-element has-icon" action="{{route('user.search')}}">
                                          <input name="term" type="text" class="input-field" placeholder="Recherche ..." value="{{request()->input('term')}}">
                                          <div class="the-icon">
                                              <select class="category select selectpicker" onchange="categoryChange(this.value)">
                                                  <option value="" selected disabled>Categories</option>
                                                  @foreach ($categories as $key => $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                  @endforeach
                                              </select>
                                          </div>
                                          <button type="submit" class="submit-btn"><i class="fas fa-search"></i></button>
                                        </div>
                                    </form>
                                </div>
                            </li>
                            @if (!Auth::check() && !Auth::guard('vendor')->check())
                            <li>
                                <div class="single-support-info-item">
                                    <div class="icon">
                                      <i class="fas fa-user-plus"></i>
                                    </div>
                                    <div class="content">
                                        <a href=" {{ route('user.page_connect') }}"><h4 class="title">S'inscrire</h4></a>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="single-support-info-item">
                                    <div class="icon">
                                            <i class="fas fa-users"></i>
                                    </div>
                                    <div class="content">
                                      <a href="{{route('login')}}"><h4 class="title">Se connecter</h4></a>
                                    </div>
                                </div>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- support bar area two end -->
    <!-- navbar area start -->
    <nav class="navbar navbar-area navbar-expand-lg navbar-expand-sm navbar-expand-md navbar-light bg-light-blue home-6">
            <div class="container nav-container">
                <div class="logo-wrapper navbar-brand ">
                    <a href="index.html" class="logo main-logo mobile-logo">
                        <img src="{{asset('assets/user/interfaceControl/logoIcon/logo.jpg')}}" alt="logo">
                    </a>
                    @if (!Auth::guard('vendor')->check())
                    <div class="form-element has-icon">
                        <select class="category selectpicker" onchange="categoryChange(this.value)">
                          <option value="" selected disabled>Categories</option>
                          @foreach ($categories as $key => $category)
                            <option value="{{$category->id}}" {{Request::route('category') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                          @endforeach
                        </select>
                        <span class="the-icon">
                                <i class="fas fa-plus"></i>
                        </span>
                    </div>
                    @endif
                </div>
                <div class="collapse navbar-collapse" id="mirex">
                    <!-- navbar collapse start -->
                    <ul class="navbar-nav">
                        <!-- navbar- nav -->
                        @if (!Auth::guard('vendor')->check())
                          <li class="nav-item">
                              <a class="nav-link" href="{{route('user.home')}}">Accueil</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{  route('user.cartgift') }}">Cartes Cadeaux</a>
                          </li>
                        @endif
                        @auth('vendor')
                          <li class="nav-item">
                              <a class="nav-link" href="{{route('vendor.dashboard')}}">Dashboard</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{route('package.index')}}">Packages</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{route('vendor.showDepositMethods')}}">Dépôt</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{route('vendor.orders')}}">Commande</a>
                          </li>
                          <li class="nav-item dropdown">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Message<sup><span class="badge badge-danger">@isset (Auth()->user()->notifications)
                            {{ Auth()->user()->unreadnotifications->count()==0 ? Auth()->user()->unreadnotifications->count() : Auth()->user()->unreadnotifications->count() .' new message' }}@endisset</sup></span></a>
                            <div class="dropdown-menu">
                              <a href="{{route('vendor.message.read')}}" class="dropdown-item">Marqué comme lu</a>
                            </div>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('vendor.annonce.index') }}">Annonces</a>
                          </li>
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">Livreurs</a>
                              <div class="dropdown-menu">
                                  <a href="{{route('vendor.deliveryman.manage')}}" class="dropdown-item">Gestion Livreur</a>
                              </div>
                          </li>
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{Auth::guard('vendor')->user()->shop_name}}</a>
                              <div class="dropdown-menu">
                                  <a href="{{route('vendor.setting')}}" class="dropdown-item">Reglage</a>
                                  <a href="{{route('vendor.changePassword')}}" class="dropdown-item">Changer le mot de passe</a>
                                  <a href="{{route('vendor.transactions')}}" class="dropdown-item">Historique Transaction </a>
                                  <a href="{{route('vendor.couponlog')}}" class="dropdown-item">Historique Coupon </a>
                                  <a href="{{route('vendor.logout', Auth::guard('vendor')->user()->id)}}" class="dropdown-item">Se déconnecter</a>
                              </div>
                          </li>
                        @endauth
                        @if (!Auth::guard('vendor')->check())
                        <li class="nav-item dropdown mega-menu"><!-- mega menu start -->
                            <a class="nav-link dropdown-toggle" href="{{route('user.search')}}" data-toggle="dropdown">Central d'achat</a>
                            <div class="mega-menu-wrapper">
                                <div class="container mega-menu-container">
                                    <div class="row">
                                      @foreach ($categories as $key => $cat)
                                          <div class="col-lg-2 col-sm-12">
                                            <div class="mega-menu-columns">
                                                <h6 class="title">{{$cat->name}}</h6>
                                                <ul class="menga-menu-page-links">
                                                  @foreach ($cat->subcategories()->where('status', 1)->get() as $key => $subcat)
                                                    <li><a href="{{route('user.search', [$cat->id, $subcat->id])}}">{{$subcat->name}}</a></li>
                                                  @endforeach
                                                </ul>
                                            </div>
                                          </div>
                                      @endforeach
                                    </div>
                                  </div>
                            </div>
                        </li>
                        <!-- mega menu end -->
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.search',App\Category::where('true_name','SERVICES')->first()->id)}}">Annuaire</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('user.search',App\Category::where('true_name','PRODUITS')->first()->id)}}">Bons plans</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link" href="{{route('user.contact')}}">Contact</a>
                        </li> --}}
                        @if (!Auth::check() && !Auth::guard('vendor')->check())
                          <li class="nav-item">
                              <a class="nav-link" href="{{ route('page_inscription')}}">Vendeur</a>
                          </li>
                        @elseif (Auth::check())  
                          <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown">{{Auth::user()->username}}</a>
                              <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('user.profile')}}">Profile</a>
                                    <a class="dropdown-item" href="{{route('user.wishlist')}}">Favoris</a>
                                    <a class="dropdown-item" href="{{route('user.professional')}}">Commande</a>
                                    <a class="dropdown-item" href="{{route('user.shipping')}}">Adresse de livraison</a>
                                    <!-- <a class="dropdown-item" href="{{route('user.billing')}}">Adresse de facturation</a> -->
                                    <a class="dropdown-item" href="{{route('user.logout')}}">Se déconnecter</a>
                              </div>
                          </li> 
                        @endif
                        @endif
                    </ul>
                    <!-- /.navbar-nav -->
                </div>
                <!-- /.navbar btn wrapper -->
                <div class="responsive-mobile-menu">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#mirex" aria-controls="mirex"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </div>
                <!-- navbar collapse end -->

                @if (!Auth::guard('vendor')->check())
                <div class="right-btn-wrapper">
                   <ul>
                       @if (!Auth::guard('vendor')->check() || request()->is('product/*/details') || request()->is('cart'))
                       <li class="cart" id="cart"><i class="fas fa-shopping-bag"></i>
                        <span class="badge d-block" id="itemsCountVue">@{{itemsCount}}</span>
                        <span class="badge d-none" id="itemsCountJquery"></span>
                       </li>
                       @endif
                   </ul>
                </div>
                @endif
            </div>
        </nav>
        <!-- navbar area end -->
        <div class="body-overlay" id="body-overlay"></div>
    <div class="search-popup" id="search-popup">
        <form action="index.html" class="search-popup-form">
            <div class="form-element">
              <input type="text"  class="input-field" placeholder="Recherche ...">
            </div>
            <button type="submit" class="submit-btn"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <!-- slide sidebar area start -->
    <div class="slide-sidebar-area" id="slide-sidebar-area">
        <div class="top-content"><!-- top content -->
            <a href="{{route('user.home')}}" class="logo">
                <img src="{{asset('assets/user/interfaceControl/logoIcon/logo.jpg')}}" alt="logo">
            </a>
            <span class="side-sidebar-close-btn" id="side-sidebar-close-btn"><i class="fas fa-times"></i></span>
        </div><!-- //. top content -->
    </div>
    <!-- slide sidebar area end -->

    @if (!Auth::guard('vendor')->check() || request()->is('product/*/details') || request()->is('cart'))
      <!-- cart sidebar area start -->
      <div class="cart-sidebar-area" id="cart-sidebar-area">
          <div class="top-content"><!-- top content -->
              <a href="{{route('user.home')}}" class="logo">
                  <img src="{{asset('assets/user/interfaceControl/logoIcon/footer_logo.jpg')}}" alt="footer-logo">
              </a>
              <span class="side-sidebar-close-btn" ><i class="fas fa-times"></i></span>
          </div><!-- //. top content -->
          <div class="bottom-content"><!-- bottom content -->
              <div class="cart-products"><!-- cart product -->
                  <h4 class="title">Panier d'achat</h4>
                  <div class="">
                    @php
                      if (Auth::check()) {
                        $sessionid = Auth::user()->id;
                      } else {
                        $sessionid = session()->get('browserid');
                      }
                      $carts = \App\Cart::where('cart_id', $sessionid)->get();
                    @endphp

                    @foreach ($carts as $cart)
                      <div class="single-product-item" id="singleitem{{$cart->id}}"><!-- single product item -->
                          <div class="thumb">
                              <img src="{{asset('assets/user/img/products/') . '/' . \App\Product::find($cart->product_id)->previewimages()->first()->image}}" alt="recent review">
                          </div>
                          <div class="content">
                              <a href="{{route('user.product.details', [$cart->product->slug, $cart->product->id])}}"><h4 class="title">{{strlen($cart->title) > 18 ? substr($cart->title, 0, 18) . '...' : $cart->title}}</h4></a>
                              <div class="price" style="font-size:12px;">
                                @if (empty($cart->current_price))
                                  <span class="pprice" id="price{{$cart->id}}">{{$gs->base_curr_symbol}} {{$cart->price}}</span> <span class="sidequantity" id="quantity{{$cart->id}}">({{$cart->quantity}})</span>
                                @else
                                  <span class="pprice" id="price{{$cart->id}}">{{$gs->base_curr_symbol}} {{$cart->current_price}}</span> <del id="delprice{{$cart->id}}" class="dprice">{{$gs->base_curr_symbol}} {{$cart->price}}</del> <span class="sidequantity" id="quantity{{$cart->id}}">({{$cart->quantity}})</span>
                                @endif
                              </div>
                              @php
                                $storedattr = json_decode($cart->attributes, true);
                              @endphp
                              @if (count($storedattr) > 0)
                                <div style="font-size:12px;">
                                  @php
                                    $attrs = '';
                                    $j=0;
                                    foreach ($storedattr as $key => $values) {
                                      $attrs .= "".str_replace('_', ' ', $key).": ";
                                      $i = 0;
                                      foreach ($values as $v) {
                                        $attrs .= "$v";
                                        if (count($values)-1 != $i) {
                                          $attrs .= ", ";
                                        } else {
                                          $attrs .= " ";
                                        }
                                        $i++;
                                      }
                                      if (count($storedattr) - 1 != $j) {
                                        $attrs .= ' | ';
                                      }
                                      $j++;
                                    }
                                  @endphp
                                  {{$attrs}}
                                </div>
                              @endif
                              <a style="font-size:12px;" href="#" class="remove-cart" @click="precartlen--;removeproduct({{$cart->id}})">Retiré</a>
                          </div>
                      </div><!-- //. single product item -->
                    @endforeach

                    <!-- single product item -->
                    <div class="single-product-item" v-for="(product, index) in products">
                        <div class="thumb">
                            <img :src="'{{url('/assets/user/img/products/')}}'+'/'+product.preimg" alt="recent review">
                        </div>
                        <div class="content">
                            <a :href="'{{url('/')}}/product/' + product.slug + '/' + product.id"><h4 class="title">@{{product.title.length > 18 ? product.title.substring(0, 18) + '...' : product.title.substring}}</h4></a>
                            <div style="font-size:12px;" class="price" v-if="!product.current_price"><span class="pprice" :id="'price'+product.cart_id">{{$gs->base_curr_symbol}} @{{product.price * product.quantity}}</span> <span :id="'quantity'+product.cart_id">(@{{product.quantity}})</span></div>
                            <div style="font-size:12px;" class="price" v-if="product.current_price"><span class="pprice" :id="'price'+product.cart_id">{{$gs->base_curr_symbol}} @{{product.current_price * product.quantity}}</span> <del class="dprice" :id="'delprice'+product.cart_id">{{$gs->base_curr_symbol}} @{{product.price * product.quantity}}</del> <span :id="'quantity'+product.cart_id">(@{{product.quantity}})</span></div>
                            <div style="font-size:12px;" v-if="product.countattr > 0">
                              @{{product.attrs}}
                            </div>
                            <a style="font-size:12px;" href="#" class="remove-cart" @click="products.splice(index, 1);removeproduct(product.cart_id)">Retiré</a>
                        </div>
                    </div>
                    <!-- //. single product item -->

                    <div class="btn-wrapper" v-show="checkoutbtn" id="checkoutbtn">
                      <a href="{{route('cart.index')}}" class="boxed-btn view-cart-btn">Panier</a>
                      <a href="{{route('user.checkout.index')}}" class="boxed-btn checkout-btn">Caisse</a>
                    </div>
                  </div>

                  <div v-show="noproduct">
                    <h4 class="text-center white-txt">AUCUN ELEMENT AJOUTE AU PANIER</h4>
                  </div>
                  <div id="noproduct" style="display:none;">
                    <h4 class="text-center white-txt">AUCUN ELEMENT AJOUTE AU PANIER</h4>
                  </div>
              </div> <!-- //. cart product -->
          </div><!-- //. bottom content -->
      </div>
      <!-- cart sidebar area end -->
    @endif
