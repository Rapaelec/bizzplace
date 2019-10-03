@extends('layout.master')

@section('title', 'Annonces')

@section('headertxt', 'Gérer vos annonces')

@section('content')
<div class="seller-dashboard-content-area">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="card dashboard-content-wrapper card-default gray-bg">
        <div class="card-header">
          Gestion des annonces
        </div>
        <div class="container">
        <div class="row">
         <div class="col-md-12">
          <div class="tile">
           <div class="tile-body">
            <h3 class="text-white mb-3"></h3>
            <div class="row">
            @foreach($categories as $categorie)
                 <div class="col-md-4 {{ $loop->index > 2 ? 'mt-3' : '' }}">
                  <div class="card">
                    <div class="card-header bg-primary"> <h3 class="text-white">Gestion des {{ $loop->last ? 'paternaires' : $categorie->name }}</h3></div>
                     <div class="card-body">
                        {{ $categorie->description_short }}
                     </div>
                    <div class="card-footer">
                    <div class="row">
                     {{-- <div class="col-md-5">
                     <a href="#" class="btn btn-primary showModalInfo" data-name="{{ $categorie->name }}"  data-long="{{ $categorie->description_long }}" >
                        Plus d'info
                     </a>
                     </div> --}}
                     <div class="col-md-12">
                        <a href="{{ route('vendor.categorie',strToLower($categorie->name)) }}" class="btn btn-success  btn-block">
                        J'utilise ce service
                        </a>
                     </div>
                     </div>
                     </div>
                    </div>
                   </div>
            @endforeach
                </div> <!--row-->
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
{{-- @includeif('vendor.annonce.partials.info')  --}}
@endsection

