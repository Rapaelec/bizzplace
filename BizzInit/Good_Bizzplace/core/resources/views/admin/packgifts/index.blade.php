@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1><i class="fa fa-dashboard"></i> Configuration des Packs Cadeaux </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Tableau de bord</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <h3 class="tile-title float-left">Liste Packs Cadeaux</h3>
              <div class="float-right icon-btn">
              <button type="button" class="btn btn-success" data-toggle="modal" data-target="#generateCart">
                   <i class="fa fa-plus"></i> GENERER VOS CARTES
               </button>
               <button type="button" class="btn btn-success" data-toggle="modal" data-target="#addModal">
                   <i class="fa fa-plus"></i> AJOUTER PACK CADEAU
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
                @if (count($packgift) == 0)
                  <h2 class="text-center">AUCUN PACK CADEAU TROUVE</h2>
                @else
                  <table class="table">
                     <thead>
                        <tr>
                           <th scope="col">SL</th>
                           <th scope="col">Titre</th>
                           <th scope="col">Courte Description</th>
                           <th scope="col">Prix</th>
                           <th scope="col">Validité (days)</th> 
                           <th scope="col">Status</th>
                           {{-- <th scope="col">image_packgift</th> --}}
                           <th scope="col">Action</th>
                        </tr>
                     </thead>
                     <tbody>
                          @foreach ($packgift as $packgifts)
                            <tr>
                               <td>{{$loop->iteration}}</td>
                               <td>{{$packgifts->title}}</td>
                               <td>{{$packgifts->description}}</td>
                               <td>{{$packgifts->price}}</td>
                               <td>{{$packgifts->validity}}</td> 
                               {{-- <td>{{$packgifts->img_pack}}</td> --}}
                               <td>
                                 @if ($packgifts->status == 1)
                                   <button type="button" class="btn btn-success btn-sm">Activer</button>
                                 @else
                                   <button type="button" class="btn btn-danger btn-sm">Desactiver</button>
                                 @endif
                               </td>
                               <td>
                                 <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#editModal{{ $packgifts->id }}">
                                 <i class="fa fa-edit" aria-hidden="true"></i>Editer</button>
                                 <a href="{{ route('admin.packgift.show',$packgifts->id) }}" class="btn btn-success btn-sm" >
                                 <i class="fa fa-eye" aria-hidden="true"></i>Voir cartes</a>
                                 <button type="button" class="btn btn-danger btn-sm" onclick="DeletePackgifts(event,{{ $packgifts->id }})">
                                 <i class="fa fa-trash" aria-hidden="true"></i>Supprimer</button>
                               </td>
                            </tr>
                            @includeif('admin.packgifts.partials.edit')
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
  @includeif('admin.packgifts.partials.add')
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
    function DeletePackgifts(e, pid) {
      e.preventDefault();
      swal({
        title: "Êtes vous sûre ?",
        text: "La suppression entrainera la perte des cartes cadeaux associées a ce pack.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('admin.packgift.delete')}}',
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
