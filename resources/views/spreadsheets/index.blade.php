@extends('layouts.mep')

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
					<div class="row">
						<div class="col-sm-6">
							<h5><strong>Lista de Planillas</strong></h5>		
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-planillas')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
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
	                                <th>Reporte</th>
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
		                                <td class="text-center">{{$spreadsheet->budgets->name}} - {{$spreadsheet->budgets->schoolBudget($spreadsheet->budgets->id)->name}}</td>
		                                <td class="text-center">
		                                	@if($spreadsheet->deleted_at)
												<span>Inactivo</span>
		                                	@else
												<span>Activo</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
											<a href="{{route('report-planilla', $spreadsheet->token)}}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
											<a href="{{route('reporte-planilla-excel', $spreadsheet->token)}}" target="_blank"><i class="fa fa-file-excel-o"></i></a>
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
											<a href="{{route('editar-planillas', $spreadsheet->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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