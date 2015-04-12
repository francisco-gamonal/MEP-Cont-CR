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
		<h2>Planillas</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Planillas</a></li>
				<li class="active-page"><a>Ver Planilla</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<div class="table-data">
				<div class="table-header">
					<h5><strong>Lista de Planillas</strong></h5>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_spreadsheets" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                                <th>Número</th>
	                                <th>Año</th>
	                                <th>Fecha</th>
	                                <th>Presupuesto</th>
	                                <th>Estado</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($spreadsheets as $spreadsheet)
		                            <tr>
		                            	<input class="tokenSpreadsheet" type="hidden" value="{{$spreadsheet->token}}">
		                                <td class="text-center">{{$spreadsheet->number}}</td>
		                                <td class="text-center">{{$spreadsheet->year}}</td>
		                                <td class="text-center">{{$spreadsheet->date}}</td>
		                                <td class="text-center">{{$spreadsheet->budgets->name}}</td>
		                                <td class="text-center">
		                                	@if($spreadsheet->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
	                                		@if($spreadsheet->deleted_at)
	                                			<a id="activeSpreadsheet" data-url="planillas" href="#">
	                                				<i class="fa fa-check-square-o"></i>
                                				</a>
	                                		@else
	                                			<a id="deleteSpreadsheet" data-url="planillas" href="#">
													<i class="fa fa-trash-o"></i>
												</a>
	                                		@endif
											<a href="{{route('edit-planilla', $spreadsheet->token)}}"><i class="fa fa-pencil-square-o"></i></a>
		                                </td>
		                            </tr>
	                            @endforeach
	                        </tbody>
	                    </table>
					</div>
				</div>
			</div>
		</section>
	</div>
@stop