@extends('layout.master')

@section('title', 'annuaire')

@section('headertxt', 'Gestion des Annuaires')

@section('content')
<div class="product-upload-area" id="uploadDiv">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  @php
                    $vendor = Auth::guard('vendor')->user();
                  @endphp
                  <div id="successAlert" class="alert alert-success alert-dismissible fade show d-none">
                    <p><strong class="text-success">Votre package est valable jusqu'au {{date('j M, Y', strtotime($vendor->expired_date))}} et peut télécharger {{$vendor->products}} produits.</strong></p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  
                  <div id="dangerAlert" class="alert alert-danger alert-dismissible fade show d-none">
                    <p><strong class="text-danger">Vous devez acheter un package pour télécharger des produits.</strong></p>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  

                  <div class="product-upload-inner"><!-- product upload inner -->
                      <form id="uploadForm" class="product-upload-form" onsubmit="upload(event)" enctype="multipart/form-data">
                          {{csrf_field()}}
                          <div class="form-element margin-bottom-20">
                            <label for="" class="sec-txt">Aperçu des images<span>**</span></label>
                            <div class="">
                              <table class="table table-striped" id="imgtable">

                              </table>
                            </div>
                            <div class="form-group">
                              <label class="btn base-bg txt-white" style="width:200px;color:white;cursor:pointer;">
                                <input id="imgs" style="display:none;" type="file" />
                                <i class="fa fa-plus"></i> Ajouter une photo
                              </label>
                              <p class="no-margin"><small class="text-danger">Maximum 5 images, peuvent être téléchargées</small></p>
                              <p id="errpreimg" class="em no-margin text-danger"></p>
                            </div>

                          </div>

                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-element margin-bottom-20">
                                  <label>Titre <span>**</span></label>
                                  <input name="title" type="text" class="input-field" placeholder="Entrer le titre...">
                                  <p id="errtitle" class="em no-margin text-danger"></p>
                              </div>
                            </div>
                            <div class="col-md-6">
                              <div class="row">
                                <div class="col-md-6">
                                  <div class="form-element margin-bottom-20">
                                      <label>Stock (quantité) <span>**</span></label>
                                      <input name="quantity" type="text" class="input-field" placeholder="Entrer la quantité...">
                                      <p id="errquantity" class="em no-margin text-danger"></p>
                                  </div>
                                </div>
                                <div class="col-md-6">
                                  <div class="form-element margin-bottom-20">
                                      <label>Prix ({{$gs->base_curr_text}})<span>**</span></label>
                                      <input name="price" type="text" class="input-field" placeholder="Entrer le prix...">
                                      <p id="errprice" class="em no-margin text-danger"></p>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                          <div class="row">
                            <div class="col-md-4">
                              <div class="form-element margin-bottom-20">
                                  <label>Categories <span>**</span></label>
                                  <select name="category" type="text" class="input-field" v-model="catid" @change="showsubcats()">
                                    <option value="" selected disabled>Sélectionner une catégorie</option>
                                    @foreach ($cats as $cat)
                                      <option value="{{$cats->id}}">{{$cat->name}}</option>
                                    @endforeach
                                  </select>
                                  <input type="hidden" name="cat_helper" value="">
                                  <p id="errcat" class="em no-margin text-danger"></p>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-element margin-bottom-20">
                                  <label>Sous catégories <span>**</span></label>
                                  <select name="subcategory" type="text" class="input-field" v-model="subcatid" id="selsub" @change="showattrs()">
                                    <option value="" selected disabled>Sélectionner une sous catégorie</option>
                                  </select>
                                  <input type="hidden" name="subcat_helper" value="">
                                  <p id="errsubcat" class="em no-margin text-danger"></p>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-element margin-bottom-20">
                                  <label>Code produit<span>(Optional)</span></label>
                                  <input name="product_code" type="text" class="input-field" placeholder="Entrez le code produit ...">
                                  <small class="text-danger">Si vous ne spécifiez pas un code de produit unique, il sera généré automatiquement.</small>
                                  <p id="errcode" class="em no-margin text-danger"></p>
                              </div>
                            </div>
                          </div>
                          {{-- @if($var!=true) --}}
                          <div class="row">
                            <div class="col-md-6">
                                <div class="form-element margin-bottom-20">
                                    <label>Quantité minimum produit <span class="text-danger">(Optionel)</span></label>
                                    <input name="qtite_min" type="text" class="input-field qtite_min" placeholder="Entrez la quantité minimum à acheter ...">
                                    <small class="text-danger">Entrer ci-dessus la quantité minimum à acheter par le client</small>
                                    <p id="errcode" class="em no-margin text-danger"></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-element margin-bottom-20">
                                    <label>Prix de la quantité minimum <span class="text-danger">(Optionel)</span></label>
                                    <input name="prix_qtite_min" type="text" class="input-field prix_qtite_min" placeholder="Entrer le prix de la quantité minimum ...">
                                    <small class="text-danger">Entrer ci-dessus le prix de la quantité minimum à acheter par le client </small>
                                    <p id="errcode" class="em no-margin text-danger"></p>
                                </div>
                            </div>
                          </div>
                          {{-- @endif --}}
                          <div id="proattrsid">
                          </div>
                          <div class="form-element margin-bottom-20">
                             <label>Description </label>
                             <textarea class="form-control" id="desc" rows="10"></textarea>
                             <p id="errdesc" class="em no-margin text-danger"></p>
                          </div>
                          <br>
                          <div class="row">
                            <div class="col-md-12">
                              <div class="card">
                                <div class="card-header base-bg">
                                  <h3 class="text-white mb-0">Offre</h3>
                                </div>
                                <div class="card-body">
                                  <div class="row">
                                    <div class="col-md-4">
                                      <div class="form-element margin-bottom-20">
                                        <label class="d-block">Offre <span>**</span></label>
                                         <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                            data-width="100%" type="checkbox"
                                            name="offer" onchange="changeOffer()">
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-element margin-bottom-20 d-none" id="offerType">
                                        <label class="d-block">Type Offre  <span>**</span></label>
                                        <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                           data-width="100%" type="checkbox" data-on="Percentage" data-off="Fixed"
                                           name="offer_type" id="offerTypeToggle">
                                      </div>
                                    </div>
                                    <div class="col-md-4">
                                      <div class="form-element margin-bottom-20 d-none" id="offerAmount">
                                        <label>Compte <span>**</span></label>
                                        <input name="offer_amount" type="text" class="input-field" placeholder="Entrer le montant de l'offre ...">
                                        <div id="calcTotal"></div>
                                        <p id="errofferamount" class="em no-margin text-danger"></p>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                </div>
                              </div>
                          </div>
                            <br>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="card">
                                  <div class="card-header base-bg">
                                    <h3 class="text-white mb-0">Vente Flash </h3>
                                  </div>
                                  <div class="card-body">
                                    <div class="row">
                                      <div class="col-md-2">
                                        <div class="form-element margin-bottom-20">
                                          <label class="d-block"> Vente Flash <span>**</span></label>
                                          <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                             data-width="100%" type="checkbox"
                                             name="flash_sale">
                                        </div>
                                      </div>

                                      <div class="col-md-10 d-none" id="flashsale">
                                        <div class="row">
                                          <div class="col-md-3">
                                            <div class="form-element margin-bottom-20">
                                              <label class="d-block">Type <span>**</span></label>
                                              <input data-toggle="toggle" data-onstyle="success" data-offstyle="danger"
                                                 data-width="100%" type="checkbox" data-on="Percentage" data-off="Fixed"
                                                 name="flash_type">
                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-element margin-bottom-20">
                                              <label class="d-block">Montant <span>**</span></label>
                                              <div class="form-check form-check-inline">
                                                <input class="input-field" type="text" name="flash_amount" value="" autocomplete="off" placeholder="Entrez le montant du flash">

                                              </div>
                                              <p id="errflashamount" class="em no-margin text-danger"></p>
                                              <div id="calcTotalFlash"></div>
                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-element margin-bottom-20">
                                              <label class="d-block">Date <span>**</span></label>
                                              <div class="form-check form-check-inline">
                                                <input id="flash_date" class="input-field" type="text" name="flash_date" value="" placeholder="Entrez la date du flash">
                                              </div>
                                              <p id="errflashdate" class="em no-margin text-danger"></p>
                                            </div>
                                          </div>

                                          <div class="col-md-3">
                                            <div class="form-element margin-bottom-20">
                                              <label class="d-block">Temps interval <span>**</span></label>
                                              <div class="form-check form-check-inline">
                                                <select class="input-field" name="flash_interval">
                                                  @foreach ($flashints as $key => $flashint)
                                                    <option value="{{$flashint->id}}">{{$flashint->start_time . " - " . $flashint->end_time}}</option>
                                                  @endforeach
                                                </select>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>

                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          <div class="btn-wrapper mt-4">
                              <input type="submit" class="submit-btn" value="Mise à jour">
                          </div>
                      </form>
                  </div><!-- //.product upload inner -->
              </div>
          </div>
      </div>
  </div>
@endsection