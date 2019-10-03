@extends('layout.profilemaster')

@section('title', 'Professionnel')

@section('headertxt', 'Liste professionnel')

@section('content')
    <!-- <h3>Recherche Professionnel</h3>
    <form method="get" action="">
    <div class="input-group mb-2 mr-sm-2">
    <div class="input-group-prepend">
      <div class="input-group-text text-white" style="background-color:blue">
       <i class="fa fa-search" aria-hidden="true"></i>  recherche
    </div>
    </div>
    <input type="text" class="form-control" id="inlineFormInputGroupUsername2" placeholder="Recherche professionnel">
  </div>
    </form> -->
    <hr>
    <div class="col-md-12">
        <div class="seller-product-wrapper">
            <div class="seller-panel">
                <div class="sellers-product-inner">
                    <div class="bottom-content">
                        <table class="table table-default" id="datatableOne">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($vendors as $vendor)
                              <tr>
                                <td>{{ App\Vendor::where('id',$vendor->id)->first()->shop_name }}</td>
                                <td>{{ App\Vendor::where('id',$vendor->id)->first()->email }}</td>
                                <td>{{ App\Vendor::where('id',$vendor->id)->first()->phone }}</td>
                                <td>
                                    <a href="{{ route('envoi_msg.index',$vendor->id) }}" class="btn btn-success">
                                        <i class="fa fa-paper-plane" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="Envoyer un message"></i>
                                    </a>
                                    {{-- @if(App\Orderedproduct::where('id',$vendor->id)->first()->) --}}
                                    <a href="{{ route('user.orders',$vendor->id) }}" class="btn btn-info" data-toggle="tooltip" data-placement="top" title="Voir vos commandes">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                    {{-- @endif --}}
                                </td>
                              </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    <br>
@endsection
