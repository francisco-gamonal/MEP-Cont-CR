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
		<h2>Catálogos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Catálogos</a></li>
				<li class="active-page"><a>Registrar Catálogo</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="cCatalog">C Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="cCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="scCatalog">SC Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="scCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="gCatalog">G Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="gCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="sgCatalog">SG Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="sgCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="pCatalog">P Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="pCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="spCatalog">SP Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="spCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="rCatalog">R Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="rCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="srCatalog">SR Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="srCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="fCatalog">F Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="fCatalog" class="form-control" type="number">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameCatalog">Nombre del Catálogo</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-tag"></i></span>
				      	<input id="nameCatalog" class="form-control" type="text">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="typeCatalog">Tipo de Catálogo</label>
					<select id="typeCatalog" class="form-control">
						<option value="ingresos">Ingresos</option>
						<option value="egresos">Egresos</option>
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="groupCatalog">Grupo del Catálogo</label>
					<select id="groupCatalog" class="form-control">
						@foreach($groups as $group)
							<option value="{{$group->token}}">{{mb_convert_case($group->name, MB_CASE_TITLE, 'utf-8')}}</option>
						@endforeach
					</select>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusCatalog">Estado del Catálogo</label>
					<div class="row">
			      		<input id="statusCatalog" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-catalogos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="saveCatalog" data-url="catalogos" class="btn btn-success">Grabar Catálogo</a>
		</div>
	</div>
@stop