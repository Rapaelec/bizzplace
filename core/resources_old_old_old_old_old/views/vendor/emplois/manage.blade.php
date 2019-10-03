@extends('layout.master')

@section('title', 'Emplois')

@section('headertxt', 'Gestion des Emplois')

@section('content')
<div class="sellers-product-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="seller-product-wrapper">
                      <div class="seller-panel">
                          <div class="card-header clearfix">
                                  <h4 style="padding-top: 15px;" class="d-inline-block text-white">VOS OFFRES D'EMPLOIS</h4>
                                  {{-- <a href="{{route('vendor.immobilier.create',strTolower($categoris->name))}}" class="boxed-btn float-right">Créer un nouveau</a> --}}
                          <marquee><h4 class="text-white font-weight-bold">AUCUN AJOUT N'EST POSSIBLE POUR LE MOMENT</h4></marquee>
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>Emploi</th>
                                              <th>Nom</th>
                                              <th>Secteur d'emploi</th>
                                              <th>Type d'offre</th>
                                              <th>Date de creation</th>
                                              <th>&nbsp;</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        {{-- @foreach ($immobiliers as $immobilier)
                                          <tr>
                                              <td>
                                                  <div class="single-product-item"><!-- single product item -->
                                                      <div class="thumb">
                                                        <a href="#">
                                                          <img style="width:60px;" src="{{asset('assets/user/img/products/'.(App\PreviewImage::where('immobilier_id',$immobilier->id)->first())->image)}}" alt="seller product image">
                                                        </a>
                                                      </div>
                                                      <div class="content">
                                                          <h4 class="title"><a target="_blank" href="#"></a></h4>
                                                      </div>
                                                  </div><!-- //.single product item -->
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $immobilier->nom }}
                                              </td>
                                              <td class="padding-top-40">
                                               {{ $immobilier->prix }} &euro;
                                              </td>
                                              <td class="padding-top-40">{{ $immobilier->type_offre }}</td>
                                              <td class="padding-top-40">{{ $immobilier->created_at }}</td>
                                              <td class="padding-top-40">
                                                  <ul class="action">
                                                      <li><a target="_blank" href="{{route('vendor.immobilier.edit',$immobilier->id)}}"><i class="fas fa-pencil-alt"></i></a></li>
                                                      <li class="sp-close-btn"><a href="#" onclick="delImmobilier(event, {{ $immobilier->id}})"><i class="fas fa-times"></i></a></li>
                                                  </ul>
                                              </td>
                                          </tr>
                                        @endforeach --}}
                                      </tbody>
                                  </table>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                </div>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>    
@endsection