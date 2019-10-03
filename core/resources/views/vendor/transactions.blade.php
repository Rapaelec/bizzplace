@extends('layout.master')

@section('title', 'Historique Transaction')

@section('headertxt', 'Historique Transaction')

@push('styles')
<style media="screen">
li.page-item {
  display: inline-block;
}
</style>
@endpush

@section('content')
  <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                  <div class="seller-product-wrapper">
                      <div class="seller-panel">
                          <div class="card-header">
                           Historique Transaction
                          </div>
                          <div class="sellers-product-inner">
                              <div class="bottom-content">
                                  <table class="table table-default" id="datatableOne">
                                      <thead>
                                          <tr>
                                              <th>code</th>
                                              <th>Details</th>
                                              <th>ID Transaction</th>
                                              <th>Montant</th>
                                              <th>Après Balance</th>
                                          </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($transactions as $transaction)
                                          <tr>
                                              <td class="padding-top-40">{{$loop->iteration}}</td>
                                              <td class="padding-top-40">{!!$transaction->details!!}</td>
                                              <td class="padding-top-40">{{$transaction->trx_id}}</td>
                                              <td class="padding-top-40">{{$gs->base_curr_symbol}} {{$transaction->amount}}</td>
                                              <td class="padding-top-40">{{$gs->base_curr_symbol}} {{$transaction->after_balance}}</td>
                                          </tr>
                                        @endforeach
                                      </tbody>
                                  </table>
                              </div>
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="text-center">
                                     {{$transactions->links()}}
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
  <!-- sellers product content area end -->
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
    function delproduct(e, pid) {
      e.preventDefault();
      swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to get back this product!",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          $.ajax({
            url: '{{route('vendor.product.delete')}}',
            type: 'POST',
            data: {
              id: pid
            },
            success: function(data) {
              console.log(data);
              if (data == "success") {
                  window.location = '{{url()->current()}}';
              }
            }
          });
        }
      });
    }
  </script>
@endpush
