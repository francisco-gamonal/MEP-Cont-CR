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
		<h2>Menú</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li class="active-page"><a>Menú</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<h5><strong>Lista de Menú</strong></h5>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_id" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Código</th>
	                                <th>Nombre</th>
	                                <th>Url</th>
	                                @foreach($tasks as $task)
										<th>{{$task->name}}</th>
	                                @endforeach
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($menus as $menu)
		                            <tr>
		                                <td class="text-center iglesia_number">{{$menu->id}}</td>
		                                <td class="iglesia_name">{{$menu->name}}</td>
		                                <td class="iglesia_url">{{$menu->url}}</td>
			                            @foreach($menu->Tasks as $taskMenu)
		                                	@if($taskMenu->pivot->status == 0)
		                                		<td class="text-center">-</td>
		                                	@else
		                                		<td class="text-center"><span class="glyphicon glyphicon-ok"></span></td>
		                                	@endif
		                                @endforeach
		                                <td class="text-center">
		                                	@if($menu->deleted_at)
												Inactivo
		                                	@else
												Activo
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
		                                	<a href="#"><i class="fa fa-trash-o"></i></a>
											<a href="{{route('editar-menu', $menu->id)}}"><i class="fa fa-pencil-square-o"></i></a>
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