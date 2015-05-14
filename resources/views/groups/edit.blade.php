@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Grupos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Grupos</a></li>
				<li class="active-page"><a>Editar Grupo</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			@foreach($group as $group)
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="codeGroup">Código del Grupo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="codeGroup" class="form-control" type="text" value="{{$group->code}}" data-token="{{$group->token}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameGroup">Nombre del Grupo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-th-list"></i></span>
				      	<input id="nameGroup" class="form-control" type="text" value="{{mb_convert_case($group->name, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusGroup">Estado del Grupo</label>
					<div class="row">
						@if($group->deleted_at)
				      		<input id="statusGroup" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusGroup" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
			@endforeach
		</section>
		<div class="row text-center">
			<a href="{{route('ver-grupos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateGroups" data-url="grupos" class="btn btn-success">Actualizar Grupo</a>
		</div>
	</div>
@stop