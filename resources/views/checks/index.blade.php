@extends('layouts.mep')

@section('page')
<aside class="page"> 
	<h2>Cheques</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Cheques</a></li>
			<li class="active-page"><a>Ver Cheques</a></li>
		</ul>
	</div>
</aside>
@endsection
@section('content')
	<div class="paddingWrapper">
		<section class="row form-group">
			<div class="table-data">
				<div class="table-header">
					<div class="row">
						<div class="col-sm-6">
							<h5><strong>Busqueda de Cheques</strong></h5>
						</div>

					</div>
				</div>
				<div class="row ">
					<form action="{{route('search-cheques')}}" method="post">
						<div class="form-group col-md-12 col-lg-12 text-center">
							<label>Digite el Numero de Cheque que desea Buscar</label>
							<input type="text" name="ckNumber" class="form-control">
						</div>
						<div class="form-group col-md-12 col-lg-12">
							<input type="submit" value="Buscar" class="btn btn-block" >
						</div>
					</form>
				</div>

			</div>
		</section>

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
						@if($searchs > 0)
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
										<a href="{{route('editar-cheques', $check->token)}}"><i class="fa fa-pencil-square-o"></i></a>
									</td>
								</tr>
							@endforeach
						@endif
						</tbody>
					</table>
				</div>
			</div>
		</section>
	</div>
@stop