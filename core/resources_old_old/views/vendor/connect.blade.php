@extends('layout.master')

@section('title', 'Inscription Vendeur')

@section('headertxt')
  Inscription Vendeur
@endsection


@section('content')

 <!-- login page content area start -->
<div class="login-page-content-area">
  <h2 class="title" style="text-align:center">{{ __("Choisir votre profil d'inscription") }} {{$gs->website_title}}</h2>
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
                          <span>Ou</span>
                      </div>
                      <div class="row">
                        <div class="col-lg-6">
                          <img src="{{ asset('assets/user/img/vendeur_particulier.png') }}" alt="" class="img-fluid rounded">
                          <div class="left-content-area" style="padding: 80px">
                              <!-- <div class="top-content">
                                <h4 class="title">S'inscrire en tant que vendeur Particulier</h4>
                              </div>
                              <div class="bottom-content">
                                {!! $gs->vendor_login_text !!}
                              </div> -->
                              
                              <button class="btn btn-primary btn-block"><a href="{{route('vendor.showRegForm')}}" class="text-white font-weight-bold">Particulier</a> </button>
                            </div>
                          </div>
                          <div class="col-lg-6">
                              <img src="{{ asset('assets/user/img/vendeur_professionnel.png') }}" alt="" class="img-fluid rounded">
                              <div class="left-content-area" style="padding: 80px;">
                              <!-- <div class="bottom-content">
                              {!! $gs->vendor_login_text !!}
                              </div> -->
                              <button class="btn btn-primary btn-block"><a href="{{route('vendor.showRegForm')}}" class="text-white font-weight-bold">Professionnel </a></button>
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