@extends('layout.master')

@section('title', 'Créer mon espace ')

@section('headertxt', 'Créer mon espace')

@section('content')
  @php
    $vendor = Auth::guard('vendor')->user();
  @endphp
  <!-- product upload area start -->
  <div class="product-upload-area">
      <div class="container">
          <div class="row">
              <div class="col-lg-12">
                <div class="card">
                  <div class="card-header base-bg">
                    <h3 class="mb-0 text-white">Créer mon espace</h3>
                  </div>
                  <div class="card-body">
                    <div class="product-upload-inner"><!-- product upload inner -->
                        <form action="{{route('vendor.setting.update')}}" method="post" class="product-upload-form" enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-element margin-bottom-20">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail">
                                      @if (empty(Auth::guard('vendor')->user()->logo))
                                        <img src="{{asset('assets/user/img/shop-logo/nopic.jpg')}}" alt="" />
                                      @else
                                        <img src="{{asset('assets/user/img/shop-logo/' . Auth::guard('vendor')->user()->logo)}}" alt="" />
                                      @endif
                                    </div>
                                    <div class="fileinput-preview fileinput-exists thumbnail" style="width: 250px;"> </div>
                                    <div>
                                        <span class="btn btn-success btn-file">
                                            <span class="fileinput-new"> Choisissez votre Logo </span>
                                            <span class="fileinput-exists">Changez </span>
                                            <input name="logo" type="file" value="">
                                        </span>
                                        <a href="javascript:;" class="btn red fileinput-exists" data-dismiss="fileinput"> Remove </a>
                                        <label style="display:inline-block;" for=""><span>**</span></label>
                                    </div>
                                </div>
                                @if ($errors->has('shop_name'))
                                  <p class="text-danger">{{$errors->first('shop_name')}}</p>
                                @endif
                            </div>
                            <div class="form-element margin-bottom-20">
                                <label>Nom Boutique <span>**</span></label>
                                <input name="shop_name" value="{{$vendor->shop_name}}" type="text" class="input-field" placeholder="Entrer Shop Name...">
                                @if ($errors->has('shop_name'))
                                  <p class="text-danger">{{$errors->first('shop_name')}}</p>
                                @endif
                            </div>
                            <div class="row">
                              <div class="col-md-6">
                                <div class="form-element margin-bottom-20">
                                    <label>Email <span>**</span></label>
                                    <input value="{{$vendor->email}}" type="text" class="input-field" placeholder="Product Email Address..." disabled>
                                </div>
                              </div>
                              <div class="col-md-6">
                                <div class="form-element margin-bottom-20">
                                    <label>Téléphone <span>**</span></label>
                                    <input name="phone" value="{{$vendor->phone}}" type="text" class="input-field" placeholder="Entrer Phone Number...">
                                    @if ($errors->has('phone'))
                                      <p class="text-danger">{{$errors->first('phone')}}</p>
                                    @endif
                                </div>
                              </div>
                            </div>
                            <div class="row">
                              <div class="col-md-4">
                                <div class="form-element margin-bottom-20">
                                    <label>Adresse <span>**</span></label>
                                    <input name="address" value="{{$vendor->address}}" type="text" class="input-field" placeholder="Entrer Address...">
                                    @if ($errors->has('address'))
                                      <p class="text-danger">{{$errors->first('address')}}</p>
                                    @endif
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-element margin-bottom-20">
                                    <label>Code Zip<span>**</span></label>
                                    <input name="zip_code" value="{{$vendor->zip_code}}" type="text" class="input-field" placeholder="Entrer Zip Code...">
                                    @if ($errors->has('zip_code'))
                                      <p class="text-danger">{{$errors->first('zip_code')}}</p>
                                    @endif
                                </div>
                              </div>
                              <div class="col-md-4">
                                <div class="form-element margin-bottom-20">
                                    <label>Code Siret<span>**</span></label>
                                    <input name="siret_code" value="{{$vendor->siret_code}}" type="text" class="input-field" placeholder="Entrer votre code siret ...">
                                    @if ($errors->has('siret_code'))
                                      <p class="text-danger">{{$errors->first('siret_code')}}</p>
                                    @endif
                                </div>
                              </div>
                            </div>
                            <div class="row" style="height:25%">
                              <div class="col-md-4" style="padding-top:1%;">
                                <label for="regions_sect" class="offset-4"><strong>REGION</strong></label>
                                <select name='regions_sect' class="regions_sect form-control">
                                </select>
                                @if ($errors->has('regions_sect'))
                                    <p class="text-danger">{{$errors->first('regions_sect')}}</p>
                                @endif
                              </div>
                              <div class="col-md-4" style="padding-top:1%;">
                                <label for="departement_sect" class="offset-4"><strong>DEPARTEMENT</strong></label>
                                <select name='departement_sect' class="departement_sect form-control">
                                </select>
                                @if ($errors->has('departement_sect'))
                                    <p class="text-danger">{{$errors->first('departement_sect')}}</p>
                                @endif
                              </div>
                              <div class="col-md-4" style="padding-top:1%;">
                                <label for="ville_sect" class="offset-4"><strong>VILLE</strong></label>
                                <select name='ville_sect' class="ville_sect form-control">
                                </select>
                                @if ($errors->has('ville_sect'))
                                  <p class="text-danger">{{$errors->first('ville_sect')}}</p>
                                @endif
                              </div>
                            </div>
                            <br>
                            <div class="row">
                              <div class="col-md-12 ">
                              <div class="btn-wrapper mb-2">
                                  <input type="submit" class="submit-btn" value="Mise à jour">
                              </div>
                              <!-- </div> -->
                            </div>
                        </form>
                    </div><!-- //.product upload inner -->
                  </div>
                </div>
              </div>
          </div>
      </div>
  </div>
  <!-- product upload area end -->
@endsection
@section('js-scripts')
  <script>
    $(document).ready(function(){
      $(".ville_sect").select2({
        placeholder: 'Entrer votre ville',
        language: "fr",
     ajax: {
      url: "{{ route('get.cities') }}",
      dataType: 'JSON',
      delay: 100,
    processResults: function (data) {
    return {
      results:  $.map(data, function (item) {
        return {
                text: item.name,
                id: item.id
            }
        })
    };
  },
  cache: true,
}
    });
    $(".departement_sect").select2({
        placeholder: 'Entrer votre departement',
        language: "fr",
     ajax: {
      url: "{{ route('get.departement') }}",
      dataType: 'JSON',
      delay: 250,
    processResults: function (data) {
    return {
      results:  $.map(data, function (item) {
        return {
                text: item.name,
                id: item.code
            }
        })
    };
  },
  cache: true,
  }
});
$(".regions_sect").select2({
        placeholder: 'Entrer votre regions',
        language: "fr",
     ajax: {
      url: "{{ route('get.regions') }}",
      dataType: 'JSON',
      delay: 250,
    processResults: function (data) {
    return {
      results:  $.map(data, function (item) {
        return {
                text: item.name,
                id: item.code
            }
        })
    };
  },
  cache: true,
}
});
$('.departement_sect').on('select2:select', function (e){
    var cod_depart = e.params.data.id;
    $.ajax({
        url:'{{ route('test') }}',
        dataType:'JSON',
        method:'GET',
        data:{
          'cod_depart': cod_depart
        }
    })
    .done(function(data){
      var newOptions='';
      if(cod_depart!=''){
        $.each(data, function(key,value){
         newOptions += '<option value="' + value.id + '">' + value.name + '</option>';
        })
          $('.ville_sect').select2('destroy').html(newOptions).prop("disabled", false).select2();
    }
    })
});
$('.regions_sect').on('select2:select', function (e){
    var datas = e.params.data.id;
    $.ajax({
        url:'{{ route('get.region.query') }}',
        dataType:'JSON',
        method:'GET',
        data:{
          'cod_region': datas
        }
    })
    .done(function(data){
      var newOptions='';
      if(datas!=''){
        $.each(data, function(key,value){
         newOptions += '<option value="' + value.id + '">' + value.name + '</option>';
        })
          $('.departement_sect').select2('destroy').html(newOptions).prop("disabled", false).select2();
    }
      })
})
});
</script>
@endsection
