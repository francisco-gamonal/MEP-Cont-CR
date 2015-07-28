@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Planillas</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Planillas</a></li>
				<li class="active-page"><a>Editar Planilla</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row form-spreadsheet">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="numberSpreadsheets">Número de Planilla</label>
					<div class="input-group">
						<span class="input-group-addon">#</span>
				      	<input id="numberSpreadsheets" class="form-control" type="number" value="{{$spreadsheet->number}}" data-token="{{$spreadsheet->token}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="yearSpreadsheets">Año de Planilla</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="yearSpreadsheets" class="form-control" type="number" value="{{$spreadsheet->year}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="dateSpreadsheets">Fecha de Planilla</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
				      	<input id="dateSpreadsheets" class="form-control" type="date" value="{{$spreadsheet->date}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeBudgetSpreadsheets">Tipo de Presupuesto</label>
					<select id="typeBudgetSpreadsheets" class="form-control">
						@foreach($typeBudgets as $typeBudget)
							@if($typeBudget->id == $spreadsheet->type_budget_id)
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
					<label for="budgetSpreadsheets">Presupuesto del Saldo de Presupuesto</label>
					<select id="budgetSpreadsheets" class="form-control">
						@foreach($budgets as $budget)
							@if($budget->id == $spreadsheet->budget_id)
								<option value="{{$budget->token}}" selected>{{mb_convert_case($budget->name, MB_CASE_TITLE, 'utf-8')}} - {{mb_convert_case($budget->schoolBudget($budget->id)->name, MB_CASE_TITLE, 'utf-8')}}</option>
							@else
								<option value="{{$budget->token}}">{{mb_convert_case($budget->name, MB_CASE_TITLE, 'utf-8')}} - {{mb_convert_case($budget->schoolBudget($budget->id)->name, MB_CASE_TITLE, 'utf-8')}}</option>
							@endif
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusSpreadsheets">Estado de la Planilla</label>
					<div class="row">
						@if($spreadsheet->deleted_at)
			      			<input id="statusSpreadsheets" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
			      		@else
							<input id="statusSpreadsheets" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      		@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-planillas')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateSpreadsheet" data-url="institucion/inst/planillas" class="btn btn-success">Actualizar Planilla</a>
		</div>
	</div>
@stop