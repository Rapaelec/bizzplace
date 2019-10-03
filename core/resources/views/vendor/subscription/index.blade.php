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

@section('title', 'Forfaits d\'abonnement')

@section('headertxt', 'Forfaits d\'abonnement')

@section('content')
  <div class="">
    <div class="container package-container">
      <div class="row">
        <div class="col-md-12">
          @php
            $vendor = Auth::guard('vendor')->user();
          @endphp

          <div id="successAlert" class="alert alert-success alert-dismissible fade show d-none">
            <p><strong class="text-success">Votre package est valable jusqu'au {{date('j M Y', strtotime($vendor->expired_date))}} et peut télécharger {{$vendor->products}} produits.</strong></p>
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


          @foreach ($packages as $package)
            @if ($loop->iteration % 4 == 1)
            <div class="row"> {{-- .row start --}}
            @endif
            <div class="col-md-3">
              <div class="card" style="">
                <div class="card-header base-bg">
                  <h5 class="card-title text-white">{{$package->title}}</h5>
                </div>
                <div class="card-body package-desc">
                  <p class="card-text">
                    {{$package->s_desc}}
                  </p>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><strong>Prix: </strong>{{$package->price}} {{$gs->base_curr_text}}</li>
                  <li class="list-group-item"><strong>Produits:</strong> {{$package->products}}</li>
                  <li class="list-group-item"><strong>Validité:</strong> {{$package->validity}} jours</li>
                </ul>
                <div class="card-body">
                  <div class="text-center">
                    <button type="button" class="btn btn-block base-bg white-txt" onclick="buy({{$package->id}});">Acheter</button>
                  </div>
                </div>
              </div>
            </div>
            @if ($loop->iteration % 4 == 0)
            </div> {{-- .row end --}}
            @endif
          @endforeach
        </div>
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
      text: "Êtes-vous sûr de vouloir acheter ce forfait??",
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
              swal("Vous n'avez pas assez de solde pour acheter ce forfait !", {
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
