@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Depósitos</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Depósitos</a></li>
				<li class="active-page"><a>Ver Depósitos</a></li>
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
							<h5><strong>Lista de Depósitos</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-depositos')}}" class="btn btn-info pull-right">
								<span class="glyphicon glyphicon-plus"></span>
								<span>Nuevo</span>
							</a>
						</div>
					</div>
				</div>
				<div class="table-content">
					<div class="table-responsive">
						<table id="table_bankAccounts" class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
	                        <thead>
	                            <tr>
	                            	<th>#</th>
	                                <th>Cuenta Bancaria</th>
	                            	<th>Número de Depósito</th>
	                                <th>Fecha</th>
	                                <th>Monto</th>
	                                <th>Depositante</th>
	                                <th>Imagen</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($deposits as $key => $deposit)
		                            <tr>
		                            	<td class="text-center">{{$key + 1}}</td>
		                                <td class="text-center">{{$deposit->bankAccount->number}}</td>
		                                <td class="text-center numberDeposit" data-token="{{$deposit->token}}">{{$deposit->number}}</td>
		                                <td class="text-center">{{\Carbon\Carbon::parse($deposit->date)->format('d-m-Y')}}</td>
		                                <td class="text-center">{{$deposit->amount}}</td>
		                                <td class="text-center">{{$deposit->depositor}}</td>
		                                <td class="text-center">
		                                	@if(strlen($deposit->img_url) > 0)
												<a href="{{asset($deposit->img_url)}}" target="_blank"><span class="fa fa-eye"></span></a>
		                                	@else
												<span>-</span>
		                                	@endif
		                                </td>
		                                <td class="text-center edit-row">
                                			<a id="deleteDeposit" data-url="depositos" href="#">
												<i class="fa fa-trash-o"></i>
											</a>
											<a href="{{route('editar-depositos', $deposit->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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