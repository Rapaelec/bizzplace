@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Gestion des attributs de produit</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title float-left">Tous les attributs du produit</h3>
              <div class="float-right icon-btn">
                <a class="btn btn-info" data-toggle="modal" data-target="#addModal">
                  <i class="fa fa-plus"></i> Ajouter un attribut de produit
                </a>
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
                @if (count($pas) == 0)
                  <h2 class="text-center">AUCUNE DONNÉE DISPONIBLE</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Nom</th>
                           <th scope="col">Status</th>
                           <th>Toutes les options</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($pas as $key => $pa)
                            <tr>
                               <td>{{$key+1}}</td>
                               <td>{{$pa->name}}</td>
                               <td>
                                 @if ($pa->status == 1)
                                   <h4 style="display:inline-block;"><span class="badge badge-success">Activer</span></h4>
                                 @elseif ($pa->status == 0)
                                   <h4 style="display:inline-block;"><span class="badge badge-danger">Desactiver</span></h4>
                                 @endif
                               </td>
                               <td>
                                 <a class="btn btn-primary" href="{{route('admin.options.index', $pa->id)}}"><i class="fa fa-eye"></i> Consulter</a>
                               </td>
                               <td>
                                 <button type="button" class="btn btn-info" data-toggle="modal" data-target="#addSub{{$pa->id}}">Ajout Option</button>
                                 <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#editModal{{$pa->id}}">Editer</button>
                               </td>
                            </tr>
                            @includeif('admin.product_attribute.partials.edit')
                            @includeif('admin.options.partials.add')
                          @endforeach
                     </tbody>
                  </table>
                @endif
              </div>

              <div class="text-center">
                {{$pas->links()}}
              </div>
           </div>
        </div>
     </div>
  </main>

  @includeif('admin.product_attribute.partials.add')
@endsection
