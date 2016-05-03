@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Cuentas Bancarias</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Cuentas Bancarias</a></li>
				<li class="active-page"><a>Ver Cuentas Bancarias</a></li>
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
							<h5><strong>Lista de Cuentas Bancarias</strong></h5>
						</div>
						<div class="col-sm-6">
							<a href="{{route('crear-cuentas-bancarias')}}" class="btn btn-info pull-right">
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
	                            	<th>Número</th>
	                            	<th>Cuenta</th>
	                                <th>Nombre</th>
	                                <th>Balance</th>
	                                <th>Edición</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	@foreach($bankAccounts as $key => $bankAccount)
		                            <tr>
		                            	<td class="text-center">{{$key + 1}}</td>
		                                <td class="text-center numberBankAccount" data-token="{{$bankAccount->token}}">{{$bankAccount->number}}</td>
		                                <td class="text-center">{{mb_convert_case($bankAccount->name, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center">{{mb_convert_case($bankAccount->balance, MB_CASE_TITLE, 'utf-8')}}</td>
		                                <td class="text-center edit-row">
                                			<a id="deleteBankAccount" data-url="cuentas-bancarias" href="#">
												<i class="fa fa-trash-o"></i>
											</a>
											<a href="{{route('editar-cuentas-bancarias', $bankAccount->token)}}"><i class="fa fa-pencil-square-o"></i></a>
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