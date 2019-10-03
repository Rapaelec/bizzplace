@extends('admin.layout.master')

@section('content')
  <main class="app-content">
     <div class="app-title">
        <div class="row" style="width:100%">
          <div class="col-md-6">
            <h1 class="float-left">Créer un coupon</h1>
          </div>
          <div class="col-md-6">
            <a href="{{route('admin.coupon.index')}}" class="btn btn-primary float-right">Listes de coupons</a>
          </div>
        </div>
     </div>

     <div class="row">
        <div class="col-md-12">
           <div class="tile">
              <div class="tile-body">
                 <form role="form" method="POST" action="{{route('admin.coupon.store')}}" enctype="multipart/form-data">
                    <div class="form-body">
                       {{csrf_field()}}
                       {{-- <div class="form-group">
                          <label><strong>Code Coupon </strong></label>
                          <input type="text" name="coupon_code" class="form-control input-lg" value="{{$gs->coupon_code}}">
                          @if ($errors->has('coupon_code'))
                            <span style="color:red;">{{$errors->first('coupon_code')}}</span>
                          @endif
                       </div>
                       <div class="form-group">
                          <label><strong>Type</strong></label><br>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="coupon_type" id="inlineRadio1" value="fixed" {{$gs->coupon_type=='fixed'?'checked':''}} onchange="changePlaceholder(this.value)">
                            <label class="form-check-label" for="inlineRadio1">Fixé</label>
                          </div>
                          <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="coupon_type" id="inlineRadio2" value="percentage" {{$gs->coupon_type=='percentage'?'checked':''}} onchange="changePlaceholder(this.value)">
                            <label class="form-check-label" for="inlineRadio2">Pourcentage</label>
                          </div>
                          @if ($errors->has('type_helper'))
                            <p><span style="color:red;">{{$errors->first('type_helper')}}</span></p>
                          @endif
                          <input type="hidden" name="type_helper" value="">
                       </div>
                       <div class="form-group">
                          <label><strong>Montant</strong></label>
                          <input type="text" name="coupon_amount" class="form-control input-lg" value="{{$gs->coupon_amount}}" {{empty($gs->coupon_amount)?'disabled':''}}>
                          @if ($errors->has('coupon_amount'))
                            <span style="color:red;">{{$errors->first('coupon_amount')}}</span>
                          @endif
                       </div>
                       <div class="form-group" id="minamount">
                          <label><strong>Montant Minimum</strong></label>
                          <input type="text" name="minimum_amount" class="form-control input-lg" value="{{$gs->coupon_min_amount}}" placeholder="Minimum Amount">
                          @if ($errors->has('minimum_amount'))
                            <span style="color:red;">{{$errors->first('minimum_amount')}}</span>
                          @endif
                       </div>
                       <div class="form-group">
                          <label><strong>Valable jusqu'au</strong></label>
                          <input id="validtill" type="text" name="valid_till" class="form-control input-lg" value="{{$gs->valid_till}}" readonly>
                          @if ($errors->has('valid_till'))
                            <span style="color:red;">{{$errors->first('valid_till')}}</span>
                          @endif
                       </div>
                    </div> --}}
                    <div class="form-group">
                       <label><strong>Code Coupon </strong></label>
                       <input type="text" name="coupon_code" class="form-control input-lg" value="{{old('coupon_code')}}">
                       @if ($errors->has('coupon_code'))
                         <span style="color:red;">{{$errors->first('coupon_code')}}</span>
                       @endif
                    </div>
                    <div class="form-group">
                       <label><strong>Type</strong></label><br>
                       <div class="form-check form-check-inline">
                         <input class="form-check-input" type="radio" name="coupon_type" id="inlineRadio1" value="fixed" {{old('coupon_type')=='fixed'?'checked':''}} onchange="changePlaceholder(this.value)">
                         <label class="form-check-label" for="inlineRadio1">Fixé</label>
                       </div>
                       <div class="form-check form-check-inline">
                         <input class="form-check-input" type="radio" name="coupon_type" id="inlineRadio2" value="percentage" {{old('coupon_type')=='percentage'?'checked':''}} onchange="changePlaceholder(this.value)">
                         <label class="form-check-label" for="inlineRadio2">Pourcentage</label>
                       </div>
                       @if ($errors->has('type_helper'))
                         <p><span style="color:red;">{{$errors->first('type_helper')}}</span></p>
                       @endif
                       <input type="hidden" name="type_helper" value="">
                    </div>
                    <div class="form-group">
                       <label><strong>Montant</strong></label>
                       <input type="text" name="coupon_amount" class="form-control input-lg" value="{{old('coupon_amount')}}">
                       @if ($errors->has('coupon_amount'))
                         <span style="color:red;">{{$errors->first('coupon_amount')}}</span>
                       @endif
                    </div>
                    <div class="form-group" id="minamount">
                       <label><strong>Montant minimal</strong></label>
                       <input type="text" name="minimum_amount" class="form-control input-lg" value="{{old('minimum_amount')}}" placeholder="Montant Minimum">
                       @if ($errors->has('minimum_amount'))
                         <span style="color:red;">{{$errors->first('minimum_amount')}}</span>
                       @endif
                    </div>
                    <div class="form-group">
                       <label><strong>Valable jusqu'au</strong></label>
                       <input id="validtill" type="text" name="valid_till" class="form-control input-lg" value="{{old('valid_till')}}" readonly>
                       @if ($errors->has('valid_till'))
                         <span style="color:red;">{{$errors->first('valid_till')}}</span>
                       @endif
                    </div>
                 </div>
                    <div class="form-actions">
                       <button type="submit" class="btn btn-primary btn-block btn-lg">Valider</button>
                    </div>
                 </form>
              </div>
           </div>
        </div>
     </div>
  </main>
@endsection

@push('scripts')
  <script>
    var currtxt = '{{$gs->base_curr_text}}';
    $( function() {
      $( "#validtill" ).datepicker();
    } );
    $(document).ready(function() {
      var type = $("input[name='coupon_type']:checked").val();
      console.log(type);
      if (type == 'fixed') {
        $("#minamount").addClass("d-block");
      } else {
        $("#minamount").addClass("d-none");
      }
    });

    function changePlaceholder(val) {
      document.getElementsByName('coupon_amount')[0].disabled = false;
      document.getElementsByName('coupon_amount')[0].value = '';
      if (val == 'fixed') {
        document.getElementsByName('coupon_amount')[0].placeholder = 'Entrez remise dans ' + currtxt;
        $("#minamount").addClass("d-block");
        $("#minamount").removeClass("d-none");
      } else if (val == 'percentage') {
        document.getElementsByName('coupon_amount')[0].placeholder = 'Entrez la réduction en pourcentage';
        $("#minamount").addClass("d-none");
        $("#minamount").removeClass("d-block");
      }
    }
  </script>
@endpush
