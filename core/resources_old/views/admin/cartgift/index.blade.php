@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1><i class="fa fa-dashboard"></i>CARTE CADEAU</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Tableau de bord</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title float-left">@if (!$cartgifts->isEmpty()) Cartes Cadeaux du packs {{ $cartgifts->first()->title }} @else Cartes Cadeaux @endif</h3>
              <div class="float-right icon-btn">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#generateCart">
                   <i class="fa fa-plus"></i> GENERER VOS CARTES
              </button>
              <a href="{{ route('admin.cartgift') }}" class="btn btn-success">
                   <i class="fa fa-plus"></i> VOIR TOUTES VOS CARTES
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
                @if (count($cartgifts) == 0)
                  <h2 class="text-center">AUCUNE CARTE CADEAU TROUVE</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Nom Pack</th>
                           <th scope="col">Numéro carte</th>
                           <th scope="col">Validité (En jours)</th> 
                           <th scope="col">Etat</th>
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($cartgifts as $cartgift)
                            <tr>
                               <td>{{$loop->iteration}}</td>
                               <td>{{$cartgift->title}}</td>
                               <td>{{ mb_substr($cartgift->num_cartgift,0,12) }}</td>
                               <td>{{$cartgift->duree_utilisation}} Jours</td> 
                               <td>
                                @if ($cartgift->etat == 'En attente')
                                <button type="button" class="btn btn-success btn-sm">{{ $cartgift->etat }}</button>
                                @elseif($cartgift->etat == 'En cours')
                                <button type="button" class="btn btn-warning btn-sm">{{ $cartgift->etat }}</button>
                                @elseif($cartgift->etat == 'Expiré')
                                <button type="button" class="btn btn-danger btn-sm">{{ $cartgift->etat }}</button>
                                @endif
                                </td>
                               <td>
                                 <button type="button" class="btn btn-danger btn-sm" onclick="DeleteCartgifts(event,{{ $cartgift->id }})">
                                 <i class="fa fa-trash" aria-hidden="true"></i>Supprimer</button>
                               </td>
                            </tr>
                            {{-- @includeif('admin.cartgift.partials.edit') --}}
                          @endforeach
                     </tbody>
                  </table>
                @endif
              </div>
              <div class="text-center">
                    {{$cartgifts->links()}}
              </div>
           </div>
        </div>
     </div>
  </main>

  {{-- Gateway Add Modal --}}
  @includeif('admin.cartgift.partials.add')
@endsection
@push('scripts')
  <script>
    $(document).ready(function() {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
    });
    function DeleteCartgifts(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sûre de supprimer cette carte ?",
        text: "La suppression de cette carte entrainera la perte de donnée de cette carte.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('admin.cartgift.delete')}}',
            type: 'POST',
            data: {
              id: pid
            },
            success: function(data) {
              console.log(data);
              if (data.result== "success") {
                  window.location = '{{url()->current()}}';
              }
            }
          });
        }
      });
    }
  </script>
@endpush
