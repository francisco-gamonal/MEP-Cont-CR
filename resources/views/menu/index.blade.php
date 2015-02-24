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
	                                <th class="text-center">Código</th>
	                                <th>Nombre</th>
	                                <th>Dirección</th>
	                                <th>Teléfono</th>
	                                <th class="text-center">Estado</th>
	                                <th class="text-center">Editar</th>
	                                <th class="text-center">Desactivar</th>
	                                <th class="text-center">Activar</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                            <tr>
	                                <td class="text-center iglesia_number">1</td>
	                                <td class="iglesia_name">Iglesia Quepos</td>
	                                <td class="iglesia_address"></td>
	                                <td class="text-center iglesia_phone">2777-4435</td>
	                                <td class="text-center iglesia_state">Activo</td>
	                                <td class="text-center">
	                                    <a class="btn btn-info" href="#" id="editIglesia"><span class="glyphicon glyphicon-pencil"></span></a>
	                                </td>
	                                <td class="text-center">
	                                	<a id="btnDisabledIglesia" class="btn btn-danger" href="#" data-resource="iglesias"><span class="glyphicon glyphicon-trash"></span></a>
	                                </td>
	                                <td class="text-center">
	                                	-
	                                </td>
	                            </tr>
	                            <tr>
	                                <td class="text-center iglesia_number">2</td>
	                                <td class="iglesia_name">Iglesia El Santísimo</td>
	                                <td class="iglesia_address">Piura</td>
	                                <td class="text-center iglesia_phone">073551234</td>
	                                <td class="text-center iglesia_state">Inactivo</td>
	                                <td class="text-center">
	                                    <a class="btn btn-info" href="#" id="editIglesia"><span class="glyphicon glyphicon-pencil"></span></a>
	                                </td>
	                                <td class="text-center">
	                                    -
	                                </td>
	                                <td class="text-center">
	                                    <a id="btnEnabledIglesia" class="btn btn-success" href="#" data-resource="iglesias"><span class="glyphicon glyphicon-ok"></span></a>
	                                </td>
	                            </tr>
	                        </tbody>
	                    </table>
					</div>
				</div>
			</div>
		</section>
	</div>
@stop