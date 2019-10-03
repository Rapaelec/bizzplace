@extends('layout.profilemaster')

@section('title', 'Mot de passe')

@section('headertxt', 'Changer votre mot de passe')

@section('content')

    <h3>Changer votre mot de passe</h3>
    <hr>
    <form method="post" action="{{route('user.updatePassword')}}">
      {{csrf_field()}}
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Ancien mot de passe:</label>
            <input type="password" name="old_password" value="" class="form-control" placeholder="Ancien mot de passe">
            @if ($errors->has('old_password'))
                <span style="color:red;">
                    <strong>{{ $errors->first('old_password') }}</strong>
                </span>
            @else
                @if ($errors->first('oldPassMatch'))
                    <span style="color:red;">
                        <strong>Le mot de passe entré ne correspond pas à l'ancien</strong>
                    </span>
                @endif
            @endif
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Nouveau mot de passe:</label>
            <input type="password" name="password" value="" class="form-control" placeholder="Nouveau mot de passe">
            @if ($errors->has('password'))
                <span style="color:red;">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Confirmer le mot de passe:</label>
            <input type="password" name="password_confirmation" value="" class="form-control" placeholder="Confirmer le mot de passe">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">
          <button type="submit" class="btn base-bg white-txt">Mise à jour du mot de passe</button>
        </div>
      </div>
    </form>
@endsection
