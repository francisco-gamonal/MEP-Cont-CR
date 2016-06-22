@extends('layouts.school')

@section('styles')
	<style>
		a:hover{
			text-decoration: none;
		}
	</style>
@endsection

@section('content')
	<div class="row paddingWrapper">
		@foreach($schools as $school)
	  	<div class="col-sm-6 col-md-4">
		    <div class="thumbnail paddingWrapper">
		    	<div class="text-center">
		      		<a class="routeSchool" href="#" data-token="{{$school->token}}" data-route="{{$school->route}}">
						@if($school->image)
		      			<img src="{{ asset('img/'.$school->image) }}" width="150">
						@else
		      			<img src="{{ asset('img/mep.jpg') }}" width="150">
							@endif
		      		</a>
		    	</div>
		      	<div class="caption text-center">
			        <a class="routeSchool" href="#" data-token="{{$school->token}}" data-route="{{$school->route}}">
			        	<h4>{{ convertTitle($school->name) }}</h4>
			        </a>
		      	</div>
		    </div>
		</div>
    	@endforeach
  	</div>

@endsection

@section('scripts')
	<script src="{{ asset('js/plugin/jquery.blockUI.min.js') }}"></script>
	<script src="{{ asset('js/plugin/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('js/plugin/jquery.matchHeight-min.js') }}"></script>
	<script src="{{ asset('js/plugin/bootbox.min.js') }}"></script>
	<script>
		$(".message .col-md-6:first").empty();
		$(".message .col-md-6:first").html('<a href="{{URL::to('/')}}"><img src="{{ asset('img/mep-logo.png') }}" height="60px"></img></a>');
		$(".message .col-md-6").css('line-height', '4em');
		$('.thumbnail').matchHeight();
	</script>
@endsection