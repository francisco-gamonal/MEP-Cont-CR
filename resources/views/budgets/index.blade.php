@extends('layouts.mep')

@section('page')
<aside class="page"> 
	<h2>Presupuestos</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Presupuestos</a></li>
			<li class="active-page"><a>Ver Presupuestos</a></li>
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
						<h5><strong>Lista de Presupuestos</strong></h5>		
					</div>
					<div class="col-sm-6">
						<a href="{{route('crear-presupuestos')}}" class="btn btn-info pull-right">
							<span class="glyphicon glyphicon-plus"></span>
							<span>Nuevo</span>
						</a>
					</div>
				</div>
				
			</div>
			<div class="table-content">
				<div class="table-responsive">
					<table id="table_budgets" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <!-- <th>Source</th> -->
                                <th>Fuente Financimiento</th>
                                <th>Año</th>
                                <th>Tipo</th>
                                <th>Global</th>
                                <th>Institución</th>
                                <th>Estado</th>
                                <th>Reporte</th>
                                <th>Actual</th>
                                <th>POA</th>
                                <th>Edición</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($budgets as $budget)
	                            <tr>
	                                <td class="text-center budget_name" data-token="{{$budget->token}}">{{mb_convert_case($budget->name, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <!-- <td class="text-center budget_source">{{mb_convert_case($budget->source, MB_CASE_TITLE, 'utf-8')}}</td> -->
	                                <td class="text-center budget_description">{{mb_convert_case($budget->ffinancing, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center budget_year">{{$budget->year}}</td>
	                                <td class="text-center budget_type">{{mb_convert_case($budget->type, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center budget_global edit-row">
	                                	{{mb_convert_case($budget->global, MB_CASE_TITLE, 'utf-8')}}
										<a href="{{route('report-global-presupuestos', $budget->schools->token)}}/{{$budget->global}}/{{$budget->year}}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
										<a href="{{route('reporte-presupuesto-ordinario-excel', $budget->schools->token)}}/{{$budget->global}}/{{$budget->year}}" target="_blank"><i class="fa fa-file-excel-o"></i></a>
	                                </td>
	                                <td class="text-center budget_school">{{mb_convert_case($budget->schools->name, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center">
	                                	@if($budget->deleted_at)
											<span>Inactivo</span>
	                                	@else
											<span>Activo</span>
	                                	@endif
	                                </td>
	                                <td class="text-center edit-row">
										<a href="{{route('report-presupuestos', $budget->token)}}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
										<a href="{{route('reporte-presupuesto-excel', $budget->token)}}" target="_blank"><i class="fa fa-file-excel-o"></i></a>
	                                </td>
	                                <td class="text-center edit-row">
	                                    <a><i class="fa fa-file-pdf-o"></i></a>
	                                    <a><i class="fa fa-file-excel-o"></i></a>
	                                </td>
	                                <td class="text-center edit-row">
										<a href="{{route('reporte-poa-presupuestos', $budget->token)}}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
                                        <a href="{{route('reporte-presupuestos', $budget->token)}}" target="_blank"><i class="fa fa-file-excel-o"></i></a>
	                                </td>
	                                <td class="text-center edit-row">
                                		@if($budget->deleted_at)
                                			<a id="activeBudget" data-url="presupuestos" href="#">
                                				<i class="fa fa-check-square-o"></i>
                            				</a>
                                		@else
                                			<a id="deleteBudget" data-url="presupuestos" href="#">
												<i class="fa fa-trash-o"></i>
											</a>
                                		@endif
										<a href="{{route('editar-presupuestos', $budget->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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