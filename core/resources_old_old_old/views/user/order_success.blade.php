@extends('layout.master')

@section('headertxt', 'Order Success')

@push('styles')
<style media="screen">
.alert-success {
    text-align:center;
    font-size: 24px;
    font-weight: 700;
    padding: 50px 0px;
    margin: 50px 0px;
}
</style>
@endpush

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="alert alert-success" role="alert">
          <strong>Succès!</strong>
          La commande a été passée avec succès! Nous vous contacterons bientôt!
        </div>
      </div>
    </div>
  </div>
@endsection
