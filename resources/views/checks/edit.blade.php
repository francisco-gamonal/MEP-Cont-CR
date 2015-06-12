@extends('layouts.mep')

@section('page')
<aside class="page"> 
	<h2>Cheques</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Cheques</a></li>
			<li class="active-page"><a>Editar Cheque</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="billCheck">N° de Factura</label>
				<div class="input-group">
					<span class="input-group-addon">#</span>
			      	<input id="billCheck" class="form-control" type="text" value="{{$check->bill}}" data-token="{{$check->token}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="conceptCheck">Concepto de Pago</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
			      	<input id="conceptCheck" class="form-control" type="text" value="{{$check->concept}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="amountCheck">Monto de Factura</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-usd"></i></span>
			      	<input id="amountCheck" class="form-control" type="number" value="{{$check->amount}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="retentionCheck">Monto de Retención</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-usd"></i></span>
			      	<input id="retentionCheck" class="form-control" type="number" value="{{$check->retention}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="ckbillCheck">Número de Factura del Cheque</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="ckbillCheck" class="form-control" type="text" value="{{$check->ckbill}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="ckretentionCheck">Número de Retención del Cheque</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="ckretentionCheck" class="form-control" type="text" value="{{$check->ckretention}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="recordCheck">Número de Acta</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="recordCheck" class="form-control" type="text" value="{{$check->record}}">
				</div>
			</div>
		</div>
		<!--<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateCheck">Fecha del Cheque</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			      	<input id="dateCheck" class="form-control" type="date" value="{{$check->date}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="voucherCheck">Factura de Respaldo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-files-o"></i></span>
			      	<input id="voucherCheck" class="form-control" type="text" value="{{$check->vouchers_id}}">
				</div>
			</div>
		</div>-->
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="spreadsheetCheck">Planilla</label>
				<select id="spreadsheetCheck" class="form-control" data-url="editar-cheque">
					@foreach($spreadsheets as $spreadsheet)
						@if($spreadsheet->id == $check->spreadsheets_id)
							<option value="{{$spreadsheet->token}}" selected>{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}} - {{$spreadsheet->budgets->schoolBudget($spreadsheet->budget_id)->name}} - {{mb_convert_case($spreadsheet->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@else
							<option value="{{$spreadsheet->token}}">{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}} - {{$spreadsheet->budgets->schoolBudget($spreadsheet->budget_id)->name}} - {{mb_convert_case($spreadsheet->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="balanceBudgetCheck">Número de Cuenta</label>
				<select id="balanceBudgetCheck" class="form-control">
					@foreach($balanceBudgets as $balanceBudget)
						@if($balanceBudget['idBalanceBudgets'] == $check->balance_budget_id)
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
				<label for="supplierCheck">Proveedor</label>
				<select id="supplierCheck" class="form-control">
					@foreach($suppliers as $supplier)
						@if($supplier->id == $check->supplier_id)
							<option value="{{$supplier->token}}" selected>{{$supplier->name}}</option>
						@else
							<option value="{{$supplier->token}}">{{$supplier->name}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="statusCheck">Estado del Cheque</label>
				<div class="row">
					@if($check->deleted_at)
		      			<input id="statusCheck" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
		      		@else
						<input id="statusCheck" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
		      		@endif
		      	</div>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-cheques')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateCheck" data-url="cheques" class="btn btn-success">Actualizar Cheques</a>
	</div>
</div>
@stop