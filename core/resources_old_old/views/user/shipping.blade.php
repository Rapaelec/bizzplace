@extends('layout.profilemaster')

@section('title', 'Adresse de livraison')

@section('headertxt', 'Adresse de livraison')

@section('content')
<div class="row">
  <div class="col-md-9">
    <h3>Adresse de livraison</h3>
  </div>
  <div class="col-md-2">
    <a href="#" class="btn btn-primary btn_loading" onclick="loadingInfo(event)">Charger mes données</a>
  </div>
</div>
    <hr>
    <form action="{{route('user.shippingupdate')}}" method="post">
      @csrf
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Nom</label>
            <input type="text" name="shipping_first_name" class="form-control" id="shipping_first_name" placeholder="Nom">
            @if ($errors->has('shipping_first_name'))
              <p class="text-danger">{{$errors->first('shipping_first_name')}}</p>
            @endif
          </div>            
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Prénom</label>
            <input type="text" name="shipping_last_name" class="form-control" id="shipping_last_name" placeholder="Prenom">
            @if ($errors->has('shipping_last_name'))
              <p class="text-danger">{{$errors->first('shipping_last_name')}}</p>
            @endif
          </div>            
        </div>    
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Numéro de téléphone </label>
            <input type="text" name="shipping_phone" class="form-control" id="shipping_phone" placeholder="+33 000 000 000">
            @if ($errors->has('shipping_phone'))
              <p class="text-danger">{{$errors->first('shipping_phone')}}</p>
            @endif
          </div>  
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Adresse Email </label>
            <input type="text" name="shipping_email" class="form-control" id="shipping_email" placeholder="Adresse email">
            @if ($errors->has('shipping_email'))
              <p class="text-danger">{{$errors->first('shipping_email')}}</p>
            @endif
          </div>            
        </div>    
      </div>
    
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Adresse</label>
            <input type="text" name="address" class="form-control" id="address" placeholder="Adresse" value="{{ Auth::user()->address}}">
            @if ($errors->has('address'))
              <p class="text-danger">{{$errors->first('address')}}</p>
            @endif
          </div>            
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Pays</label>
            <select class="form-control" id="country" name="country">
              <option value="" selected disabled>Sélectionner un pays</option>
              @foreach ($countries as $country)
                <option value="{{$country}}" {{Auth::user()->country == $country ? 'selected' : ''}}>{{$country}}</option>
              @endforeach
            </select>
            @if ($errors->has('country'))
              <p class="text-danger">{{$errors->first('country')}}</p>
            @endif
          </div>            
        </div>    
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Etat</label>
            <input type="text" name="state" class="form-control" id="state" placeholder="Etat" value="{{Auth::user()->state}}">
            @if ($errors->has('state'))
              <p class="text-danger">{{$errors->first('state')}}</p>
            @endif
          </div>            
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Ville</label>
            <input type="text" name="city" class="form-control" id="city" placeholder="Ville" value="{{Auth::user()->city}}">
            @if ($errors->has('city'))
              <p class="text-danger">{{$errors->first('city')}}</p>
            @endif
          </div>  
        </div>    
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label for="">Code Zip/Postal </label>
            <input type="text" name="zip_code" class="form-control" id="zip_code" placeholder="Code zip" value="{{Auth::user()->zip_code}}">
            @if ($errors->has('zip_code'))
              <p class="text-danger">{{$errors->first('zip_code')}}</p>
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
