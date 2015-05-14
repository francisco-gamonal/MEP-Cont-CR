@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Presupuestos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Presupuestos</a></li>
				<li class="active-page"><a>Registrar Presupuesto</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameBudget">Nombre del Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="sourceBudget">Source del Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="sourceBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="descriptionBudget">Descripción del Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><span class="glyphicon glyphicon-list-alt"></span></span>
				      	<input id="descriptionBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="yearBudget">Año del Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="yearBudget" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeBudget">Tipo de Presupuesto</label>
					<select id="typeBudget" class="form-control">
						<option value="ordinario">Ordinario</option>
						<option value="extraordinario">Extraordinario</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="globalBudget">Global del Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="globalBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="schoolBudget">Institución del Presupuesto</label>
					<select id="schoolBudget" class="form-control">
						@foreach($schools as $school)
							<option value="{{$school->token}}">{{mb_convert_case($school->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusBudget">Estado del Presupuesto</label>
					<div class="row">
			      		<input id="statusBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-presupuestos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveBudget" data-url="presupuestos" class="btn btn-success">Grabar Presupuesto</a>
		</div>
	</div>
@stop