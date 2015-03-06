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
		<h2>Tipos de Usuarios</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tipos de Usuarios</a></li>
				<li class="active-page"><a>Ver Tipos de Usuarios</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<h5><strong>Lista de Tipos de Usuarios</strong></h5>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_type_user" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Código</th>
	                                <th>Nombre</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($typeUsers as $typeUser)
		                            <tr>
		                                <td class="text-center type_user_number">{{$typeUser->id}}</td>
		                                <td class="text-center type_user_name">{{mb_convert_case($typeUser->name,MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">
		                                	@if($typeUser->deleted_at)
												Inactivo
		                                	@else
												Activo
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($typeUser->deleted_at)
	                                			<a id="activeTypeUser" data-url="tipos-de-usuarios" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteTypeUser" data-url="tipos-de-usuarios" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('edit-tipo-de-usuario', $typeUser->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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