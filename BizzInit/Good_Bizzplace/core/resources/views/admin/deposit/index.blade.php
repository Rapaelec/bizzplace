@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>
             @if (request()->path() == 'admin/deposit/acceptedRequests')
             Accepted
             @elseif (request()->path() == 'admin/deposit/rejectedRequests')
             Rejected
             @elseif (request()->path() == 'admin/deposit/pending')
             Pending
             @endif
             Deposit Request
           </h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
           <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
           <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Tableau de board</a></li>
        </ul>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($deposits) == 0)
          <div class="tile">
            <h2 class="text-center">PAS
              @if (request()->path() == 'admin/deposit/pending')
              EN ATTENTE
              @elseif (request()->path() == 'admin/deposit/rejectedRequests')
              REJECTE
              @elseif (request()->path() == 'admin/deposit/acceptedRequests')
              ACCEPTE
              @endif
                DEMANDE DE DÉPÔT TROUVÉE</h2>
          </div>
          @else
          <div class="tile">
             <h3 class="tile-title pull-left">Liste de demande de dépôt</h3>
             <div class="table-responsive">
                <table class="table">
                   <thead>
                      <tr>
                         <th scope="col">#</th>
                         <th scope="col">Boutique</th>
                         <th scope="col">Passerelle</th>
                         <th scope="col">Montant</th>
                         <th scope="col">Livraison</th>
                         <th scope="col">Le reçu</th>
                         @if (request()->path() != 'admin/deposit/acceptedRequests' && request()->path() != 'admin/deposit/rejectedRequests')
                         <th scope="col">Action</th>
                         @endif
                      </tr>
                   </thead>
                   <tbody>
                     @php
                       $i = 0;
                     @endphp
                     @foreach ($deposits as $deposit)
                     <tr>
                        <td data-label="Nom">{{++$i}}</td>
                        <td data-label="Nom utilisateur"><a target="_blank" href="{{route('admin.vendorDetails', $deposit->vendor_id)}}">{{$deposit->vendor->shop_name}}</a></td>
                        <td data-label="Email">{{$deposit->gateway->name}}</td>
                        <td data-label="Mobile">{{round($deposit->amount, $gs->dec_pt)}} {{$gs->base_curr_text}}</td>
                        <td data-label="Balance">{{round($deposit->charge, $gs->dec_pt)}} {{$gs->base_curr_text}}</td>
                        <td>
                          <button type="button" class="btn btn-outline-primary" onclick="showImageInModal(event, {{$deposit->id}})"><i class="fa fa-eye"></i> Consulter</button>
                        </td>
                        @if (request()->path() != 'admin/deposit/acceptedRequests' && request()->path() != 'admin/deposit/rejectedRequests')
                        <td data-label="Details">
                          <form style="display:inline-block;" class="" action="{{route('admin.deposit.accept')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="gid" value="{{$deposit->gateway->id}}">
                            <input type="hidden" name="dID" value="{{$deposit->id}}">
                            <button type="submit" class="btn btn-success">
                            <i class="fa fa-check"></i>Demande acceptée
                            </button>
                          </form>
                          <form style="display:inline-block;" class="" action="{{route('admin.deposit.rejectReq')}}" method="post">
                            {{csrf_field()}}
                            <input type="hidden" name="dID" value="{{$deposit->id}}">
                            <button type="submit" class="btn btn-danger">
                            <i class="fa fa-times"></i>Demande rejetée
                            </button>
                          </form>
                        </td>
                        @endif
                     </tr>
                     @endforeach
                   </tbody>
                </table>
             </div>
             <div class="">
               {{$deposits->links()}}
             </div>
          </div>
          @endif
        </div>
     </div>
  </main>

  @includeif('admin.deposit.partials.showImageModal')
@endsection

@push('scripts')
  <script>
    function showImageInModal(e, dID) {
      e.preventDefault();
      var fd = new FormData();
      fd.append('dID', dID);
      $.get(
        '{{route('admin.deposit.showReceipt')}}',
        {
          dID: dID,
        },
        function(data) {
          $('#showImageModal').modal('show');
          document.getElementById('adImage').src = '{{asset('assets/user/img/receipt_img')}}'+'/'+data.r_img;
          console.log(data);
        }
      );
    }
  </script>
@endpush
