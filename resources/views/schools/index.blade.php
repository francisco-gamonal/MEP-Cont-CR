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
		<h2>Institución</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Institución</a></li>
				<li class="active-page"><a>Ver Institución</a></li>
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
							<h5><strong>Lista de Instituciones</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('registrar-institucion')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_school" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Id</th>
	                                <th>Nombre</th>
	                                <th>Cédula</th>
	                                <th>Circuito</th>
	                                <th>Código</th>
	                                <th>Presidente</th>
	                                <th>Secretaria</th>
	                                <th>Cuenta</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($schools as $school)
		                            <tr>
		                            	<td class="text-center school_number">{{$school->id}}</td>
		                                <td class="text-center school_name">{{mb_convert_case($school->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center school_charter">{{mb_convert_case($school->charter, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center school_circuit">{{mb_convert_case($school->circuit, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center school_code">{{$school->code}}</td>
		                                <td class="text-center school_president">{{mb_convert_case($school->president, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center school_secretary">{{mb_convert_case($school->secretary, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center school_account">{{$school->account}}</td>
		                                <td class="text-center">
		                                	@if($school->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($school->deleted_at)
	                                			<a id="activeSchool" data-url="institucion" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteSchool" data-url="institucion" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('edit-school', $school->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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