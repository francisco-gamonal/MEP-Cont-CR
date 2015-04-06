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
	<h2>Presupuestos</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Presupuestos</a></li>
			<li class="active-page"><a>Editar Presupuesto</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row form-">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="cCatalog">C Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->c)
			      		<input id="cCatalog" class="form-control" type="number" value="{{$catalog->c}}">
			      	@else
			      		<input id="cCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="scCatalog">SC Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->sc)
			      		<input id="scCatalog" class="form-control" type="number" value="{{$catalog->sc}}">
			      	@else
			      		<input id="scCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="gCatalog">G Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->g)
			      		<input id="gCatalog" class="form-control" type="number" value="{{$catalog->g}}">
			      	@else
			      		<input id="gCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="sgCatalog">SG Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->sg)
			      		<input id="sgCatalog" class="form-control" type="number" value="{{$catalog->sg}}">
			      	@else
			      		<input id="sgCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="pCatalog">P Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->p)
				      	<input id="pCatalog" class="form-control" type="number" value="{{$catalog->p}}">
				    @else
				    	<input id="pCatalog" class="form-control" type="number">
				    @endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="spCatalog">SP Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->sp)
			      		<input id="spCatalog" class="form-control" type="number" value="{{$catalog->sp}}">
			      	@else
			      		<input id="spCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="rCatalog">R Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->r)
			      		<input id="rCatalog" class="form-control" type="number" value="{{$catalog->r}}">
			      	@else
			      		<input id="rCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="srCatalog">SR Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->sr)
			      		<input id="srCatalog" class="form-control" type="number" value="{{$catalog->sr}}">
			      	@else
			      		<input id="srCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="fCatalog">F Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					@if($catalog->f)
			      		<input id="fCatalog" class="form-control" type="number" value="{{$catalog->f}}">
			      	@else
						<input id="fCatalog" class="form-control" type="number">
			      	@endif
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="nameCatalog">Nombre del Catálogo</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="nameCatalog" class="form-control" type="text" value="{{$catalog->name}}" data-token="{{$catalog->token}}">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="typeCatalog">Tipo de Catálogo</label>
				<select id="typeCatalog" class="form-control">
					@if($catalog->type == 'ingresos')
						<option value="ingresos" selected>Ingresos</option>
						<option value="egresos">Egresos</option>
					@else
						<option value="ingresos">Ingresos</option>
						<option value="egresos" selected>Egresos</option>
					@endif
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="groupCatalog">Grupo del Catálogo</label>
				<select id="groupCatalog" class="form-control">
					@foreach($groups as $group)
						@if($group->id == $catalog->groups_id)
							<option value="{{$group->token}}" selected>{{mb_convert_case($group->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@else
							<option value="{{$group->token}}">{{mb_convert_case($group->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endif
					@endforeach
				</select>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="statusCatalog">Estado del Catálogo</label>
				<div class="row">
					@if($catalog->deleted_at)
		      			<input id="statusCatalog" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
		      		@else
						<input id="statusCatalog" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
		      		@endif
		      	</div>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-catalogos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateCatalog" data-url="catalogos" class="btn btn-success">Actualizar Catálogo</a>
	</div>
</div>
@stop