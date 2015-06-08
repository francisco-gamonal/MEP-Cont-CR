@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Grupos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Grupos</a></li>
				<li class="active-page"><a>Ver Grupos</a></li>
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
							<h5><strong>Lista de Grupos</strong></h5>		
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-grupos-de-cuentas')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_groups" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Código</th>
	                                <th>Nombre</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($groups as $group)
		                            <tr>
		                                <td class="text-center group_code" data-token="{{$group->token}}">{{$group->code}}</td>
		                                <td class="text-center group_name">{{mb_convert_case($group->name,MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">
		                                	@if($group->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($group->deleted_at)
	                                			<a id="activeGroup" data-url="grupos-de-cuentas" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteGroup" data-url="grupos-de-cuentas" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('editar-grupos-de-cuentas', $group->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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