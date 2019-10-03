@extends('layout.profilemaster')

@section('title', 'Adresse de Facturation')

@section('headertxt', 'Adresse de Facturation')

@section('content')
    <h3>Adresse de Facturation</h3>
    <hr>
    <form class="" action="{{route('user.billingupdate')}}" method="post">
      @csrf
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Nom</label>
                <input type="text" name="billing_first_name" class="form-control" id="" placeholder="Votre nom" value="{{Auth::user()->billing_first_name}}">
                @if ($errors->has('billing_first_name'))
                  <p class="text-danger">{{$errors->first('billing_first_name')}}</p>
                @endif
              </div> 
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Prenom</label>
                <input type="text" name="billing_last_name" class="form-control" id="" placeholder="Votre prenom" value="{{Auth::user()->billing_last_name}}">
                @if ($errors->has('billing_last_name'))
                  <p class="text-danger">{{$errors->first('billing_last_name')}}</p>
                @endif
              </div> 
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Numéro de téléphone</label>
                <input type="text" name="billing_phone" class="form-control" id="" placeholder="Téléphone" value="{{Auth::user()->billing_phone}}">
                @if ($errors->has('billing_phone'))
                  <p class="text-danger">{{$errors->first('billing_phone')}}</p>
                @endif
              </div>
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Adresse email</label>
                <input type="text" name="billing_email" class="form-control" id="" placeholder="Votre email" value="{{Auth::user()->billing_email}}">
                @if ($errors->has('billing_email'))
                  <p class="text-danger">{{$errors->first('billing_email')}}</p>
                @endif
              </div>              
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Adresse</label>
                <input type="text" name="billing_address" class="form-control" id="" placeholder="Votre adresse" value="{{Auth::user()->billing_address}}">
                @if ($errors->has('billing_address'))
                  <p class="text-danger">{{$errors->first('billing_address')}}</p>
                @endif
              </div>              
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Pays</label>
                <select class="form-control" name="billing_country">
                  <option value="" selected disabled>Select a country</option>
                  @foreach ($countries as $country)
                    <option value="{{$country}}" {{Auth::user()->billing_country == $country ? 'selected' : ''}}>{{$country}}</option>
                  @endforeach
                </select>
                @if ($errors->has('billing_country'))
                  <p class="text-danger">{{$errors->first('billing_country')}}</p>
                @endif
              </div> 
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Etat</label>
                <input type="text" name="billing_state" class="form-control" id="" placeholder="Votre Etat" value="{{Auth::user()->billing_state}}">
                @if ($errors->has('billing_state'))
                  <p class="text-danger">{{$errors->first('billing_state')}}</p>
                @endif
              </div>   
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Cité</label>
                <input type="text" name="billing_city" class="form-control" id="" placeholder="Votre cité" value="{{Auth::user()->billing_city}}">
                @if ($errors->has('billing_city'))
                  <p class="text-danger">{{$errors->first('billing_city')}}</p>
                @endif
              </div>
          </div>
      </div>      

      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Zip/Code postal</label>
                <input type="text" name="billing_zip_code" class="form-control" id="" placeholder="Votre code zip" value="{{Auth::user()->billing_zip_code}}">
                @if ($errors->has('billing_zip_code'))
                  <p class="text-danger">{{$errors->first('billing_zip_code')}}</p>
                @endif
              </div>
          </div>
      </div>   
      <div class="form-group text-center">
        <input type="submit" class="btn base-bg white-txt" value="Mise à jour">
      </div>
    </form>
    <br>
@endsection
