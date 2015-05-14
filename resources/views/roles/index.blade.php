@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Roles</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Roles</a></li>
				<li class="active-page"><a>Ver Roles</a></li>
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
							<h5><strong>Lista de Roles de Usuarios</strong></h5>		
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_role" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Código</th>
	                                <th>Nombre</th>
	                                <th>Apellido</th>
	                                <th>Email</th>
	                                <th>Tipo de Usuario</th>
	                                <th>Proveedor</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($users as $user)
		                            <tr>
		                            	<td class="text-center user_number">{{$user->id}}</td>
		                                <td class="text-center user_name">{{mb_convert_case($user->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center user_last">{{mb_convert_case($user->last, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center user_email">{{strtolower($user->email)}}</td>
		                                <td class="text-center user_type_user">
		                                	<span>{{mb_convert_case($user->typeUsers->name, MB_CASE_TITLE, 'utf-8')}}</span>
	                                	</td>
		                                <td class="text-center user_supplier">
		                                	@if(isset($user->suppliers->name))
		                                		<span>{{mb_convert_case($user->suppliers->name, MB_CASE_TITLE, 'utf-8')}}</span>
		                                	@else
												<span>-</span>
		                                	@endif
	                                	</td>
		                                <td class="text-center edit-row">
											<a href="{{route('edit-role', $user->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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