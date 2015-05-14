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
			<li class="active-page"><a>Ver Saldos de Presupuestos</a></li>
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
						<h5><strong>Lista de Saldos de Presupuestos</strong></h5>
					</div>
					<div class="col-sm-6">
						<a href="{{route('registrar-saldo-de-presupuesto')}}" class="btn btn-info pull-right">
							<span class="glyphicon glyphicon-plus"></span>
							<span>Nuevo</span>
						</a>
					</div>
				</div>
			</div>
			<div class="table-content">
				<div class="table-responsive">
					<table id="table_balanceBudgets" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <th>Cantidad</th>
                                <th>Políticas</th>
                                <th>Estratégico</th>
                                <th>Operacional</th>
                                <th>Metas</th>
                                <th>Catálogo</th>
                                <th>Presupuesto</th>
                                <th>Tipo de Presupuesto</th>
                                <th>Estado</th>
                                <th>Reporte</th>
                                <th>Edición</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($balanceBudgets as $balanceBudget)
	                            <tr>
	                                <td class="text-center balanceBudget_amount" data-token="{{$balanceBudget->token}}">{{$balanceBudget->amount}}</td>
	                                <td class="text-center balanceBudget_policies">{{mb_convert_case($balanceBudget->policies, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center balanceBudget_strategic">{{mb_convert_case($balanceBudget->strategic, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center balanceBudget_operational">{{mb_convert_case($balanceBudget->operational, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center balanceBudget_goals">{{mb_convert_case($balanceBudget->goals, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center balanceBudget_catalog">Catalogo</td>
	                                <td class="text-center balanceBudget_budget">{{mb_convert_case($balanceBudget->budgets->name, MB_CASE_TITLE, 'utf-8')}}</td>
	                                <td class="text-center balanceBudget_typeBudget">Tipo de Presupuesto</td>
	                                <td class="text-center">
	                                	@if($balanceBudget->deleted_at)
											<span>Inactivo</span>
	                                	@else
											<span>Activo</span>
	                                	@endif
	                                </td>
									<td class="text-center edit-row">
										<a href="{{route('reporte-saldo-de-presupuestos', $balanceBudget->token)}}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
										<a href="{{route('reporte-saldo-de-presupuestos-excel', $balanceBudget->token)}}" target="_blank"><i class="fa fa-file-excel-o"></i></a>
	                                </td>
	                                <td class="text-center edit-row">
                                		@if($balanceBudget->deleted_at)
                                			<a id="activeBalanceBudget" data-url="saldo-de-presupuestos" href="#">
                                				<i class="fa fa-check-square-o"></i>
                            				</a>
                                		@else
                                			<a id="deleteBalanceBudget" data-url="saldo-de-presupuestos" href="#">
												<i class="fa fa-trash-o"></i>
											</a>
                                		@endif
										<a href="{{route('edit-saldo-de-presupuesto', $balanceBudget->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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