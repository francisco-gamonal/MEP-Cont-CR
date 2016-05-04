@extends('layouts.mep')

@section('styles')
	<link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker3.min.css') }}">
@stop

@section('page')
<aside class="page"> 
	<h2>Depósitos</h2>
	<div class="list-inline-block">
		<ul>
			<li><a href="{{url('/')}}">Home</a></li>
			<li><a>Depósitos</a></li>
			<li class="active-page"><a>Editar Depósito</a></li>
		</ul>
	</div>
</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<form id="formDepositEdit">
			<div class="col-sm-6 col-md-6">
	            <div class="form-mep">
	                <label for="bankAccountDeposit">Cuenta Bancaria</label>
	                <select name="bankAccountDeposit" id="bankAccountDeposit" class="form-control">
	                    @foreach($bankAccounts as $bankAccount)
	                    	@if($deposit->bankAccount->id == $bankAccount->id)
	                        	<option value="{{$bankAccount->token}}" selected>{{$bankAccount->number}} - {{$bankAccount->name}}</option>
	                        @else
								<option value="{{$bankAccount->token}}">{{$bankAccount->number}} - {{$bankAccount->name}}</option>
	                        @endif
	                    @endforeach
	                </select>
	            </div>
	        </div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="numberDeposit">Número de Depósito</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
				      	<input name="numberDeposit" id="numberDeposit" class="form-control" type="number" value="{{$deposit->number}}">
				      	<input type="hidden" name="token" value="{{$deposit->token}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="dateDeposit">Fecha</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
						<input name="dateDeposit" id="dateDeposit" class="form-control datepicker" type="text" value="{{$deposit->date}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="amountDeposit">Monto</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-usd"></i></span>
				      	<input name="amountDeposit" id="amountDeposit" class="form-control" type="number" min="1" step="0.01" value="{{$deposit->amount}}">
					</div>
				</div>
			</div>
			<div class="col-sm-6 col-md-6">
				<div class="form-mep">
					<label for="depositorDeposit">Depositante</label>
					<div class="input-group">
						<span class="input-group-addon"><i class="fa fa-user"></i></span>
				      	<input name="depositorDeposit" id="depositorDeposit" class="form-control" type="text" value="{{$deposit->depositor}}">
					</div>
				</div>
			</div>
			@if(strlen($deposit->img_url) > 0)
				<div class="col-sm-6 col-md-6">
					<div class="form-mep">
						<label>Imagen Almacenada</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-eye"></i></span>
							<input id="img_url" class="form-control" style="color:blue;" type="text" data-url="{{$deposit->img_url}}" value="Ver" readonly>	
						</div>
					</div>
				</div>
			@endif
			<div class="col-sm-6 col-md-6">
				<div id="file-state" class="form-mep">
                    <label>Actualizar Imagen del depósito</label>
                    <input name="file" style="position:fixed; margin-left: -9999px;" type="file">
                    <div class="input-group">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">
                                <span class="glyphicon glyphicon-folder-open"></span>
                            </button>
                        </span>
                        <input type="text" class="form-control" disabled="true">
                    </div>
				</div>
			</div>
		</form>
	</section>
	<div class="row text-center">
		<a href="{{route('ver-depositos')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="updateDeposit" data-url="depositos" class="btn btn-success">Actualizar Depósito</a>
	</div>
</div>
@stop

@section('scripts')
	<script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
	<script>
		$('#img_url').on("click",function(e){
			e.preventDefault();
			var url = $(this).data('url');
			window.open(url);
		});
	</script>
@stop