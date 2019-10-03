@extends('layout.master')

@section('title', 'Réinitialiser mot de passe')

@section('headertxt', 'Réinitialiser mot de passe'')

@section('content')
  <!-- Login Section Start -->
<div class="container">
  <div class="row">
    <div class="col-md-6 offset-md-3" style="padding:50px 0px;">
      <div class="card">
        <div class="card-header base-bg">
          <h3 class="text-white mb-0">Réinitialiser votre mot de passe</h3>
        </div>
        <div class="card-body">
          <div class="">
            <form action="{{route('user.resetPassword')}}" method="post">
              {{csrf_field()}}
              <input type="hidden" name="code" value="{{$code}}">
              <input type="hidden" name="email" value="{{$email}}">

              <div class="form-element margin-bottom-20">
                  <label>Nouveau mot de passe <span>**</span></label>
                  <input style="border: 1px solid #ddd;" name="password" type="password" value="" class="input-field" placeholder="Nouveau mot de passe">
                  @if ($errors->has('password'))
                      <span style="color:red;">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                  @endif
              </div>

              <div class="form-element margin-bottom-20">
                  <label>Confirmer votre mot de passe<span>**</span></label>
                  <input style="border: 1px solid #ddd;" name="password_confirmation" type="password" value="" class="input-field" placeholder="Confirmer votre mot de passe">
                  @if ($errors->has('password_confirmation'))
                      <span style="color:red;">
                          <strong>{{ $errors->first('password_confirmation') }}</strong>
                      </span>
                  @endif
              </div>
              <div class="btn-wrapper text-center">
                  <input type="submit" class="submit-btn" value="Mise à jour mot de passe">
              </div>
            </form>
          </div>
        </div>
      </div>

      </div>
  </div>
</div>
@endsection
