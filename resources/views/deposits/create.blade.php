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
				<li class="active-page"><a>Registrar Depósito</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
	<div class="paddingWrapper">
		<section class="row">
			<form id="formDeposit">
				<div class="col-sm-6 col-md-6">
		            <div class="form-mep">
		                <label for="bankAccountDeposit">Cuenta Bancaria</label>
		                <select name="bankAccountDeposit" id="bankAccountDeposit" class="form-control">
		                    @foreach($bankAccounts as $bankAccount)
		                        <option value="{{$bankAccount->token}}">{{$bankAccount->number}} - {{$bankAccount->name}}</option>
		                    @endforeach
		                </select>
		            </div>
		        </div>
				<div class="col-sm-6 col-md-6">
					<div class="form-mep">
						<label for="numberDeposit">Número de Depósito</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
					      	<input name="numberDeposit" id="numberDeposit" class="form-control" type="number">
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="form-mep">
						<label for="dateDeposit">Fecha</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
							<input name="dateDeposit" id="dateDeposit" class="form-control datepicker" type="text" value="{{\Carbon\Carbon::now()->format('Y/m/d')}}">
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="form-mep">
						<label for="amountDeposit">Monto</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-usd"></i></span>
					      	<input name="amountDeposit" id="amountDeposit" class="form-control" type="number" min="1" step="0.01">
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div class="form-mep">
						<label for="depositorDeposit">Depositante</label>
						<div class="input-group">
							<span class="input-group-addon"><i class="fa fa-user"></i></span>
					      	<input name="depositorDeposit" id="depositorDeposit" class="form-control" type="text">
						</div>
					</div>
				</div>
				<div class="col-sm-6 col-md-6">
					<div id="file-state" class="form-mep">
	                    <label>Imagen del depósito</label>
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
			<a href="#" id="saveDeposit" data-url="depositos" class="btn btn-success">Grabar Depósito</a>
		</div>
	</div>
@stop

@section('scripts')
	<script src="{{ asset('bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<script src="{{ asset('bootstrap-datepicker/dist/locales/bootstrap-datepicker.es.min.js') }}"></script>
@stop