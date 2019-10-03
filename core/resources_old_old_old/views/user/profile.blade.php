@extends('layout.profilemaster')

@if(Auth::user()->reason_social!='')
@section('title', 'Information Entreprise')
@section('headertxt', 'Information Entreprise')
@else
@section('title', 'Information Personnelle')
@section('headertxt', 'Information Personnelle')
@endif

@section('content')
    <h3>Information @if(Auth::user()->reason_social!='') Entreprise @else Personnelle @endif</h3>
    <hr>
    <form class="" action="{{route('user.information.update')}}" method="post" enctype="multipart/form-data">
      @csrf
      @if(Auth::user()->reason_social!='')
      <div class="row">
      <div class="form-element margin-bottom-20">
         <div class="fileinput fileinput-new" data-provides="fileinput">
             <div class="fileinput-new thumbnail">
               @if (empty(Auth::user()->logo))
                 <img src="{{asset('assets/user/img/shop-logo/nopic.jpg')}}" alt="" />
               @else
                 <img src="{{asset('assets/user/img/shop-logo/'.Auth::user()->logo)}}" alt="" />
               @endif
             </div>
             <div class="fileinput-preview fileinput-exists thumbnail" style="width: 250px;"> </div>
             <div>
                 <span class="btn btn-success btn-file">
                     <span class="fileinput-new"> Choisissez votre Logo </span>
                     <span class="fileinput-exists">Changez </span>
                     <input name="logo" type="file" value="">
                 </span>
                 <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput">Retirer</a>
                 <label style="display:inline-block;" for=""><span>**</span></label>
             </div>
         </div>
         @if ($errors->has('logo'))
           <p class="text-danger">{{$errors->first('logo')}}</p>
         @endif
      </div>
      </div>
      @endif
      @if(empty(Auth::user()->reason_social))
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
      @else
      <div class="row">
        <div class="col-md-6">
         <div class="form-group">
          <label for="Raison Social">Raison Social</label>
            <input type="text" name="reason_social" id="reason_social" class="form-control" value="{{Auth::user()->reason_social}}">
            @if ($errors->has('reason_social'))
                  <p class="text-danger">{{$errors->first('reason_social')}}</p>
            @endif
          </div>
        </div>
      </div>
      <div class="row">
          <div class="col-md-6">
            <div class="form-group">
             <label for="siret">Numéro Siret</label>
             <input type="text" name="siret" id="siret" value="{{Auth::user()->siret}}" class="form-control" placeholder="numéro siret">
            @if ($errors->has('siret'))
              <p class="text-danger">{{$errors->first('siret')}}</p>
            @endif
          </div>
          </div>
          
        <div class="col-md-6">
          <div class="form-group">
            <label for="siren">Numéro siren</label>
            <input type="text" name="siren" id="siren"  class="form-control" value="{{Auth::user()->siren}}" placeholder="numéro siren">
            @if ($errors->has('siren'))
              <p class="text-danger">{{$errors->first('siren')}}</p>
            @endif
          </div>
        </div>
      </div> 
      @endif
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
