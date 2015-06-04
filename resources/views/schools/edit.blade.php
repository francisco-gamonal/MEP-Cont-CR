@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Institución</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Institución</a></li>
				<li class="active-page"><a>Editar Institución</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="idSchool">Id de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa fa-key"></i></span>
				      	<input id="idSchool" class="form-control" type="text" value="{{$school->id}}" disabled>
					</div>
				</div>
			</div>
			<div>
				<div class="form-mep">
					<label for="nameSchool">Nombre de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-university"></i></span>
				      	<input id="nameSchool" class="form-control" type="text" value="{{mb_convert_case($school->name, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="charterSchool">Cédula de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input id="charterSchool" class="form-control" type="text" value="{{mb_convert_case($school->charter, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="circuitSchool">Circuito de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-map-marker"></i></span>
				      	<input id="circuitSchool" class="form-control" type="text" value="{{mb_convert_case($school->circuit, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="codeSchool">Código de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-lock"></i></span>
				      	<input id="codeSchool" class="form-control" type="number" value="{{$school->code}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="ffinancingSchool">Financiamiento de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input id="ffinancingSchool" class="form-control" type="text" value="{{mb_convert_case($school->ffinancing, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="presidentSchool">Presidente de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="presidentSchool" class="form-control" type="text" value="{{mb_convert_case($school->president, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="directorSchool">Director de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="directorSchool" class="form-control" type="text" value="{{mb_convert_case($school->director, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="counterSchool">Contador de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input id="counterSchool" class="form-control" type="text" value="{{mb_convert_case($school->counter, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="secretarySchool">Secretaria de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-female"></i></span>
				      	<input id="secretarySchool" class="form-control" type="text" value="{{mb_convert_case($school->secretary, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="titleOneSchool">Título Uno de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-inbox"></i></span>
				      	<input id="titleOneSchool" class="form-control" type="text" value="{{mb_convert_case($school->title_1, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="titleTwoSchool">Título Dos de la Institución</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-inbox"></i></span>
				      	<input id="titleTwoSchool" class="form-control" type="text" value="{{mb_convert_case($school->title_2, MB_CASE_TITLE, 'utf-8')}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="statusSchool">Estado de la Institución</label>
					<div class="row">
						@if($school->deleted_at)
				      		<input id="statusSchool" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado">
				      	@else
							<input id="statusSchool" type="checkbox" name="status-checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="Estado" checked>
				      	@endif
			      	</div>
				</div>
			</div>
		</section>
		<div class="row text-center">
			<a href="{{route('ver-institucion')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
			<a href="#" id="updateSchool" data-url="institucion" class="btn btn-success">Actualizar Institución</a>
		</div>
	</div>
@stop