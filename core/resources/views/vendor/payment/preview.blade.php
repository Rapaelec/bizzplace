@extends('layout.master')

@section('title', 'Aperçu du paiement')

@section('headertxt', 'Aperçu du paiement')

@push('styles')
<style media="screen">
  .gimg {
    max-width:300px;
    max-height:300px;
    margin:0 auto;
  }
  @media screen and (max-width: 370px) {
    .gimg {
      width:100%;
      margin:0px;
    }
  }
</style>
@endpush
@section('content')
  <div class="row my-5">
  	<div class="col-md-12">
  		<div class="panel panel-inverse">
  			<div class="panel-body">
          <div class="d-flex justify-content-center">
            <div  class="col-md-4 col-md-offset-4 text-center">
                <form  class="contact-form" method="POST" action="{{route('payment.confirm.formule')}}">
                  {{-- {{dd('ff')}} --}}
                    {{csrf_field()}}
                    <input type="hidden" name="gateway" value="{{$data->gateway_id}}"/>
                    <input type="hidden" name="amount" value="{{$data->amount}}"/>
                    <div class="panel">
                        <div class="panel-body">
                            <ul class="list-group text-center">
                                <li class="list-group-item"><img src="{{asset('assets/gateway')}}/{{$data->gateway_id}}.jpg" class="gimg"/></li>
                                <li class="list-group-item">Total: <strong>{{$data->amount}} </strong>{{$gs->base_curr_text}}</li>
                            </ul>
                        </div>
                        <div class="panel-footer">
                            <button id="btn-confirm" type="submit" class="btn btn-primary btn-block">
                            Payez maintenant
                            </button>
                        </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      </div>
  </div>
@endsection

@section('paymentscripts')
  @if($data->gateway_id == 107)
  <form action="{{ route('ipn.paystack.payment') }}" method="POST">
      @csrf
      <script
      src="//js.paystack.co/v1/inline.js"
      data-key="{{ $data->gateway->val1 }}"
      data-email="{{ $data->user->email }}"
      data-amount="{{ round($data->usd_amo/$data->gateway->val7, 2)*100 }}"
      data-currency="NGN"
      data-ref="{{ $data->trx }}"
      data-custom-button="btn-confirm"
      >
  </script>
  </form>
  @elseif($data->gateway_id == 108)
  <script src="//voguepay.com/js/voguepay.js"></script>
  <script>
      closedFunction = function() {

      }
      successFunction = function(transaction_id) {
          window.location.href = '{{route('user.checkout.success')}}';
      }
      failedFunction=function(transaction_id) {
          window.location.href = '{{route('user.gateways')}}';
      }

      function pay(item, price) {
          //Initiate voguepay inline payment
          Voguepay.init({
              v_merchant_id: "{{ $data->gateway->val1 }}",
              total: price,
              notify_url: "{{ route('ipn.voguepay.payment') }}",
              cur: 'USD',
              merchant_ref: "{{ $data->trx }}",
              memo:'Payment',
              recurrent: true,
              frequency: 10,
              developer_code: '5af93ca2913fd',
              store_id:"{{ $data->user_id }}",
              custom: "{{ $data->trx }}",

              closed:closedFunction,
              success:successFunction,
              failed:failedFunction
          });
      }

      $(document).ready(function () {
          $(document).on('click', '#btn-confirm', function (e) {
              e.preventDefault();
              pay('Buy', {{ $data->usd_amo }});
          });
      });
  </script>

  @endif
@endsection
