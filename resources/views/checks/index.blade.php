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
	<section class="row">
		<div class="table-data">
			<div class="table-header">
				<div class="row">
					<div class="col-sm-6">
						<h5><strong>Lista de Cheques</strong></h5>		
					</div>
					<div class="col-sm-6">
						<a href="{{route('crear-cheques')}}" class="btn btn-info pull-right">
							<span class="glyphicon glyphicon-plus"></span>
							<span>Nuevo</span>
						</a>
					</div>
				</div>
			</div>
			<div class="table-content">
				<div class="table-responsive">
					<table id="table_checks" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <th>Cuenta</th>
                                <th>Monto Factura</th>
                                <th>Fecha</th>
                                <th>Proveedor</th>
                                <th>N° de Cheque</th>
                                <th>Planilla</th>
                                <th>Presupuesto</th>
                                <th>Estado</th>
                                <th>Edición</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($checks as $check)
	                            <tr>
	                                <td class="text-center balanceBudgetCheck" data-token="{{$check->token}}">{{$check->codeCuentaCatalog()}} - {{mb_convert_case($check->spreadsheets->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center">{{$check->amount}}</td>
	                                <td class="text-center">{{$check->date}}</td>
	                                <td class="text-center">{{$check->supplier->name}}</td>
	                                <td class="text-center">{{$check->bill}}</td>
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
                        </tbody>
                    </table>
				</div>
			</div>
		</div>
	</section>
</div>
@stop