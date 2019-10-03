@extends('admin.layout.master')

@section('content')
<main class="app-content">
     <div class="app-title">
        <div>
           <h1>Gestion des produits</h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title float-left">Tous les produits</h3>
              <div class="float-right icon-btn">
                <a class="btn btn-info" data-toggle="modal" data-target=".bd-example-modal-lg">
                  <i class="fa fa-plus"></i> Ajouter un produit
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
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">PRODUITS</th>
                           <th scope="col">PRIX</th>
                           <th>QUANTITES RESTANTES</th>
                           <th>TOTALS DES GAINS</th>
                           <th>VENTE</th>
                           <th scope="col">ACTION</th>
                        </tr>
                     </thead>
                     <tbody>

                     </tbody>
                  </table>
              </div>
              <div class="text-center">
              {{--   {{$pas->links()}} --}}
              </div>
           </div>
        </div>
     </div>
  </main>
  @includeif('admin.central_achat.partials.add')
@endsection