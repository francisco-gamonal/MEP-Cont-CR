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
		<h2>Proveedores/h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Proveedores</a></li>
				<li class="active-page"><a>Ver Proveedores</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<h5><strong>Lista de Proveedores</strong></h5>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_type_user" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Cédula</th>
	                                <th>Nombre</th>
	                                <th>Teléfono</th>
	                                <th>Email</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($suppliers as $supplier)
		                            <tr>
		                            	<input id="tokenSupplier" type="hidden" data-token="{{$supplier->token}}">
		                                <td class="text-center">{{mb_convert_case($supplier->charter, MB_CASE_TITLE, 'utf-8'}}</td>
		                                <td class="text-center">{{mb_convert_case($supplier->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">{{$supplier->phone}}</td>
		                                <td class="text-center">{{strtolower($supplier->email)}}</td>
		                                <td class="text-center">
		                                	@if($supplier->deleted_at)
												Inactivo
		                                	@else
												Activo
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($supplier->deleted_at)
	                                			<a id="activeSupplier" data-url="proveedores" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteSupplier" data-url="proveedores" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('edit-proveedor', $typeUser->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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