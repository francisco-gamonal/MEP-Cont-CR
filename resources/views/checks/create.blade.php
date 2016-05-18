@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Cheques</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Cheques</a></li>
				<li class="active-page"><a>Registrar Cheque</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
        <div class="col-sm-6 col-md-6">
            <div class="form-mep">
                <label for="supplierCheck">Proveedor</label>
                <select id="supplierCheck" class="form-control">
                    @foreach($suppliers as $supplier)
                        <option value="{{$supplier->token}}">{{$supplier->name}}</option>
                    @endforeach
                </select>
            </div>
        </div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="billCheck">N° de Factura</label>
				<div class="input-group">
					<span class="input-group-addon">#</span>
					<input id="billCheck" class="form-control" type="text" maxlength="20">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="conceptCheck">Consepto</label>
				<div class="input-group">
					<span class="input-group-addon">#</span>
					<input id="conceptCheck" class="form-control" type="text" maxlength="60">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="numberCheck">N° de Depósito</label>
				<div class="input-group">
					<span class="input-group-addon">#</span>
			      	<input id="numberCheck" class="form-control" type="number">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateCheck">Fecha</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
			      	<input id="dateCheck" class="form-control" type="date">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="amountCheck">Monto de Factura</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-usd"></i></span>
			      	<input id="amountCheck" class="form-control" type="number">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="retentionCheck">Monto de Retención</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-usd"></i></span>
			      	<input id="retentionCheck" class="form-control" type="number">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="ckbillCheck">Número de Cheque</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="ckbillCheck" class="form-control" type="text">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="ckretentionCheck">Número de Cheque de Retención</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="ckretentionCheck" class="form-control" type="text">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="recordCheck">Número de Acta</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="recordCheck" class="form-control" type="text">
				</div>
			</div>
		</div>
		<!-- <div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="voucherCheck">Factura de Respaldo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-files-o"></i></span>
			      	<input id="voucherCheck" class="form-control" type="text">
				</div>
			</div>
		</div> -->
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="spreadsheetCheck">Planilla</label>
				<select id="spreadsheetCheck" class="form-control">
					@foreach($spreadsheets as $spreadsheet)
						<option value="{{$spreadsheet->token}}">{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}} - {{$spreadsheet->budgets->schoolBudget($spreadsheet->budget_id)->name}} - {{mb_convert_case($spreadsheet->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}</option>
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="balanceBudgetCheck">Número de Cuenta</label>
				<select id="balanceBudgetCheck" class="form-control">
					@foreach($balanceBudgets as $balanceBudget)
						<option value="{{$balanceBudget['id']}}">{{$balanceBudget['value']}}</option>
					@endforeach
				</select>
			</div>
		</div>

		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="statusCheck">Estado del Proveedor</label>
				<div class="row">
		      		<input id="statusCheck" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
		      	</div>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-cheques')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="saveCheck" data-url="cheques" class="btn btn-success">Grabar Cheque</a>
	</div>
</div>
@stop