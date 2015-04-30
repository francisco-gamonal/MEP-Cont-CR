@extends('layouts.mep')

@section('content')
	
	@include('reports.partials.circuit')
	@include('reports.budget.title')
	@include('reports.budget.in')
	@include('reports.budget.out')

@endsection