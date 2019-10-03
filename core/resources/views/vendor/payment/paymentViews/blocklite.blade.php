@extends('layout.master')
@section('content')

<div class="row my-5">
	<div class="col-md-12">
		<div class="panel panel-inverse">
			<div class="panel-heading">
				<h3 class="panel-title text-center">{{$pt}}</h3>
			</div>
			<div class="panel-body text-center">
				<h6> VEUILLEZ ENVOYER EXACTEMENT <span style="color: green"> {{ $bcoin }}</span> LITECOIN</h6>
				<h5>A <span style="color: green"> {{ $wallet}}</span></h5>
				{!! $qrurl !!}
				<h4 style="font-weight:bold;">SCAN A SEND</h4>
			</div>
		</div>
	</div>
</div>

@endsection
