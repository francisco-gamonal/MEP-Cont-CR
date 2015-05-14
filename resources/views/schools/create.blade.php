@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Institución</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Institución</a></li>
				<li class="active-page"><a>Registrar Institución</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameSchool">Nombre de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-university"></i></span>
				      	<input id="nameSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="charterSchool">Cédula de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="charterSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="circuitSchool">Circuito de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="circuitSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="codeSchool">Código de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				      	<input id="codeSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="ffinancingSchool">Financiamiento de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="ffinancingSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="presidentSchool">Presidente de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="presidentSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="secretarySchool">Secretaria de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-female"></i></span>
				      	<input id="secretarySchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="accountSchool">Cuenta de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
				      	<input id="accountSchool" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="titleOneSchool">Título Uno de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-inbox"></i></span>
				      	<input id="titleOneSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="titleTwoSchool">Título Dos de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-inbox"></i></span>
				      	<input id="titleTwoSchool" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusSchool">Estado de la Institución</label>
					<div class="row">
			      		<input id="statusSchool" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-institucion')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveSchool" data-url="institucion" class="btn btn-success">Grabar Institución</a>
		</div>
	</div>
@stop