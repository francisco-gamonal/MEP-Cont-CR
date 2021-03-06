@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Menú</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Menú</a></li>
				<li class="active-page"><a>Editar Menú</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="idMenu">Código del Menú</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-key"></i></span>
				      	<input id="idMenu" class="form-control" type="text" value="{{$menu->id}}" disabled>
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameMenu">Nombre del Menú</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameMenu" class="form-control" type="text" value="{{strtolower($menu->name)}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="urlMenu">Url del Menú</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-bars"></i></span>
				      	<input id="urlMenu" class="form-control" type="text" value="{{strtolower($menu->url)}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusMenu">Estado del Menú</label>
					<div class="row">
						@if($menu->deleted_at)
				      		<input id="statusMenu" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusMenu" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
			<div class="col-sm-12 col-md-12 text-center">
				<div class="form-mep">
					<label>Escoger las opciones del Menú</label>
					@foreach($menu->Tasks as $taskMenu)
						@if($taskMenu->pivot->status == 0)
							<div class="row">
								<input class="task_menu" type="checkbox" name="task-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}">
							</div>
						@else
							<div class="row">
								<input class="task_menu" type="checkbox" name="task-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}" checked>
							</div>
						@endif
					@endforeach
				</div>
			</div>
			<div class="row text-center">
				<a href="{{route('ver-menu')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
				<a href="#" id="updateMenu" data-url="menu" class="btn btn-success">Actualizar Menú</a>
			</div>
		</section>
	</div>
@stop