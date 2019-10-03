<!-- footer area one start -->
<footer class="footer-arae-one">
    <div class="footer-top-one blue-bg"><!-- footer top one-->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="footer-widget about">
                        <div class="widget-body">
                            <a href="{{route('user.home')}}" class="footer-logo">
                                <img src="{{asset('assets/user/interfaceControl/logoIcon/footer_logo.jpg')}}" alt="footer-logo">
                            </a>
                            <ul class="contact-info-list">
                                <li>
                                    <div class="single-contact-info">
                                        <div class="icon">
                                                <i class="fas fa-map-marker-alt"></i>
                                        </div>
                                        <div class="content">
                                            <span class="details">{{$gs->con_address}}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-contact-info">
                                        <div class="icon">
                                                <i class="fas fa-envelope"></i>
                                        </div>
                                        <div class="content">
                                            <span class="details">{{$gs->con_email}}</span>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="single-contact-info">
                                        <div class="icon">
                                                <i class="fas fa-phone"></i>
                                        </div>
                                        <div class="content">
                                            <span class="details">{{$gs->con_phone}}</span>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h4 class="title">MENU</h4>
                        </div>
                        <div class="widget-body">
                            <ul class="page-list">
                                <li><a href="{{route('user.home')}}">--  Accueil</a></li>
                                <li><a href="{{route('user.search')}}">--  Cartes cadeaux</a></li>
                                <li><a href="{{route('vendor.login')}}">--  Annuaires</a></li>
                                <li><a href="{{route('user.wishlist')}}">--  Bon plans</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h4 class="title">Information</h4>
                        </div>
                        <div class="widget-body">
                            <ul class="page-list">
                                <li><a href="{{route('privacy')}}">-- Politique de confidentialité</a></li>
                                <li><a href="{{route('terms')}}">--  Termes & Conditions</a></li>
                                @foreach ($menus as $key => $menu)
                                  <li><a href="{{route('user.dynamicPage', $menu->slug)}}">--  {{$menu->name}}</a></li>
                                @endforeach
                                <li><a href="{{route('user.contact')}}">--  Nous Contacter</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5 col-md-6">
                    <div class="footer-widget">
                        <div class="widget-title">
                            <h4 class="title">Newsletter</h4>
                        </div>
                        <div class="widget-body">
                          <div class="coupon-code-wrapper">
                            <form onsubmit="subscribe(event)" id="subscribeForm">
                              {{csrf_field()}}
                              <div class="form-element">
                                  <input id="mail" name="email" type="text" class="input-field" placeholder="Adresse email">
                              </div>
                              <button type="submit" class="submit-btn">Souscrire</button>
                            </form>

                          </div>
                        </div>
                        <div class="widget-title" style="margin-bottom: 0px; margin-top:20px;">
                            <h4 class="title">{{-- Follow Us --}}</h4>
                        </div>
                        <div class="widget-body">
                          <ul class="social-links">
                            @foreach ($socials as $key => $social)
                              <li>
                                <a href="{{$social->url}}"><i class="fab fa-{{$social->fontawesome_code}}"></i></a>
                              </li>
                            @endforeach
                          </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- //.footer top one -->
    <div class="copyright-area blue-bg"><!-- copyright area -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="copyright-inner"><!-- copyright inner -->
                        <div class="text-center">
                            <span class="copyright-text text-white">{{$gs->footer}}</span>
                        </div>
                    </div><!-- //. copyright inner -->
                </div>
            </div>
        </div>
    </div><!-- //. copyright area -->
</footer>
<!-- footer area one end -->
