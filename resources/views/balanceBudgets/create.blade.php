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
				<li><a>Saldo de Presupuestos</a></li>
				<li class="active-page"><a>Crear Saldo de Presupuesto</a></li>
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
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="amountBalanceBudget" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="policiesBalanceBudget">Políticas del Saldo de Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="policiesBalanceBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="strategicBalanceBudget">Estratégico del Saldo de Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="strategicBalanceBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="operationalBalanceBudget">Operacional del Saldo de Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="operationalBalanceBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="goalsBalanceBudget">Metas del Saldo de Presupuesto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="goalsBalanceBudget" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="catalogsBalanceBudget">Catálogo del Saldo de Presupuesto</label>
					<select id="catalogsBalanceBudget" class="form-control">
						@foreach($catalogs as $catalog)
							<option value="{{$catalog->token}}">{{mb_convert_case($catalog->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="budgetBalanceBudget">Presupuesto del Saldo de Presupuesto</label>
					<select id="budgetBalanceBudget" class="form-control">
						@foreach($budgets as $budget)
							<option value="{{$budget->token}}">{{mb_convert_case($budget->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeBudgetBalanceBudget">Tipo de Presupuesto del Saldo de Presupuesto</label>
					<select id="typeBudgetBalanceBudget" class="form-control">
						@foreach($typeBudgets as $typeBudget)
							<option value="{{$typeBudget->token}}">{{mb_convert_case($typeBudget->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="simulationBalanceBudget">Simulación de Saldo de Presupuesto</label>
					<select id="simulationBalanceBudget" class="form-control">
						<option value="f">No</option>
						<option value="v">Si</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusBalanceBudget">Estado del Presupuesto</label>
					<div class="row">
			      		<input id="statusBalanceBudget" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="#" id="saveBalanceBudget" data-url="saldo-de-presupuestos" class="btn btn-success">Grabar Saldo de Presupuesto</a>
		</div>
	</div>
@stop