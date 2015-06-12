@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Proveedores</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Proveedores</a></li>
				<li class="active-page"><a>Editar Proveedores</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		@foreach($suppliers as $supplier)
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="charterSupplier">Cédula del Proveedor</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="charterSupplier" class="form-control" type="number" value="{{$supplier->charter}}">
				      	<input id="tokenSupplier" type="hidden" value="{{$supplier->token}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="nameSupplier">Nombre del Proveedor</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="nameSupplier" class="form-control" type="text" value="{{mb_convert_case($supplier->name, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="phoneSupplier">Teléfono del Proveedor</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-phone"></i></span>
				      	<input id="phoneSupplier" class="form-control" type="phone" value="{{$supplier->phone}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="emailSupplier">Email del Proveedor</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-envelope-o"></i></span>
				      	<input id="emailSupplier" class="form-control" type="email" value="{{strtolower($supplier->email)}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusSupplier">Estado del Proveedor</label>
					<div class="row">
						@if($supplier->deleted_at)
				      		<input id="statusSupplier" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusSupplier" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-proveedores')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateSupplier" data-url="proveedores" class="btn btn-success">Actualizar Proveedor</a>
		</div>
		@endforeach
	</div>
@stop