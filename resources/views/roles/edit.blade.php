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
	<h2>Roles</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Roles</a></li>
			<li class="active-page"><a>Editar Rol</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row form-role">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="nameUser">Código del Usuario</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-key"></i></span>
			      	<input id="idUser" class="form-control" type="text" value="{{$user->id}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="nameUser">Nombres del Usuario</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
			      	<input id="nameUser" class="form-control" type="text" value="{{mb_convert_case($user->name, MB_CASE_TITLE, 'utf-8')}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="lastNameUser">Apellidos del Usuario</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-user"></i></span>
			      	<input id="lastNameUser" class="form-control" type="text" value="{{mb_convert_case($user->last, MB_CASE_TITLE, 'utf-8')}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="emailUser">Email del Usuario</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
			      	<input id="emailUser" class="form-control" type="email" value="{{strtolower($user->email)}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-12">
			<div class="form-mep">
				<label class="text-left">Seleccionar Menú</label>
			</div>
		</div>
		@foreach($menus as $menu)
			<div class="col-sm-6 col-md-4 menu-role" data-menu="{{$menu->id}}">
				<div class="form-mep">
					<fieldset>
						<legend>{{mb_convert_case($menu->name, MB_CASE_TITLE, 'utf-8')}}</legend>
						<div class="text-center target_all">
							<span>Marcar todos </span><input class="active" type="checkbox">
						</div>
						@foreach($menu->Tasks as $taskMenu)
							@if($taskMenu->pivot->status == 1)
								@foreach($user->Tasks as $taskUser)
									@if($menu->id == $taskUser->pivot->menu_id && $taskMenu->id == $taskUser->pivot->task_id && $taskUser->pivot->status == 1)	
		                                <div class="row text-center">
											<input class="role-checkbox" type="checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}" checked>
										</div>
									@elseif($menu->id == $taskUser->pivot->menu_id && $taskMenu->id == $taskUser->pivot->task_id && $taskUser->pivot->status == 0)
										<div class="row text-center">
											<input class="role-checkbox" type="checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}">
										</div>
									@endif
								@endforeach
							@endif
						@endforeach
					</fieldset>
				</div>
			</div>
		@endforeach
	</section>
	<div class="row text-center">
		<a href="{{route('ver-roles')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateRole" data-url="roles" class="btn btn-success">Actualizar Roles</a>
	</div>
</div>
@stop