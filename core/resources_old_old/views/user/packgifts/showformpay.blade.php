@extends('layout.master')

@push('styles')
  <style media="screen">
  .package-container {
    padding: 50px 0px;
  }
  .package-container h2 {
    margin-bottom: 20px;
    font-size: 40px;
  }
  .package-desc {
    min-height: 220px;
  }
  h5.card-title {
    margin: 0px;
    text-align: center;
  }
  </style>
@endpush

@section('title', 'Souscriptions Pack Cadeaux')

@section('headertxt', 'Inscription et paiement du Pack Cadeaux')

@section('content')
      <!-- product upload area start -->
  <div class="product-upload-area" id="uploadDiv">
      <div class="container">
        <center><h3>Achat du {{ $packgifts->title }} </h3></center><br>
          <div class="row">
              <div class="col-lg-12">
                  <div class="product-upload-inner"><!-- product upload inner -->
                      <form id="uploadForm" method="post" action="{{ route('user.cartgift.store') }}" class="product-upload-form" enctype="multipart/form-data">
                        {{ csrf_field() }}   
                      <input type="hidden" name="id_pack" value="{{ $packgifts->id }}">
                        <div class="row">
                            <div class="col-md-6">
                              <div class="card">
                                <div class="card-header base-bg">
                                  <h3 class="text-white mb-0">Vos informations personnelles</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-element margin-bottom-20">
                                              <label>Nom <span>**</span></label>
                                              <input name="user_name" required type="text" class="form-control" placeholder="Entrer votre nom...">
                                              <p id="errtitle" class="em no-margin text-danger"></p>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-element margin-bottom-20">
                                                <label>Prenom<span>**</span></label>
                                                <input name="user_lastname" required type="text" class="form-control" placeholder="Entrer votre prenom...">
                                                <p id="errquantity" class="em no-margin text-danger"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                          <div class="form-element margin-bottom-20">
                                              <label>Téléphone <span>**</span></label>
                                              <input name="user_phone" required type="text" class="form-control" placeholder="Entrer votre numéro de téléphone">
                                              <p id="errtitle" class="em no-margin text-danger"></p>
                                          </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-element margin-bottom-20">
                                                <label>Email<span>**</span></label>
                                                <input name="user_email" type="email" required class="form-control" placeholder="Entrer votre email ...">
                                                <p id="errquantity" class="em no-margin text-danger"></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-12">
                                        <div class="form-element margin-bottom-20">
                                        <label>Moyen de paiement <span>**</span></label>
                                        <select name="moyen_paiment" class="form-control">
                                          @foreach ($gateways as $gateway)
                                          <option value="{{ $gateway->id }}">{{ $gateway->name }}</option>
                                          @endforeach
                                        </select>
                                        </div>  
                                      </div>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="card">
                                  <div class="card-header base-bg">
                                    <h3 class="text-white mb-0">Informations du Bénéficiaire</h3>
                                  </div>
                                  <div class="card-body">
                                      <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-element margin-bottom-20">
                                                <label>Nom <span>**</span></label>
                                                <input name="beneficiary_name" type="text" class="form-control" required placeholder="Nom bénéficiaire ...">
                                                <p id="errtitle" class="em no-margin text-danger"></p>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-element margin-bottom-20">
                                                  <label>Prenom<span>**</span></label>
                                                  <input name="beneficiary_lastname" type="text" class="form-control" required placeholder="Prenom bénéficiaire ...">
                                                  <p id="errquantity" class="em no-margin text-danger"></p>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-6">
                                            <div class="form-element margin-bottom-20">
                                                <label>Téléphone <span>**</span></label>
                                                <input name="beneficiary_phone" type="text" class="form-control"required placeholder="Téléphone bénéficiaire ...">
                                                <p id="errtitle" class="em no-margin text-danger"></p>
                                            </div>
                                          </div>
                                          <div class="col-md-6">
                                              <div class="form-element margin-bottom-20">
                                                  <label>Email<span>**</span></label>
                                                  <input name="beneficiary_email" type="email" required class="form-control" placeholder="Email bénéficiaire ...">
                                                  <p id="errquantity" class="em no-margin text-danger"></p>
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                          <div class="col-md-12">
                                              <div class="form-element margin-bottom-20">
                                                  <label>Mot de passe provisoir <span>**</span></label>
                                                  <input type="password" name="beneficiary_password" required id="password_provisoir" class="form-control">
                                              </div>
                                          </div>
                                      </div>
                                      <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-element margin-bottom-20">
                                                <label>Message <span>**</span></label>
                                                <textarea name="beneficiary_message" style="width:100%;height:2%" required class="form-control" placeholder="Entrer votre message"></textarea>
                                                <p id="errtitle" class="em no-margin text-danger"></p>
                                            </div>
                                        </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                            <br>
                          <div class="btn-wrapper mt-4">
                              <input type="submit" class="form-control btn-primary" value="Payer">
                          </div>
                      </form>
                  </div><!-- //.product upload inner -->
              </div>
          </div>
      </div>
  </div>
  <!-- product upload area end -->
@endsection