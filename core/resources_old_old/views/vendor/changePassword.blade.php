@extends('layout.master')

@section('title', 'Changer mot de passe')

@section('headertxt', 'Changer mot de passe')


@section('content')

  <!-- product upload area start -->
  <div class="product-upload-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-6 offset-lg-3">
                <div class="card">
                  <div class="card-header base-bg">
                    <h4 class="mb-0 text-white">{{ __('Changer votre mot de passe') }}</h4>
                  </div>
                  <div class="card-body">
                    <div class="product-upload-inner"><!-- product upload inner -->
                        <form class="product-upload-form" method="post" action="{{route('vendor.updatePassword')}}">
                            {{csrf_field()}}

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-element margin-bottom-20">
                                    <label>{{ __('Ancien mot de passe') }}<span>**</span></label>
                                    <input name="old_password" type="text" class="input-field" placeholder="{{ __('Ancien mot de passe') }}...">
                                    @if ($errors->has('old_password'))
                                        <span style="color:red;">
                                            <strong>{{ $errors->first('old_password') }}</strong>
                                        </span>
                                    @else
                                        @if ($errors->first('oldPassMatch'))
                                            <span style="color:red;">
                                                <strong>{{ __('Ancien mot de passe ne correspond pas avec le mot de passe existant') }}</strong>
                                            </span>
                                        @endif
                                    @endif
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-element margin-bottom-20">
                                    <label>{{ __('Nouveau mot de passe') }}<span>**</span></label>
                                    <input name="password" type="text" class="input-field" placeholder="{{ __('Nouveau mot de passe') }}">
                                    @if ($errors->has('password'))
                                        <span style="color:red;">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-element margin-bottom-20">
                                    <label>{{ __('Confirmer votre mot de passe') }} <span>**</span></label>
                                    <input name="password_confirmation" type="text" class="input-field" placeholder="{{ __('Confirmer votre mot de passe') }}">
                                </div>
                              </div>
                            </div>

                            <div class="btn-wrapper">
                                <input type="submit" class="submit-btn" value="Submit">
                            </div>
                        </form>
                    </div><!-- //.product upload inner -->
                  </div>
                </div>

              </div>
          </div>
      </div>
  </div>
  <!-- product upload area end -->


@endsection
