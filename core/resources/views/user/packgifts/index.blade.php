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

@section('title', 'Liste Pack Cadeaux')

@section('headertxt', 'Liste Pack Cadeau')

@section('content')
  <div class="category-content-area search-page">
  @include('user.menu_sousheader')
    <div class="container package-container">
      <div class="row">
        <!-- <div class="col-md-12">
          @php
            $vendor = Auth::guard('vendor')->user();
          @endphp
          <div id="dangerAlert" class="alert alert-danger alert-dismissible fade show d-none">
            <p><strong class="text-danger">Cartes Cadeaux</strong></p>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          @foreach ($packgifts as $package)
            @if ($loop->iteration % 4 == 1)
            <div class="row"> {{-- .row start --}}
            @endif
            <div class="col-md-3">
              <div class="card" style="">
                <div class="card-header base-bg">
                  <h5 class="card-title text-white">{{ $package->title}}</h5>
                </div>
                <div class="card-body package-desc" style="padding:0;width:100%">
                    <img src="{{ $package->img_pack }}" width="100%">
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>Prix: </strong>{{$package->price}} {{$gs->base_curr_text}}</li>
                  {{-- <li class="list-group-item"><strong>Produits:</strong> {{$package->products}}</li> --}}
                  <li class="list-group-item"><strong>Validaté:</strong> {{$package->validity}} jours après activation de la carte</li>
                </ul>
                <div class="card-body">
                  <div class="text-center">
                    <a href="{{ route('user.cartgift.formshowpay',$package->id) }}" class="btn btn-block base-bg white-txt">Procéder au paiement</a>
                  </div>
                </div>
              </div>
            </div>
            @if ($loop->iteration % 4 == 0)
            </div> {{-- .row end --}}
            @endif
          @endforeach
        </div> -->
        <h2>Pas de carte cadeau disponible pour le moment !!!</h2>
      </div>
    </div>
  </div>
@endsection

@push('scripts')
<script>

// Vérifie si le vendeur dispose d'un package valide
    /* $(window).load(function(){
      $.get(
        '{{route('package.validitycheck')}}',
        function(data) {
          // console.log(data);

          if (data.products == 0) {
            $("#dangerAlert").addClass('d-block');
            $("#successAlert").addClass('d-none');
          } else if (data.products > 0) {
            $("#successAlert").addClass('d-block');
            $("#dangerAlert").addClass('d-none');
          }
        }
      );
    });
 */
  function buy(id) {
    swal({
      title: "Confirmation",
      text: "Êtes-vous sûr de vouloir acheter ce forfait ?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willBuy) => {
      if (willBuy) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        var fd = new FormData();
        fd.append('packid', id);
        $.ajax({
          url: '{{route('package.buy')}}',
          type: 'POST',
          data: fd,
          contentType: false,
          processData: false,
          success: function(data) {
            console.log(data);
            if (data == "success") {
              window.location = '{{url()->current()}}';
            }
            if (data == "b_short") {
              swal("Vous n'avez pas assez de solde pour acheter ce forfait!", {
                icon: "error",
              });
            }
          }
        })
      }
    });
  }
</script>
@endpush
