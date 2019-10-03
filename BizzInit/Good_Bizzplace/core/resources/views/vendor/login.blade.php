@extends('layout.master')

@section('title', 'Login Vendeur')

@section('headertxt')
Login Vendeur 
@endsection

@section('content')
  <!-- login page content area start -->
  <div class="login-page-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  @if (session()->has('missmatch'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 40px;font-size: 20px;">
                      {{session('missmatch')}}
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
                              <div class="left-content-area" style="padding: 80px;">
                                  <div class="top-content">
                                      <h4 class="title">Se connecter à {{$gs->website_title}}</h4>
                                  </div>
                                  <div class="bottom-content">
                                    <div class="bottom-content">
                                        {!! $gs->vendor_login_text !!}
                                    </div>
                                  </div>
                                  <p><strong>Vous n'avez pas encore de compte ? <a style="color:red;font-weight:bold;" href="{{route('vendor.showRegForm')}}">
                                  Cliquez ici</a> pour en créer un</strong></p>
                              </div>
                          </div>
                          <div class="col-lg-6">
                              <div class="right-contnet-area">
                                  <div class="top-content">
                                      <h4 class="title">Connexion au compte</h4>
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
                                              <input type="password" name="password" class="input-field" placeholder="Mot de passe">
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
                      </div>
                  </div><!-- //.login page wrapper -->
              </div>
          </div>
      </div>
  </div>
  <!-- login page content area end -->
@endsection
