@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Cuentas Bancarias</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Cuentas Bancarias</a></li>
				<li class="active-page"><a>Registrar Cuenta Bancaria</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="numberBankAccount">Número de Cuenta Bancaria</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="numberBankAccount" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameBankAccount">Nombre de la Cuenta Bancaria</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="nameBankAccount" class="form-control" type="text">
					</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-cuentas-bancarias')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveBankAccount" data-url="cuentas-bancarias" class="btn btn-success">Grabar Cuena Bancaria</a>
		</div>
	</div>
@stop