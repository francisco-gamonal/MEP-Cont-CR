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
				<h5><strong>Lista de Cheques</strong></h5>
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
	                                <td class="text-center balanceBudgetCheck" data-token="{{$check->token}}">{{$check->codeCuentaCatalog()}}</td>
	                                <td class="text-center">{{$check->amount}}</td>
	                                <td class="text-center">{{$check->date}}</td>
	                                <td class="text-center">{{$check->supplier->name}}</td>
	                                <td class="text-center">{{$check->bill}}</td>
	                                <td class="text-center">{{$check->numberSpreadsheet()}}</td>
	                                <td class="text-center">{{$check->spreadsheets->budgets->name}}</td>
	                                <td class="text-center">
	                                	@if($check->deleted_at)
											<span>Inactivo</span>
	                                	@else
											<span>Activo</span>
	                                	@endif
	                                </td>
	                                <td class="text-center edit-row">
                                		@if($check->deleted_at)
                                			<a id="activeCheck" data-url="presupuestos" href="#">
                                				<i class="fa fa-check-square-o"></i>
                            				</a>
                                		@else
                                			<a id="deleteCheck" data-url="presupuestos" href="#">
												<i class="fa fa-trash-o"></i>
											</a>
                                		@endif
										<a href="{{route('edit-cheque', $check->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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