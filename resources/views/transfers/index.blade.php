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
				<h5><strong>Lista de Transferencias</strong></h5>
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
                                <th>Estado</th>
                                <th>Edición</th>
                            </tr>
                        </thead>
                        <tbody>
                        	@foreach($transfers as $transfer)
	                            <tr>
	                                <td class="text-center codeTransfer" data-token="{{$transfer->token}}">{{$transfer->code}}</td>
                                    @foreach($balanceBudgets as $balanceBudget) 
										@if($balanceBudget[0]['idBalanceBudgets'] == $transfer->balance_budgets_id)
											<td class="text-center">{{$balanceBudget[0]['value']}}</td>
										@endif
	                                @endforeach
	                                <td class="text-center">{{$transfer->date}}</td>
	                                <td class="text-center">{{$transfer->amount}}</td>
	                                <td class="text-center">
	                                	@if($transfer->deleted_at)
											<span>Inactivo</span>
	                                	@else
											<span>Activo</span>
	                                	@endif
	                                </td>
	                                <td class="text-center edit-row">
	                                	<a href="{{route('view-transferencia', $transfer->token)}}"><i class="fa fa-eye"></i></a>
                                		@if($transfer->deleted_at)
                                			<a id="activeTransfer" data-url="cheques" href="#">
                                				<i class="fa fa-check-square-o"></i>
                            				</a>
                                		@else
                                			<a id="deleteTransfer" data-url="cheques" href="#">
												<i class="fa fa-trash-o"></i>
											</a>
                                		@endif
										<a href="{{route('edit-transferencia', $transfer->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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