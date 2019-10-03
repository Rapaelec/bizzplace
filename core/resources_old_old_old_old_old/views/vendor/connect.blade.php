@extends('layout.master')

@section('title', 'Inscription Vendeur')

@section('headertxt')
  Inscription Vendeur
@endsection


@section('content')

 <!-- login page content area start -->
<div class="login-page-content-area" >
<div class="container">
<div class="row">
<div class="col-md-12">
@if(session()->has('missmatch'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert" style="padding: 20px;font-size: 12px;">
  {{session('missmatch')}}
  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
  <span aria-hidden="true">&times;</span>
  </button>
  </div>
 @endif
 @if (session()->has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" style="padding: 40px;font-size: 20px;">
      <strong>Success!</strong> {{session('message')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
 @endif
 </div>
</div>
</div>
  <h2 class="title" style="text-align:center">{{ __("Choisir votre profil d'inscription") }} {{$gs->website_title}}</h2>
      <div class="container">
          <div class="row">
            <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                  <a class="nav-link active" id="particulier-tab" data-toggle="tab" href="#particulier" role="tab" aria-controls="particulier" aria-selected="true">Particulier</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link"  id="entreprise-tab" data-toggle="tab" href="#entreprise" role="tab" aria-controls="entreprise" aria-selected="false">Entreprise</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" id="professionnel-tab" data-toggle="tab" href="#professionnel" role="tab" aria-controls="professionnel" aria-selected="false">Professionnel</a>
                </li>
              </ul>
              <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="particulier" role="tabpanel" aria-labelledby="particulier-tab">
                <div class="row">
              <div class="col-lg-12">
                  <div class="signup-page-wrapper"><!-- login page wrapper -->
                      <div class="or">
                          <span>OU</span>
                      </div>
                      <div class="row">
                      <div class="col-lg-6">
                              <div class="right-contnet-area">
                                  <div class="top-content">
                                      <h4 class="title">Connexion au compte</h4>
                                  </div>
                                  <div class="bottom-content">
                                      <form action="{{route('user.authenticate')}}" method="post" class="login-form">
                                        {{csrf_field()}}
                                          <div class="form-element">
                                              <input type="text" name="utilisateur" value="{{old('username')}}" class="input-field" placeholder="Nom utilisateur">
                                              @if ($errors->has('utilisateur'))
                                                <p class="text-danger">{{$errors->first('utilisateur')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="mot_de_passe" class="input-field" placeholder="Mot de passe">
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
                                                <a href="{{ url('auth/facebook') }}" class="facebook">Connectez-vous avec facebook</a>
                                            </div>
                                          @endif

                                      </form>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-6">
                                    <div class="right-contnet-area">
                                        <div class="top-content">
                                            <h4 class="title">S'inscrire sur Bizzplace</h4>
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
                <div class="tab-pane fade" id="entreprise" role="tabpanel" aria-labelledby="entreprise-tab">
                <div class="col-lg-12">
                  <div class="signup-page-wrapper"><!-- login page wrapper -->
                      <div class="or">
                          <span>OU</span>
                      </div>
                      <div class="row">
                      <div class="col-lg-6">
                              <div class="right-contnet-area">
                                  <div class="top-content">
                                      <h4 class="title">Connexion au compte</h4>
                                  </div>
                                  <div class="bottom-content">
                                      <form action="{{route('user.authenticate')}}" method="post" class="login-form">
                                        {{csrf_field()}}
                                          <div class="form-element">
                                              <input type="text" name="utilisateur" value="{{old('username')}}" class="input-field" placeholder="Nom utilisateur">
                                              @if ($errors->has('utilisateur'))
                                                <p class="text-danger">{{$errors->first('utilisateur')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="mot_de_passe" class="input-field" placeholder="Mot de passe">
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
                                                <a href="{{ url('auth/facebook') }}" class="facebook">Connectez-vous avec facebook</a>
                                            </div>
                                          @endif

                                      </form>
                                  </div>
                              </div>
                          </div>
                          <div class="col-lg-6">
                                    <div class="right-contnet-area">
                                        <div class="top-content">
                                            <h4 class="title">S'inscrire sur Bizzplace</h4>
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
                                                <div class="form-element">
                                                    <input type="text" name="reason_social" class="input-field" value="{{old('reason_social')}}" placeholder="Raison Sociale">
                                                    @if ($errors->has('reason_social'))
                                                        <p class="text-danger">{{$errors->first('reason_social')}}</p>
                                                    @endif
                                                </div>
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
                <div class="tab-pane fade" id="professionnel" role="tabpanel" aria-labelledby="professionnel-tab">
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
                                              <input type="email" name="email_vendor_authenticate" value="{{old('email')}}" class="input-field" placeholder="Email">
                                              @if ($errors->has('email_vendor_authenticate'))
                                                <p class="text-danger">{{$errors->first('email_vendor_authenticate')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="password" name="password_vendor_authenticate" class="input-field" placeholder="Entrer le mot de passe">
                                              @if ($errors->has('password_vendor_authenticate'))
                                                <p class="text-danger">{{$errors->first('password_vendor_authenticate')}}</p>
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
                                              <input type="text" name="siret" class="input-field" value="{{old('siret')}}" placeholder="Entrer votre numéro siret">
                                              @if ($errors->has('siret'))
                                                <p class="text-danger">{{$errors->first('siret')}}</p>
                                              @endif
                                          </div>
                                          <div class="form-element">
                                              <input type="text" name="address" class="input-field" value="{{old('address')}}" placeholder="Entrer votre addresse">
                                              @if ($errors->has('address'))
                                                <p class="text-danger">{{$errors->first('address')}}</p>
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
      </div>
  </div>
  <!-- login page content area end -->

@endsection