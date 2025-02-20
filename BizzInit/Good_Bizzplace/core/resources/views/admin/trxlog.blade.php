@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div>
           <h1>Historique des Transactions </h1>
        </div>
     </div>
     <div class="row">
        <div class="col-md-12">
          @if (count($trs) == 0)
            <div class="tile">
              <h2 class="text-center">AUCUNE TRANSACTION </h2>
            </div>
          @else
            <div class="tile">
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                           <th>Token</th>
                           <th scope="col">Nom de la boutique</th>
                           <th scope="col">Details</th>
                           <th scope="col">Montant</th>
                           <th scope="col">Transaction ID</th>
                           <th scope="col">Solde</th>
                        </tr>
                     </thead>
                     <tbody>
                       @php
                         $i = 0;
                       @endphp
                       @foreach ($trs as $tr)
                         <tr>
                           <td>{{++$i}}</td>
                            <td data-label="Name"><a target="_blank" href="{{route('admin.vendorDetails', $tr->vendor_id)}}">{{$tr->vendor->shop_name}}</a></td>
                            <td data-label="Email">{!! $tr->details !!}</td>
                            <td data-label="Username">{{$tr->amount}} {{$gs->base_curr_text}}</td>
                            <td data-label="Mobile">{{$tr->trx_id}} {{$gs->base_curr_text}}</td>
                            <td data-label="Balance">{{$tr->after_balance}} {{$gs->base_curr_text}}</td>
                         </tr>
                       @endforeach
                     </tbody>
                  </table>
               </div>
               <div class="text-center">
                 {{$trs->links()}}
               </div>
            </div>
          @endif
        </div>
     </div>
  </main>
@endsection
