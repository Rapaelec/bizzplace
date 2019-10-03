@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1><i class="fa fa-dashboard"></i> Configuration de Package </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Tableau de bord</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title float-left">Souscription Package</h3>
              <div class="float-right icon-btn">
                 <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
                   <i class="fa fa-plus"></i> Ajout Package
                 </button>
              </div>
              <p style="clear:both;margin:0px;"></p>
              <div class="col-md-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
              </div>
              <div class="table-responsive">
                @if (count($packages) == 0)
                  <h2 class="text-center">AUCUN PACKAGE TROUVE</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Titre</th>
                           <th scope="col">Courte Description</th>
                           <th scope="col">Prix</th>
                           <th scope="col">Produits</th>
                           <th scope="col">Validité (en jours)</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($packages as $key => $package)
                            <tr>
                               <td>{{$key+1}}</td>
                               <td>{{$package->title}}</td>
                               <td>{{$package->s_desc}}</td>
                               <td>{{$package->price}}</td>
                               <td>{{$package->products}}</td>
                               <td>{{$package->validity}}</td>
                               <td>
                                 @if ($package->status == 1)
                                   <button type="button" class="btn btn-success btn-sm">Activer</button>
                                 @else
                                   <button type="button" class="btn btn-danger btn-sm">Desactiver</button>
                                 @endif
                               </td>
                               <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal{{$package->id}}">Editer</button>
                               </td>
                            </tr>
                            @includeif('admin.packages.partials.edit')
                          @endforeach

                     </tbody>
                  </table>
                @endif
              </div>
           </div>
        </div>
     </div>
  </main>

  {{-- Gateway Add Modal --}}
  @includeif('admin.packages.partials.add')
@endsection
