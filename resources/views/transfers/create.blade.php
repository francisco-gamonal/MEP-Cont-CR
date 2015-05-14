@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Transferencias</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Transferencias</a></li>
				<li class="active-page"><a>Registrar Transferencia</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateTransfer">Fecha de Transferencia</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			      	<input id="dateTransfer" class="form-control" type="date">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="simulationTransfer">Simulación de Transferencia</label>
				<select id="simulationTransfer" class="form-control">
					<option value="f">No</option>
					<option value="v">Si</option>
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="spreadsheetTransfer">Planilla</label>
				<select id="spreadsheetTransfer" class="form-control">
					@foreach($spreadsheets as $spreadsheet)
						<option value="{{$spreadsheet->token}}">{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="inBalanceBudgetTransfer">Número de Cuenta Aumento</label>
				<select id="inBalanceBudgetTransfer" class="form-control">
					@foreach($balanceBudgets as $balanceBudget)
						<option value="{{$balanceBudget['id']}}">{{$balanceBudget['value']}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label>Número de Cuenta Disminución</label>
				<div class="row outBalance">
					<aside class="row" style="margin-bottom: .5em;">
						<div class="col-sm-9" style="padding:0;">
							<select class="form-control outBalanceBudgetTransfer">
								@foreach($balanceBudgets as $balanceBudget)
									<option value="{{$balanceBudget['id']}}">{{$balanceBudget['value']}}</option>
								@endforeach
							</select>
						</div>
						<div class="col-sm-3" style="padding-right:0;">
							<input class="form-control amountBalanceBudgetTransfer" type="number">
						</div>
					</aside>
				</div>
				<button id="addAccount" class="btn btn-info">Agregar Cuenta</button>
				<button id="removeAccount" class="btn btn-danger hide">Eliminar Cuenta</button>
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
	<br>
	<div class="row text-center">
		<a href="{{route('ver-transferencias')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="saveTransfer" data-url="transferencias" class="btn btn-success">Grabar Transferencia</a>
	</div>
</div>
@stop