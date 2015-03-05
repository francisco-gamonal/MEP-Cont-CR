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
		<h2>Tipo de Usuario</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Tipo de Usuario</a></li>
				<li class="active-page"><a>Editar Tipo de Usuario</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="id_type_user">Código del Tipo de Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
				      	<input id="id_type_user" class="form-control" type="text" value="{{$type_user->id}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="name_type_user">Nombre del Tipo de Usuario</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="name_type_user" class="form-control" type="text" value="{{$type_user->name}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusMenu">Estado del Menú</label>
					<div class="row">
						@if($type_user->deleted_at)
				      		<input id="status_type_user" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="status_type_user" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
			<div class="row text-center">
				<a href="{{route('ver-menu')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
				<a href="#" id="update" data-url="menu" class="btn btn-success">Actualizar Menú</a>
			</div>
		</section>
	</div>
@stop