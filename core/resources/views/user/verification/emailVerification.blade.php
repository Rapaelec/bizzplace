@extends('layout.master')

@section('title', 'Email Verification')

@section('headertxt', 'Email Verification')

@section('content')

    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3 py-5">
          <div class="login-header">
            <h4 style="">Un code a été envoyé à votre adresse e-mail, veuillez vérifier votre compte e-mail.</h4>
          </div>
          <div class="login-form">
            @if (session()->has('error'))
              <div class="alert alert-danger" role="alert">
                {{session('error')}}
              </div>
            @endif
            <form action="{{route('user.checkEmailVerification')}}" method="POST">
              {{csrf_field()}}
              <div class="form-element margin-bottom-20">
                  <label>Email <span>**</span></label>
                  <input style="border: 1px solid #ddd;" name="email" type="text" value="{{Auth::user()->email}}" class="input-field" readonly>
              </div>
              <div class="form-element margin-bottom-20">
                <label>Verification Code <span>**</span></label>
                <input style="border: 1px solid #ddd;" name="email_ver_code" type="text" value="" class="input-field" placeholder="Entrez votre code de vérification ...">
                @if ($errors->has('email_ver_code'))
                    <span style="color:red;">
                        <strong>{{ $errors->first('email_ver_code') }}</strong>
                    </span>
                @endif
              </div>
              <div class="btn-wrapper text-center">
                  <input type="submit" class="submit-btn" value="Envoyer">
              </div>
            </form>
            <form action="{{route('user.sendVcode')}}" method="POST" class="mt-2">
                {{csrf_field()}}
                  <input type="hidden" name="email" value="{{Auth::user()->email}}" placeholder="" class="input-field-square">
                  <div class="text-center">
                  Si vous n'avez pas reçu de courrier <button class="btn btn-link" type="submit">cliquez ici</button> renvoyer
                  </div>
            </form>
          </div>
        </div>
      </div>
    </div>

@endsection
