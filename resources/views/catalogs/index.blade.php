@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Catálogos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Catálogos</a></li>
				<li class="active-page"><a>Ver Catálogos</a></li>
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
							<h5><strong>Lista de Catálogos</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-catalogos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_catalogs" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Número</th>
	                                <th>Nombre</th>
	                                <th>Tipo</th>
	                                <th>Grupo</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($catalogs as $key => $catalog)
		                            <tr>
		                            	<td class="text-center">{{$key + 1}}</td>
		                                <td class="text-center catalog_name" data-token="{{$catalog->token}}">{{mb_convert_case($catalog->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center catalog_type">{{mb_convert_case($catalog->type, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center catalog_group">{{mb_convert_case($catalog->groups->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">
		                                	@if($catalog->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($catalog->deleted_at)
	                                			<a id="activeCatalog" data-url="catalogo" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteCatalog" data-url="catalogo" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('editar-catalogos', $catalog->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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