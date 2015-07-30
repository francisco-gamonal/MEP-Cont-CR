@extends('layouts.mep')

@section('page')
<aside class="page"> 
	<h2>Presupuestos</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Presupuestos</a></li>
			<li class="active-page"><a>Editar Presupuesto</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row form-">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="nameBudget">Nombre del Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-tag"></i></span>
			      	<input id="nameBudget" class="form-control" type="text" value="{{$budget->name}}" data-token="{{$budget->token}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="sourceBudget">Source del Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-tag"></i></span>
			      	<input id="sourceBudget" class="form-control" type="text" value="{{$budget->source}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="ffinancingBudget">Financiamiento del Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="ffinancingBudget" class="form-control" type="text" value="{{$budget->ffinancing}}">
					</div>
				</div>
			</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="yearBudget">Año del Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			      	<input id="yearBudget" class="form-control" type="number" value="{{$budget->year}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="typeBudget">Tipo de Presupuesto</label>
				<select id="typeBudget" class="form-control">
					@if($budget->type == 'ordinario')
						<option value="ordinario" selected>Ordinario</option>
						<option value="extraordinario">Extraordinario</option>
					@else
						<option value="ordinario">Ordinario</option>
						<option value="extraordinario" selected>Extraordinario</option>
					@endif
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="globalBudget">Global del Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="globalBudget" class="form-control" type="text" value="{{$budget->global}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="statusBudget">Estado del Presupuesto</label>
				<div class="row">
					@if($budget->deleted_at)
		      			<input id="statusBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
		      		@else
						<input id="statusBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
		      		@endif
		      	</div>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-presupuestos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateBudget" data-url="institucion/inst/presupuestos" class="btn btn-success">Actualizar Presupuesto</a>
	</div>
</div>
@stop