@extends('layouts.mep')

@section('page')
<aside class="page"> 
	<h2>Transferencias</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Transferencias</a></li>
			<li class="active-page"><a>Ver Transferencias</a></li>
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
						<h5><strong>Lista de Transferencias</strong></h5>
					</div>
					<div class="col-sm-6">
						<a href="{{route('registrar-transferencia')}}" class="btn btn-info pull-right">
							<span class="glyphicon glyphicon-plus"></span>
							<span>Nuevo</span>
						</a>
					</div>
				</div>
			</div>
			<div class="table-content">
				<div class="table-responsive">
					<table id="table_transfers" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
                        <thead>
                            <tr>
                                <th>Número de Transferencia</th>
                                <th>Cuenta</th>
                                <th>Fecha</th>
                                <th>Monto</th>
                                <th>Reporte</th>
                                <th>Edición</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($transfers as $transfer)
	                            <tr>
	                                <td class="text-center codeTransfer" data-token="{{$transfer['token']}}">{{$transfer['code']}}</td>
                                	<td class="text-center">{{$transfer['value']}}</td>
	                                <td class="text-center">{{$transfer['date']}}</td>
	                                <td class="text-center">{{$transfer['amount']}}</td>
	                                <td class="text-center edit-row">
	                                	<a href="{{route('reporte-transferencias', $transfer['token'])}}" target="_blank"><i class="fa fa-file-pdf-o"></i></a>
	                                	<a href="{{route('reporte-transfers-excel', $transfer['token'])}}" target="_blank"><i class="fa fa-file-excel-o"></i></a>
	                                </td>
	                                <td class="text-center edit-row">
	                                	<a href="{{route('view-transferencia', $transfer['token'])}}"><i class="fa fa-eye"></i></a>
										<a href="{{route('edit-transferencia', $transfer['token'])}}"><i class="fa fa-pencil-square-o" target="_blank"></i></a>
										<a id="deleteTransfer" data-url="transferencias" href="#">
											<i class="fa fa-trash-o"></i>
										</a>
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