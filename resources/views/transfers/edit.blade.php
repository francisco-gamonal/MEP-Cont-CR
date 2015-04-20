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
	<h2>Transferencias</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Transferencuas</a></li>
			<li class="active-page"><a>Editar Transferencia</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="codeTransfer">Número de Transferencia</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="codeTransfer" class="form-control" type="text" value="{{$transfer['code']}}" data-token="{{$transfer['token']}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateTransfer">Fecha de Transferencia</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="dateTransfer" class="form-control" type="date" value="{{$transfer['date']}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="simulationTransfer">Simulación de Transferencia</label>
				<select id="simulationTransfer" class="form-control">
					@if($transfer['simulation'] == 'false')
						<option value="f" selected>No</option>
						<option value="v">Si</option>
					@else
						<option value="f">No</option>
						<option value="v" selected>Si</option>
					@endif
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="spreadsheetTransfer">Planilla</label>
				<select id="spreadsheetTransfer" class="form-control">
					@foreach($spreadsheets as $spreadsheet)
						@if($spreadsheet->token == $transfer['tokenSpreadsheets'])
							<option value="{{$spreadsheet->token}}" selected>{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}}</option>
						@else
							<option value="{{$spreadsheet->token}}">{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="inBalanceBudgetTransfer">Número de Cuenta Aumento</label>
				<select id="inBalanceBudgetTransfer" class="form-control">
					@foreach($balanceBudgets as $balanceBudget)
						@if($balanceBudget['id'] == $transfer['balancebudgetIn']['token'])
							<option value="{{$balanceBudget['id']}}" selected>{{$balanceBudget['value']}}</option>
						@else
							<option value="{{$balanceBudget['id']}}">{{$balanceBudget['value']}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label>Número de Cuenta Disminución</label>
				<div class="row outBalance">
					@foreach($transfer['balancebudgetOut'] as $balanceBudgetOut)
					<aside class="row" style="margin-bottom: .5em;">
						<div class="col-sm-9" style="padding:0;">
							<select class="form-control outBalanceBudgetTransfer">
								@foreach($balanceBudgets as $balanceBudget)
									@if($balanceBudget['id'] == $balanceBudgetOut['token'])
										<option value="{{$balanceBudget['id']}}" selected>{{$balanceBudget['value']}}</option>
									@else
										<option value="{{$balanceBudget['id']}}">{{$balanceBudget['value']}}</option>
									@endif
								@endforeach
							</select>
						</div>
						<div class="col-sm-3" style="padding-right:0;">
							<input class="form-control amountBalanceBudgetTransfer" type="number" value="{{$balanceBudgetOut['amount']}}">
						</div>
					</aside>
					@endforeach
				</div>
				<button id="addAccount" class="btn btn-info">Agregar Cuenta</button>
				@if(count($transfer['balancebudgetOut'])>1)
					<button id="removeAccount" class="btn btn-danger">Eliminar Cuenta</button>
				@else
					<button id="removeAccount" class="btn btn-danger hide">Eliminar Cuenta</button>
				@endif
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="statusTransfer">Estado de la Transferencia</label>
				<div class="row">
		      		<input id="statusTransfer" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
		      	</div>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-transferencias')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateTransfer" data-url="transferencias" class="btn btn-success">Actualizar Transferencia</a>
	</div>
</div>
@stop