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
		<h2>Institución</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Institución</a></li>
				<li class="active-page"><a>Ver Institución</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<h5><strong>Lista de Instituciones</strong></h5>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_school" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>Id</th>
	                                <th>Nombre</th>
	                                <th>Cédula</th>
	                                <th>Circuito</th>
	                                <th>Código</th>
	                                <th>Financiamiento</th>
	                                <th>Presidente</th>
	                                <th>Secretaria</th>
	                                <th>Cuenta</th>
	                                <th>Título 1</th>
	                                <th>Título 2</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	
	                        </tbody>
	                    </table>
					</div>
				</div>
			</div>
		</section>
	</div>
@stop