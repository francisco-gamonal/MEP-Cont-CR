@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Grupos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Grupos</a></li>
				<li class="active-page"><a>Registrar Grupo</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="codeGroup">Código del Grupo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="codeGroup" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameGroup">Nombre del Grupo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-th-list"></i></span>
				      	<input id="nameGroup" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusGroup">Estado del Grupo</label>
					<div class="row">
			      		<input id="statusGroup" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-grupos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveGroup" data-url="grupos" class="btn btn-success">Grabar Grupo</a>
		</div>
	</div>
@stop