@extends('layout.master')

@section('title', 'Caisse')
@section('headertxt', 'Caisse')

@section('content')
<!-- checkout page content area start -->
<div class="checkout-page-content-area">
    <div class="container">
      <form id="billingDetailsForm" action="{{route('user.checkout.placeorder')}}" class="checkout-form" method="post">
        <div class="row errorNoValidate">
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="left-content-area">
                    <h3 class="title">Les détails d'expédition</h3>
                    {{-- <form id="billingDetailsForm" action="{{route('user.checkout.placeorder')}}" class="checkout-form" method="post"> --}}
                        {{csrf_field()}}
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Nom<span class="base-color">**</span></label>
                                    <input name="first_name" type="text" class="input-field" placeholder="Nom ..." value="{{$user->shipping_first_name}}">
                                    @if ($errors->has('first_name'))
                                      <p class="text-danger">{{$errors->first('first_name')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Prénom <span class="base-color">**</span></label>
                                    <input name="last_name" type="text" class="input-field" placeholder="Prénom..." value="{{$user->shipping_last_name}}">
                                    @if ($errors->has('last_name'))
                                      <p class="text-danger">{{$errors->first('last_name')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Téléphone <span class="base-color">**</span></label>
                                    <input name="phone" type="text" class="input-field" placeholder="Téléphone..." value="{{$user->shipping_phone}}">
                                    @if ($errors->has('phone'))
                                      <p class="text-danger">{{$errors->first('phone')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Email <span class="base-color">**</span></label>
                                    <input name="email" type="text" class="input-field" placeholder="Adresse email..." value="{{$user->shipping_email}}">
                                    @if ($errors->has('email'))
                                      <p class="text-danger">{{$errors->first('email')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-element">
                                    <label>Adresse rue <span class="base-color">**</span></label>
                                    <input name="address" type="text" class="input-field" placeholder="Adresse rue..." value="{{$user->address}}">
                                    @if ($errors->has('address'))
                                      <p class="text-danger">{{$errors->first('address')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-element select has-icon">
                                    <label>Pays <span class="base-color">**</span></label>
                                    <select name="country" class="input-field select ">
                                        <option value="" selected disabled>Sélectionner un pays</option>
                                        @foreach ($countries as $country)
                                          <option value="{{$country}}" {{$country==$user->country?'selected':''}}>{{$country}}</option>
                                        @endforeach
                                    </select>
                                    <div class="the-icon">
                                        <i class="fas fa-angle-down"></i>
                                    </div>
                                    @if ($errors->has('country'))
                                      <p class="text-danger">{{$errors->first('country')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Etat <span class="base-color">**</span></label>
                                    <input name="state" type="text" class="input-field" placeholder="Etat ..." value="{{$user->state}}">
                                    @if ($errors->has('state'))
                                      <p class="text-danger">{{$errors->first('state')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Ville <span class="base-color">**</span></label>
                                    <input name="city" type="text" class="input-field" placeholder="Ville ..." value="{{$user->city}}">
                                    @if ($errors->has('city'))
                                      <p class="text-danger">{{$errors->first('city')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-element">
                                    <label>Code Zip<span class="base-color">**</span></label>
                                    <input name="zip_code" type="text" class="input-field" placeholder="code zip ..." value="{{$user->zip_code}}">
                                    @if ($errors->has('zip_code'))
                                      <p class="text-danger">{{$errors->first('zip_code')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>


                        <div class="shipping-details">
                            <div class="form-element textarea">
                                <label>Notes</label>
                                <textarea name="order_notes" class="input-field textarea" cols="30" rows="10"></textarea>
                            </div>
                        </div>
                      </div>
                {{-- </form> --}}
            </div>
            <div class="col-lg-6">
                <div class="right-content-area">
                    <h3 class="title">Votre commande</h3>
                    <ul class="order-list">
                        <li>
                            <div class="single-order-list heading">
                                Titre du produit <span class="right">Total</span>
                            </div>
                        </li>
                        @foreach ($cartItems as $cart)
                          <li class="name" id="li{{$cart->product_id}}">
                              <div class="single-order-list">
                                  <a href="{{route('user.product.details', [$cart->product->slug, $cart->product->id])}}">{{strlen($cart->title) > 50 ? substr($cart->title, 0, 50) . '...' : $cart->title}}</a>
                                  <span class="right">
                                    @if ($cart->current_price)
                                      {{$gs->base_curr_symbol}} {{$cart->current_price*$cart->quantity}}
                                    @else
                                      {{$gs->base_curr_symbol}} {{$cart->price*$cart->quantity}}
                                    @endif
                                  </span>
                              </div>
                          </li>
                        @endforeach

                          <li id="liamount" class="{{$char > 0 ? 'd-block' : 'd-none'}}">
                              <div class="single-order-list title-bold">
                                  Montant du panier <span class="right normal">{{$gs->base_curr_symbol}} {{$amount}}</span>
                              </div>
                          </li>
                          <li id="licoupon" class="{{$char > 0 ? 'd-block' : 'd-none'}}">
                              <div class="single-order-list title-bold">
                                  Coupon Réduction <span class="right normal" id="coupon">- {{$gs->base_curr_symbol}} {{$char}}</span>
                              </div>
                          </li>


                      <li>
                          <div class="single-order-list title-bold">
                             Sous Total <span class="right normal" id="subtotal">{{$gs->base_curr_symbol}} {{$amount - $char}}</span>
                          </div>
                      </li>

                        <li class="shipping">
                            <div class="single-order-list title-bold">
                                Frais de port
                                <input type="hidden" id="fraisCharge" name="fraisCharge">
                                <span class="right normal" id="shippingCharge"></span>
                            </div>
                        </li>
                        <li>
                            <div class="single-order-list title-bold">
                                Taxe <span class="right normal">{{$gs->tax}} %</span>
                            </div>
                        </li>
                        <li>
                            <div class="single-order-list title-bold">
                                Total <span class="right normal" id="total" data-getTotal='{{getTotal(Auth::user()->id)}}'>{{$gs->base_curr_symbol}} {{getTotal(Auth::user()->id)}}</span>
                                <input type="hidden" name="input_total" id="input_total">
                            </div>
                        </li>
                        <li>
                            <div class="single-order-list title-bold">
                                <div>
                                    <button type="button" class="submit-btn" style="border-radius:8px" data-toggle="modal" data-target="#addDeliveryManOfOrders">NOS LIVREURS DISPONIBLES</button>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div class="">
                      @if (!empty($cdetails))
                        <div class="alert alert-success" role="alert">
                            Le coupon est déjà appliqué! Ce code promo est valable jusqu'au {{date('jS F, Y', strtotime($cdetails->valid_till))}}
                        </div>
                      @endif
                      <form id="couponform">
                        {{csrf_field()}}
                        <div class="left-content-area">
                            <div class="coupon-code-wrapper">
                                <div class="form-element" style="margin:0px;">
                                    <input id="couponCodeIn" name="coupon_code" type="text" value="" class="input-field" placeholder="Coupon Code" autocomplete="off">
                                </div>
                                <button type="button" class="submit-btn" onclick="applycoupon(event)">Appliquer</button>
                            </div>
                            <p id="errcouponcode" class="text-danger em"></p>
                        </div>
                      </form>
                      @php
                        if (Auth::check()) {
                          $sessionid = Auth::user()->id;
                        } else {
                          $sessionid = session()->get('browserid');
                        }
                        $pp = \App\PlacePayment::where('cart_id', $sessionid)->first();
                      @endphp

                      <h5>Sélectionner une méthode d'expédition:</h5>
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox1" name="place" value="in" onchange="calcTotal(document.getElementById('paymentMethod').value)" @if(!empty($pp->place)) {{$pp->place=='in'?'checked':''}} @endif>
                            <label class="form-check-label" for="inlineCheckbox1">Dans {{-- {{$gs->main_city}} --}}la ville</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox2" name="place" value="around" onchange="calcTotal(document.getElementById('paymentMethod').value)" @if(!empty($pp->place)) {{$pp->place=='around'?'checked':''}} @endif>
                            <label class="form-check-label" for="inlineCheckbox2">Autour {{-- {{$gs->main_city}} --}} de la ville</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="inlineCheckbox3" name="place" value="world" onchange="calcTotal(document.getElementById('paymentMethod').value)" @if(!empty($pp->place)) {{$pp->place=='world'?'checked':''}} @else checked @endif>
                            <label class="form-check-label" for="inlineCheckbox3">D'autres lieux</label>
                          </div>
                        </div>
                      </div>
                      <br>

                      <h5>Mode de paiement:</h5>
                      <div class="row">
                        <div class="col-md-12">
                          <select class="form-control" name="payment_method" id="paymentMethod" onchange="calcTotal(this.value)">
                            <option value="1" @if(!empty($pp->payment)) {{$pp->payment==1?'selected':''}} @else selected @endif>Paiement à la livraison</option>
                            <option value="2" @if(!empty($pp->payment)) {{$pp->payment==2?'selected':''}} @endif>Avance</option>
                          </select>
                        </div>
                      </div>
                      <br>
                    </div>
                    <div class="checkbox-element account">
                        <div class="checkbox-wrapper">
                            <label class="checkbox-inner">J'ai lu et accepté les <a href="{{route('terms')}}" class="base-color">Termes et Conditions *</a>
                                <input type="checkbox" name="terms">
                                <span class="checkmark"></span>
                            </label>
                            <input type="hidden" name="terms_helper" value="">
                        </div>
                        @if ($errors->has('terms_helper'))
                          <p class="text-danger">{{$errors->first('terms_helper')}}</p>
                        @endif
                    </div>
                    <div class="btn-wrapper">
                        <button type="button" class="submit-btn" onclick="placeorder()">Passer votre commande </button>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </div>
    @includeIf('user.partials_checkout.add_deliverymanoforder')
</div>
</div>
<!-- checkout page content area end -->

@endsection

@section('js-scripts')
  <script>
    var curr = "{{$gs->base_curr_symbol}}";

    $(document).ready(function() {
      calcTotal(document.getElementById('paymentMethod').value);
    });

  
    function updateCheckout(e) {
      e.preventDefault();
      if($('#ChoiceDeliverymans').is(':checked')){
        var id_deliveryman = $('#ChoiceDeliverymans').val();
        $.ajax({
        url:'{{ route('user.update.getTotal') }}',
        method:'get',
        dataType:'JSON',
        data:{
          id:id_deliveryman
        }
      })
    .done(function(data){
        if(!data.fail){
          $("#shippingCharge").html(curr + " " + data.frais);
          $("#fraisCharge").val(data.frais);
          $("#total").html(curr + " " + data.total);
          $('#input_total').val(data.total);
          $("#addDeliveryManOfOrders").modal('hide');
        }
    })
  }else{
    $('.errorNoValidate').html("<div class='alert alert-danger' role='alert'><p class='text-danger'>Aucun livreur n'a été sélectionné </p></div>")
 }

}
  
    function calcTotal(paymentMethod) {
      var place;
      var shippingmethod = document.getElementsByName('place');
      for (var i = 0; i < shippingmethod.length; i++) {
        if (shippingmethod[i].checked) {
          place = shippingmethod[i].value;
        }
      }
      // console.log(place);
      // console.log(paymentMethod);
      $.get(
        '{{route('cart.getTotal')}}',
        {
          place: place,
          paymentMethod: paymentMethod
        },
        function(data) {
          console.log(data);
          $("#shippingCharge").html(curr + " " + data.shippingcharge);
          $("#total").html(curr + " " + data.total);
        }
      );
    }

    function applycoupon(e) {
      e.preventDefault();
      var form = document.getElementById('couponform');
      var fd = new FormData();
      fd.append('coupon_code', document.getElementById('couponCodeIn').value);
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
      });
      $.ajax({
        url: '{{route('user.checkout.applycoupon')}}',
        type: 'POST',
        data: fd,
        contentType: false,
        processData: false,
        success: function(data) {
            console.log(data);
            var em = document.getElementsByClassName('em');
            for (var i = 0; i < em.length; i++) {
              em[i].innerHTML = '';
            }
            if(typeof data.error != 'undefined') {
              if (typeof data.coupon_code != 'undefined') {
                document.getElementById('errcouponcode').innerHTML = data.coupon_code[0];
              }
            } else {
              toastr["success"]("Coupon applied!");
              document.getElementById('couponCodeIn').value = '';
              $("#subtotal").html(curr + " " + data.subtotal);
              $("#total").html(curr + " " + data.total);
              if (data.ctotal > 0) {
                $("#licoupon").removeClass('d-none');
                $("#licoupon").addClass('d-block');
                $("#liamount").removeClass('d-none');
                $("#liamount").addClass('d-block');
                $("#coupon").html('- ' + curr + " " + data.ctotal);
              } else {
                $("#licoupon").removeClass('d-block');
                $("#licoupon").addClass('d-none');
                $("#liamount").removeClass('d-block');
                $("#liamount").addClass('d-nonw');
              }

            }
        }
      });
    }

    function placeorder() {
      document.getElementById("billingDetailsForm").submit();
    }
  </script>
@endsection
