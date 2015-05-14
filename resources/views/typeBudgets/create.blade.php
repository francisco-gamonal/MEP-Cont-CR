@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Tipos de Presupuestos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tipos de Presupuestos</a></li>
				<li class="active-page"><a>Registrar Tipo de Presupuesto</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameTypeBudget">Nombre del Tipo de Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameTypeBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusTypeBudget">Estado del Tipo de Presupuesto</label>
					<div class="row">
			      		<input id="statusTypeBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
			<div class="row text-center">
				<a href="{{route('ver-tipos-de-presupuestos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
				<a href="#" id="saveTypeBudget" data-url="tipos-de-presupuestos	" class="btn btn-success">Grabar Tipo de Presupuesto</a>
			</div>
		</section>
	</div>
@stop