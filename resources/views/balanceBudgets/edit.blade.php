@extends('layouts.mep')

@section('message')
<div class="message border-bottom">
	<div class="row">
		<div class="col-md-4">
			<a href="#"><span class="glyphicon glyphicon-th-list"></span></a>
		</div>
		<div class="col-md-8">
			<div class="pull-right">
				<div class="list-inline-block">
					<ul>
						<li><a>Bienvenido Anwar Sarmiento - Administrador</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-envelope"></span></a></li>
						<li><a href="#"><span class="glyphicon glyphicon-log-out"></span><span> Cerrar Sesión</span></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@section('page')
<aside class="page"> 
	<h2>Saldo de Presupuestos</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Presupuestos</a></li>
			<li class="active-page"><a>Editar Saldo de Presupuesto</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="amountBalanceBudget">Cantidad del Saldo de Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon">#</span>
			      	<input id="amountBalanceBudget" class="form-control" type="number" value="{{$balanceBudget->amount}}" data-token="{{$balanceBudget->token}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="policiesBalanceBudget">Políticas del Saldo de Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
			      	<input id="policiesBalanceBudget" class="form-control" type="text" value="{{$balanceBudget->policies}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="strategicBalanceBudget">Estratégico del Saldo de Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-text"></i></span>
			      	<input id="strategicBalanceBudget" class="form-control" type="text" value="{{$balanceBudget->strategic}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="operationalBalanceBudget">Operacional del Saldo de Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file"></i></span>
			      	<input id="operationalBalanceBudget" class="form-control" type="text" value="{{$balanceBudget->operational}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="goalsBalanceBudget">Metas del Saldo de Presupuesto</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-archive-o"></i></span>
			      	<input id="goalsBalanceBudget" class="form-control" type="text" value="{{$balanceBudget->goals}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="catalogsBalanceBudget">Catálogo del Saldo de Presupuesto</label>
				<select id="catalogsBalanceBudget" class="form-control">
					@foreach($catalogs as $catalog)
						@if($catalog->id == $balanceBudget->catalogs_id)
							<option value="{{$catalog->token}}" selected>{{mb_convert_case($catalog->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@else
							<option value="{{$catalog->token}}">{{mb_convert_case($catalog->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="budgetBalanceBudget">Presupuesto del Saldo de Presupuesto</label>
				<select id="budgetBalanceBudget" class="form-control">
					@foreach($budgets as $budget)
						@if($budget->id == $balanceBudget->budgets_id)
							<option value="{{$budget->token}}" selected>{{mb_convert_case($budget->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@else
							<option value="{{$budget->token}}">{{mb_convert_case($budget->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="typeBudgetBalanceBudget">Tipo de Presupuesto del Saldo de Presupuesto</label>
				<select id="typeBudgetBalanceBudget" class="form-control">
					@foreach($typeBudgets as $typeBudget)
						@if($typeBudget->id == $balanceBudget->types_budgets_id)
							<option value="{{$typeBudget->token}}" selected>{{mb_convert_case($typeBudget->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@else
							<option value="{{$typeBudget->token}}">{{mb_convert_case($typeBudget->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="statusBalanceBudget">Estado del Presupuesto</label>
				<div class="row">
					@if($balanceBudget->deleted_at)
			      		<input id="statusBalanceBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
			      	@else
						<input id="statusBalanceBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	@endif
		      	</div>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-saldo-de-presupuestos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateBalanceBudget" data-url="saldo-de-presupuestos" class="btn btn-success">Actualizar Saldo de Presupuesto</a>
	</div>
</div>
@stop