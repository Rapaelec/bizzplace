@extends('layout.master')

@section('title', 'Register and login')

@section('headertxt')
Inscription et Connection
@endsection


@section('content')
  <!-- login page content area start -->
  <div class="login-page-content-area">
  <h2 class="title" style="text-align:center">S'inscrire sur {{$gs->website_title}}</h2>
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="padding: 40px;font-size: 20px;">
                      <strong>Success!</strong> {{session('success')}}
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
                                <div class="right-contnet-area">
                                  <div class="top-content">
                                      <h4 class="title">Connexion au compte Utilisateur sur Bizzplace</h4>
                                  </div>
                                  <div class="bottom-content">
                                  @if(session()->has('missmatch'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 20px;font-size: 12px;">
                                        {{session('missmatch')}}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                  @endif
                                      <form action="{{route('user.authenticate')}}" method="post" class="login-form">
                                        {{csrf_field()}}
                                          <div class="form-element">
                                              <input type="text" name="utilisateur" value="{{old('username')}}" class="input-field utilisateur" placeholder="Nom utilisateur">
                                              @if ($errors->has('utilisateur'))
                                                <p class="text-danger">{{$errors->first('utilisateur')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="mot_de_passe" class="input-field mot_de_passe" placeholder="Mot de passe">
                                              @if ($errors->has('mot_de_passe'))
                                                <p class="text-danger">{{$errors->first('mot_de_passe')}}</p>
                                              @endif
                                          </div>
                                          <div class="btn-wrapper">
                                              <button type="submit" class="submit-btn">Se connecter</button>
                                              <a href="{{route('user.showEmailForm')}}" class="link">Mot de passe oublié ?</a>
                                          </div>
                                          @if (\App\Provider::find(1)->status == 1)
                                            <div class="block-link mt-4">
                                                <a href="{{ url('auth/facebook') }}" class="facebook">Connectez-vous avec Facebook</a>
                                            </div>
                                          @endif

                                      </form>
                                  </div>
                              </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="right-contnet-area">
                                        <div class="top-content">
                                            <h4 class="title">Inscription Utilisateur sur Bizzplace</h4>
                                        </div>
                                        <div class="bottom-content">
                                            <form action="{{route('user.register')}}" method="post" class="login-form">
                                                {{csrf_field()}}
                                                <div class="form-element">
                                                    <input type="text" name="username" class="input-field" value="{{old('username')}}" placeholder="Votre nom d'utilisateur">
                                                    @if ($errors->has('username'))
                                                        <p class="text-danger">{{$errors->first('username')}}</p>
                                                    @endif
                                                </div>
                                                @if(Route::is('user.showregform.entreprise'))
                                                <div class="form-element">
                                                    <input type="text" name="reason_social" class="input-field" value="{{old('reason_social')}}" placeholder="Raison Sociale">
                                                    @if ($errors->has('reason_social'))
                                                        <p class="text-danger">{{$errors->first('reason_social')}}</p>
                                                    @endif
                                                </div>
                                                @endif
                                                <div class="form-element">
                                                    <input type="email" name="email" class="input-field" value="{{old('email')}}" placeholder="Entrer votre email">
                                                    @if ($errors->has('email'))
                                                        <p class="text-danger">{{$errors->first('email')}}</p>
                                                    @endif
                                                </div>
                                                <div class="form-element">
                                                    <input type="text" name="phone" class="input-field" value="{{old('phone')}}" placeholder="Entrer votre numéro de téléphone">
                                                    @if ($errors->has('phone'))
                                                        <p class="text-danger">{{$errors->first('phone')}}</p>
                                                    @endif
                                                </div>
                                                <div class="form-element">
                                                    <input type="password" name="password" class="input-field" placeholder="Mot de passe ">
                                                </div>
                                                <div class="form-element">
                                                    <input type="password" name="password_confirmation" class="input-field" placeholder="Confirmer votre mot de passe">
                                                    @if ($errors->has('password'))
                                                        <p class="text-danger">{{$errors->first('password')}}</p>
                                                    @endif
                                                </div>
                                                <div class="btn-wrapper">
                                                    <button type="submit" class="submit-btn">S'inscrire</button>
                                                </div>
                                                @if (\App\Provider::find(1)->status == 1)
                                                    <div class="block-link mt-4">
                                                        <a href="{{ url('auth/facebook') }}" class="facebook">Nous rejoindre avec Facebook</a>
                                                    </div>
                                                @endif
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


 

