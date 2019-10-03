@extends('layout.profilemaster')

@section('title', 'Information Personnelle')

@section('headertxt', 'Information Personnelle')

@section('content')
    <h3>Information Personnelle</h3>
    <hr>
    <form class="" action="{{route('user.information.update')}}" method="post">
      @csrf
      <div class="row">
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Nom</label>
                <input type="text" name="first_name" class="form-control" id="" placeholder="Nom" value="{{ Auth::user()->first_name}}">
                @if ($errors->has('first_name'))
                  <p class="text-danger">{{$errors->first('first_name')}}</p>
                @endif
              </div> 
          </div>
          <div class="col-md-6">
              <div class="form-group">
                <label for="">Prenom</label>
                <input type="text" name="last_name" class="form-control" id="" placeholder="Prenom" value="{{Auth::user()->last_name}}">
                @if ($errors->has('last_name'))
                  <p class="text-danger">{{$errors->first('last_name')}}</p>
                @endif
              </div>
          </div>
      </div>
      
      <div class="row">
          <div class="col-md-6">
          <div class="form-group">
                <label for="">Genre</label>
                <select class="form-control" name="gender">
                  <option value="" selected disabled>Sélectionner Genre</option>
                  <option value="Mme" {{Auth::user()->gender == 'Mme' ? 'selected' : ''}}>Mme</option>
                  <option value="Mlle" {{Auth::user()->gender == 'Mlle' ? 'selected' : ''}}>Mlle</option>
                  <option value="Mr" {{Auth::user()->gender == 'Mr' ? 'selected' : ''}}>Mr</option>
                </select>
                @if ($errors->has('gender'))
                  <p class="text-danger">{{$errors->first('gender')}}</p>
                @endif
          </div>
          </div> 
          <div class="col-md-6">
            <div class="form-group">
                <label for="">Date de naissance</label>
                <input type="date" name="date_of_birth" class="form-control" id="" placeholder="Date de naissance" value="{{Auth::user()->date_of_birth}}">
                @if ($errors->has('date_of_birth'))
                  <p class="text-danger">{{$errors->first('date_of_birth')}}</p>
                @endif
              </div>   
          </div>
      </div>
      <div class="row">
          <div class="col-md-6">
             <div class="form-group">
                <label for="">Téléphone</label>
                <input name="phone" type="text" class="form-control" id="" placeholder="+33 000 000 000" value="{{Auth::user()->phone}}">
                @if ($errors->has('phone'))
                  <p class="text-danger">{{$errors->first('phone')}}</p>
                @endif
              </div>            
          </div>          

          <div class="col-md-6">
            <div class="form-group">
                <label for="">Email</label>
                <input type="email" name="email" class="form-control" id="" placeholder="" value="{{Auth::user()->email}}" readonly>
            </div>  
          </div>
      </div>  
      <div class="row">
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
      <div class="form-group text-center">
        <input type="submit" class="btn base-bg white-txt" value="Mise à jour information">
      </div>
    </form>
    <br>

@endsection
