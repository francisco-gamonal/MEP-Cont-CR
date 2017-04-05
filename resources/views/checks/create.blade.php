@extends('layouts.mep')

@section('page')
	<aside class="page"> 
		<h2>Cheques</h2>
		<div class="list-inline-block">
			<ul>
				<li><a href="{{url('/')}}">Home</a></li>
				<li><a>Cheques</a></li>
				<li class="active-page"><a>Registrar Cheque</a></li>
			</ul>
		</div>
	</aside>
@endsection

@section('content')
<div class="paddingWrapper">
	<section class="row">
		<div class="col-sm-8 col-md-8">
			<div class="form-mep">
				<label for="spreadsheetCheck">Planilla</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-cube"></i></span>
					<input type="text" readonly class="form-control" value="{{$spreadsheet->number.'-'.$spreadsheet->year.' '.$spreadsheet->budgets->name}} - {{$spreadsheet->budgets->schoolBudget($spreadsheet->budget_id)->name}} - {{mb_convert_case($spreadsheet->typebudgets->name, MB_CASE_TITLE, 'utf-8')}}">
					<input id="spreadsheetCheck" type="hidden" value="{{$spreadsheet->token}}">
				</div>
			</div>
		</div>

		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="dateCheck">Fecha</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-file-text-o"></i></span>
					<input id="dateCheck" class="form-control" type="date">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="numberCheck">N° de Cheque</label>
				<div class="input-group">
					<span class="input-group-addon">#</span>
			      	<input id="ckbillCheck" class="form-control" type="text">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="ckretentionCheck">Número de Cheque de Retención</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-barcode"></i></span>
			      	<input id="ckretentionCheck" class="form-control" type="text">
				</div>
			</div>
		</div>
		<div class="col-sm-6 col-md-6">
			<div class="form-mep">
				<label for="recordCheck">Número de Acta</label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-sort-numeric-asc"></i></span>
			      	<input id="recordCheck" class="form-control" type="text">
				</div>
			</div>
		</div>


	</section>
	<div class="row text-center">
		<a href="{{route('ver-cheques')}}" class="btn btn-default"><span class="glyphicon glyphicon-circle-arrow-left"></span>Regresar</a>
		<a href="#" id="saveCheck" data-url="cheques" class="btn btn-success">Grabar Cheque</a>
	</div>
</div>
@stop