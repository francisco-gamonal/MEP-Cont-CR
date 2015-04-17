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
			<li class="active-page"><a>Ver Transferencia</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="codeTransfer">Número de Transferencia</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="codeTransfer" class="form-control" type="text" value="{{$transfers[0]->code}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateTransfer">Fecha de Transferencia</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="dateTransfer" class="form-control" type="date" value="{{$transfers[0]->date}}" disabled>
				</div>
			</div>
		</div>
		@if($transfers[0]->simulation != "false")
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="simulationTransfer">Simulación de Transferencia</label>
				<select id="simulationTransfer" class="form-control">
					<option value="f">No</option>
					<option value="v">Si</option>
				</select>
			</div>
		</div>
		@endif
	</section>
	<section class="row">
		<div class="table-content">
			<div class="table-responsive">
				<table class="table table-bordered table-hover" cellpadding="0" cellspacing="0" border="0" width="100%">
                    <thead>
                        <tr>
                            <th>Código de la Cuenta</th>
                            <th>Nombre de la Cuenta</th>
                            <th>Saldo Presupuesto Disponible</th>
                            <th>Disminución</th>
                            <th>Aumento</th>
                            <th>Nuevo Saldo Disponible</th>
                        </tr>
                    </thead>
                    <tbody>
                    	@foreach($transfers as $transfer)
							<tr>
								@foreach($balanceBudgets as $balanceBudget)
									@if($balanceBudget[0]['id'] == $transfer->balance_budgets_id)
										<th class="text-center">{{$balanceBudget[0]['code']}}</th>
										<th class="text-center">{{$balanceBudget[0]['name']}}</th>
									@endif
								@endforeach
								<th class="text-center">s</th>
								@if($transfer->type == 'entrada')
									<th class="text-center">{{$transfer->amount}}</th>
								@else
									<th class="text-center">-</th>
								@endif
								@if($transfer->type == 'salida')
									<th class="text-center">{{$transfer->amount}}</th>
								@else
									<th class="text-center">-</th>
								@endif
								<th class="text-center">s</th>
							</tr>
                    	@endforeach
                    </tbody>
                </table>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-transferencias')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a class="btn btn-success" href="{{route('edit-transferencia', $transfers[0]->token)}}">Editar Transferencia</a>
	</div>
</div>
@stop