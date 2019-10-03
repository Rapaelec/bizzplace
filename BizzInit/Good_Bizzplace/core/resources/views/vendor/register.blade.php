@extends('layout.master')

@section('title', 'Vendeur Inscription')

@section('headertxt')
  Inscription Vendeur
@endsection


@section('content')
  <!-- login page content area start -->
  <div class="login-page-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  @if (session()->has('message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="padding: 40px;font-size: 20px;">
                      <strong>Success!</strong> {{session('message')}}
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>
                  @endif

                  <div class="signup-page-wrapper"><!-- login page wrapper -->
                      <div class="or">
                          <span>OU</span>
                      </div>
                      <div class="row">
                           <div class="col-lg-6">
                              <div class="right-contnet-area" style="padding: 80px;">
                                  <div class="top-content">
                                      <h5 class="title">Connexion au compte Vendeur sur Bizzplace</h5>
                                  </div>
                                  <div class="bottom-content">
                                      <form action="{{route('vendor.authenticate')}}" method="post" class="login-form">
                                        {{csrf_field()}}
                                          <div class="form-element">
                                              <input type="email" name="email" value="{{old('email')}}" class="input-field" placeholder="Email">
                                              @if ($errors->has('email'))
                                                <p class="text-danger">{{$errors->first('email')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="password" class="input-field" placeholder="Entrer le mot de passe">
                                              @if ($errors->has('password'))
                                                <p class="text-danger">{{$errors->first('password')}}</p>
                                              @endif
                                          </div>
                                          <div class="btn-wrapper">
                                              <button type="submit" class="submit-btn">Se connecter</button>
                                              <a href="{{route('vendor.showEmailForm')}}" class="link">Mot de passe oublié ?</a>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                             
                          </div>
                          <div class="col-lg-6">
                              <div class="right-contnet-area">
                                  <div class="top-content">
                                      <h4 class="title">Inscription Vendeur sur Bizzplace</h4>
                                  </div>
                                  <div class="bottom-content">
                                      <form action="{{route('vendor.reg')}}" method="post" class="login-form">
                                          {{csrf_field()}}
                                          <div class="form-element">
                                              <input type="email" name="email" class="input-field" value="{{old('email')}}" placeholder="Email">
                                              @if ($errors->has('email'))
                                                <p class="text-danger">{{$errors->first('email')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="text" name="shop_name" class="input-field" value="{{old('shop_name')}}" placeholder="Entrer le nom de votre boutique">
                                              @if ($errors->has('shop_name'))
                                                <p class="text-danger">{{$errors->first('shop_name')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="text" name="phone" class="input-field" value="{{old('phone')}}" placeholder="Entrer votre numéro de téléphone">
                                              @if ($errors->has('phone'))
                                                <p class="text-danger">{{$errors->first('phone')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="password" class="input-field" placeholder="Entrer votre mot de passe">
                                              @if ($errors->has('password'))
                                                <p class="text-danger">{{$errors->first('password')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="password_confirmation" class="input-field" placeholder="Entrer encore le mot de passe">
                                          </div>
                                          <div class="btn-wrapper">
                                              <button type="submit" class="submit-btn">S'inscrire</button>
                                          </div>
                                      </form>
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div><!-- //.login page wrapper -->
              </div>
          </div>
      </div>
  </div>
  <!-- login page content area end -->
@endsection
