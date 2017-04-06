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
		<div class="col-sm-4 col-md-3">
			<div class="form-mep">
				<label for="dateCheck">Fecha</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
					<input id="dateCheck" readonly class="form-control" type="date" value="{{$temporaryChecks->date}}">
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-3">
			<div class="form-mep">
				<label for="recordCheck">Número de Acta</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					<input id="recordCheck" readonly class="form-control" type="text" value="{{$temporaryChecks->record}}">
				</div>
			</div>
		</div>
		<div class="col-sm-4 col-md-3">
			<div class="form-mep">
				<label for="ckbillCheck">Número de Cheque</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					<input id="ckbillCheck" class="form-control" readonly type="text" value="{{$temporaryChecks->ckbill}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-3">
			<div class="form-mep">
				<label for="ckretentionCheck">Número de Cheque de Retención</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					<input id="ckretentionCheck" readonly class="form-control" type="text" value="{{$temporaryChecks->ckretention}}">
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-12">
			<div class="form-mep">
				<label for="spreadsheetCheck">Planilla</label>
				<input id="" readonly class="form-control" value="
			{{$temporaryChecks->spreadsheet->number.'-'.$temporaryChecks->spreadsheet->year.' '.$temporaryChecks->spreadsheet->budgets->name}} - {{$temporaryChecks->spreadsheet->budgets->schoolBudget($temporaryChecks->spreadsheet->budget_id)->name}} - {{mb_convert_case($temporaryChecks->spreadsheet->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}" >
			<input type="hidden" id="spreadsheetCheck" value="{{$temporaryChecks->spreadsheet->token}}">
			<input type="hidden" id="tokenCheck" value="{{$temporaryChecks->token}}">
			</div>
		</div>


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
				<label for="conceptCheck">Concepto</label>
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
		<a href="#" id="saveDetail" data-url="cheques" class="btn btn-success">Grabar Cheque</a>
	</div>
</div>
<div class="form-group paddingWrapper">
	<section class="row">
		<div class="table-data row">
			<div class="table-header form-group">
				<table id="table_checks" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
					<thead>
					<tr>
						<th>Cuenta</th>
						<th>Monto Factura</th>
						<th>Fecha</th>
						<th>Proveedor</th>
						<th>N° de Cheque</th>
						<th>N° de CK Retencion</th>
						<th>Planilla</th>
						<th>Presupuesto</th>
						<th>Estado</th>
						<th>Edición</th>
					</tr>
					</thead>
					<tbody>

						@foreach($checks->get() as $check)
							<tr>
								<td class="text-center balanceBudgetCheck" data-token="{{$check->token}}">{{$check->codeCuentaCatalog()}} - {{mb_convert_case($check->spreadsheets->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}</td>
								<td class="text-center">{{$check->amount}}</td>
								<td class="text-center">{{$check->spreadsheets->date}}</td>
								<td class="text-center">{{$check->supplier->name}}</td>
								<td class="text-center">{{$check->ckbill}}</td>
								<td class="text-center">{{$check->ckretention}}</td>
								<td class="text-center">{{$check->numberSpreadsheet()}}</td>
								<td class="text-center">{{$check->spreadsheets->budgets->name}} - {{$check->spreadsheets->budgets->schoolBudget($check->spreadsheets->budget_id)->name}}</td>
								<td class="text-center">
									@if($check->deleted_at)
										<span>Inactivo</span>
									@else
										<span>Activo</span>
									@endif
								</td>
								<td class="text-center edit-row">
									@if($check->deleted_at)
										<a id="activeCheck" data-url="cheques" href="#">
											<i class="fa fa-check-square-o"></i>
										</a>
									@else
										<a id="deleteCheck" data-url="cheques" href="#">
											<i class="fa fa-trash-o"></i>
										</a>
									@endif

								</td>
							</tr>
						@endforeach

					</tbody>
				</table>
			</div>
		</div>
	</section>
</div>
@stop