@extends('layout.master')

@section('title', 'Adresse de facturation')

@section('headertxt', "Adresse de facturation")

@push('styles')
<link rel="stylesheet" href="{{asset('assets/user/css/uorder-details.css')}}">
@endpush
@section('content')
  <!-- sellers product content area start -->
  <div class="sellers-product-content-area">
      <div class="container">
        <div class="row mb-2">
          <div class="col-md-12">
            <h2 style="font-size: 32px;margin-bottom: 28px;" class="order-heading">Information adresse de facturation</h2>
          </div>
          <div class="col-md-10 offset-1">
            <div class="card">
              <div class="card-header base-bg">
                <h6 class="white-txt no-margin"> Vendeur {{ $vendorInfos->shop_name}}</h6>
              </div>
              <div class="card-body">
                <p>
                  <strong>Téléphone : </strong>
                    <span class="">{{ $vendorInfos->phone}}</span>
                </p>
                <p>
                  <strong> Adresse email: </strong>
                    <span class="">{{ $vendorInfos->email }}</span>
                </p>
                <p>
                  <strong> Adresse: </strong>
                    <span class="">{{ $vendorInfos->address }}</span>
                </p>
                <p>
                  <strong> Code Zip: </strong>
                    <span class="">{{ $vendorInfos->zip_code }}</span>
                </p>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  <!-- sellers product content area end -->
@endsection
