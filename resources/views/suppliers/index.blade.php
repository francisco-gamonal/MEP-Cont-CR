@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Proveedores</h2>
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
					<div class="row">
						<div class="col-sm-6">
							<h5><strong>Lista de Proveedores</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-proveedores')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_supplier" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
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
		                            	<input id="tokenSupplier" type="hidden" value="{{$supplier->token}}">
		                                <td class="text-center">{{mb_convert_case($supplier->charter, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">{{mb_convert_case($supplier->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">{{$supplier->phone}}</td>
		                                <td class="text-center">{{strtolower($supplier->email)}}</td>
		                                <td class="text-center">
		                                	@if($supplier->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($supplier->deleted_at)
	                                			<a id="activeSupplier" data-url="institucion/inst/proveedores" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteSupplier" data-url="institucion/inst/proveedores" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('editar-proveedores', $supplier->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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