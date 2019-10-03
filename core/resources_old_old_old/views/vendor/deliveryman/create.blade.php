@extends('layout.master')

@section('title', 'Enregistrement Livreur')

@section('headertxt', 'Enregistrement Livreur')

@push('nicedit-scripts')
  <script src="{{asset('assets/nic-edit/nicEdit.js')}}" type="text/javascript"></script>
  <script type="text/javascript">
    bkLib.onDomLoaded(function() {
      new nicEditor({iconsPath : '{{asset('assets/nic-edit/nicEditorIcons.gif')}}', fullPanel : true}).panelInstance('desc');
    });
  </script>
@endpush

@push('styles')
  <link rel="stylesheet" href="{{asset('assets/user/css/jquery.datetimepicker.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/css/bootstrap-toggle.min.css')}}">
@endpush

@section('content')

  <!-- delivery man upload area start -->
  <div class="product-upload-area" id="uploadDiv">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  @php
                    $vendor = Auth::guard('vendor')->user();
                  @endphp
                  <div class="product-upload-inner"><!-- delivery man upload inner -->
                    <div class="row">
                      @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                 @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                             </ul>
                         </div>
                      @endif
                      <div class="col-md-12">
                        <div class="card">
                          <form id="uploadForm" class="product-upload-form" method="POST" action="
                          @if (route::is('vendor.deliveryman.create')) {{ route('vendor.deliveryman.store') }} @else  {{ route('vendor.deliveryman.update',$livreurs->id) }} @endif">
                            {{csrf_field()}}
                          <div class="card-header base-bg">
                            <h3 class="text-white mb-0">Enregistrement Livreur</h3>
                          </div>
                          <div class="card-body">
                            <div class="row">
                              <div class="col-md-4">
                                  <div class="form-element margin-bottom-20">
                                      <label>Nom livreur<span>**</span></label>
                                      <input name="name" required type="text" value="{{ $livreurs->name ?? '' }}" class="input-field name" placeholder="Nom livreur ...">
                                      <p id="errquantity" class="em no-margin text-danger"></p>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-element margin-bottom-20">
                                      <label>Téléphone livreur<span>**</span></label>
                                      <input name="phone" required type="text" value="{{ $livreurs->phone ?? '' }}" class="input-field phone" placeholder="Téléphone livreur ...">
                                      <p id="errquantity" class="em no-margin text-danger"></p>
                                  </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-element margin-bottom-20">
                                      <label>Email livreur<span>**</span></label>
                                      <input name="email" required type="text" value="{{ $livreurs->email ?? '' }}" class="input-field email" placeholder="Email livreur ...">
                                      <p id="errquantity" class="em no-margin text-danger"></p>
                                  </div>
                              </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                <div class="form-element margin-bottom-20">
                                    <label>Lieu de résidence<span>**</span></label>
                                    <input name="place_of_residence" required type="text" value="{{ $livreurs->place_of_residence ?? '' }}" class="input-field place_of_residence" placeholder="Lieu de résidence ...">
                                    <p id="errquantity" class="em no-margin text-danger"></p>
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-element margin-bottom-20">
                                  <label>Prix de livraison<span>**</span></label>
                                  <input name="delivery_price" required type="text" class="delivery_price input-field" value="{{ $livreurs->delivery_price ?? '' }}" placeholder="Prix de livraison ...">
                                  <p id="errquantity" class="em no-margin text-danger"></p>
                                </div>
                              </div>
                              <div class="col-md-4">
                                  <div class="form-element margin-bottom-20">
                                      <label>Distance<span>**</span></label><span class="text-danger"><span>(En km:kilomètre)</span>
                                      <input name="distance" required type="text" value="{{ $livreurs->distance ?? '' }}" class=" distance input-field" placeholder="Distance ...">
                                      <p id="errquantity" class="em no-margin text-danger"></p>
                                   </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6 {{ route::is('vendor.deliveryman.create') ? 'offset-3' : ''}}">
                                <div class="form-element margin-bottom-20">
                                    <label>Poids de la commande<span>**</span></label><span class="text-danger"><span>(En g:gramme)</span>
                                    <input name="command_weight" value="{{ $livreurs->command_weight ?? '' }}" required type="text" class="command_weight input-field" placeholder="Poids de la commande ...">
                                    <p id="errquantity" class="em no-margin text-danger"></p>
                                 </div>
                              </div>
                              @if (!route::is('vendor.deliveryman.create')) 
                              <div class="col-md-6">
                                <div class="form-element margin-bottom-20">
                                    <label>Status<span></span></label>
                                    <select name="status" id="" class="input-field">
                                      <option value="1">Active</option>
                                      <option value="0">Non active</option>
                                    </select>
                                 </div>
                              </div>
                              @endif
                            </div>
                          </div>
                          <div class="card-footer base-bg">
                            @if (route::is('vendor.deliveryman.create')) 
                            <div class="btn-wrapper mt-4">
                                <input type="submit" class="submit-btn" value="Enregistrer">
                            </div>
                            @else 
                            <div class="btn-wrapper mt-4">
                                <input type="submit" class="submit-btn" value="Mise à jour">
                            </div>
                            @endif
                              
                          </div>
                        </form>
                          </div>
                        </div>
                      </div>
                  </div><!-- //.delivery man upload inner -->
              </div>
          </div>
      </div>
  </div>
  <!-- delivery man upload area end -->
@endsection
