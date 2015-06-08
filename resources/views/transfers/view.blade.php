@extends('layouts.mep')

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
					<span class="input-group-addon">#</span>
			      	<input id="codeTransfer" class="form-control" type="text" value="{{$transfers[0]['codeTransfer']}}" disabled>
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateTransfer">Fecha de Transferencia</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
			      	<input id="dateTransfer" class="form-control" type="text" value="{{$transfers[0]['date']}}" disabled>
				</div>
			</div>
		</div>
		@if($transfers[0]['simulation'] != "false")
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
								<th class="text-center">{{$transfer['code']}}</th>
								<th class="text-center">{{$transfer['name']}}</th>
								<th class="text-center">{{number_format($transfer['balanceLast'], 2)}}</th>
								@if($transfer['type'] == 'salida')
									<th class="text-center">{{number_format($transfer['amount'], 2)}}</th>
								@else
									<th class="text-center">-</th>
								@endif
								@if($transfer['type'] == 'entrada')
									<th class="text-center">{{number_format($transfer['amount'], 2)}}</th>
								@else
									<th class="text-center">-</th>
								@endif
								<th class="text-center">{{number_format($transfer['balanceNew'], 2)}}</th>
							</tr>
                    	@endforeach
                    </tbody>
                </table>
			</div>
		</div>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-transferencias')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a class="btn btn-success" href="{{route('editar-transferencias', $transfers[0]['tokenTransfer'])}}">Editar Transferencia</a>
	</div>
</div>
@stop