<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="shortcut icon" href="{{ asset('img/favicon.png') }}">
	<title>MEP</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{ asset('css/plugin/dataTables.bootstrap.css') }}">
	<link rel="stylesheet" href="{{ asset('css/plugin/bootstrap-switch.min.css') }}">
	<link rel="stylesheet" href="{{ asset('css/plugin/bootstrap-tagsinput.css') }}">
	<link rel="stylesheet" href="{{ asset('css/plugin/nprogress.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">
	@yield('styles')
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

</head>
<body>
	<div class="nav-wrapper">
		<div class="logo paddingWrapper">
			<figure><a href="{{ url('/institucion') }}"><img class="center-block" src="{{ asset('img/mep-logo.png') }}"></a></figure>
		</div>
		@include('layouts.menu')
	</div>
	<div class="content-wrapper">
		@include('layouts.message')
		@yield('page')
		@yield('content')
	</div>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('js/plugin/jquery.matchHeight-min.js') }}"></script>
	<script src="{{ asset('js/plugin/bootstrap-switch.min.js') }}"></script>
	<script src="{{ asset('js/plugin/jquery.blockUI.min.js') }}"></script>
	<script src="{{ asset('js/plugin/bootbox.min.js') }}"></script>
	<script src="{{ asset('js/plugin/jquery.dataTables.min.js') }}"></script>
	<script src="{{ asset('js/plugin/dataTables.bootstrap.min.js') }}"></script>
	<script src="{{ asset('js/plugin/typeahead.bundle.js') }}"></script>
    <script src="{{ asset('js/plugin/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('js/plugin/nprogress.js') }}"></script>
	@yield('scripts')
	<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>