<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MEP</title>
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
	<link rel="stylesheet" href="{{ asset('css/simple-sidebar.css') }}">
	<link rel="stylesheet" href="{{ asset('css/main.css') }}">

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
			<figure><a href="{{ url('/') }}"><img class="center-block" src="{{ asset('img/mep-logo.png') }}"></a></figure>
		</div>
		<div class="menu">
			<ul class="nav">
				<li class="active">
					<a href="{{ url('/') }}"><span class="glyphicon glyphicon-home"></span>Home</a>
				</li>
				<li class="submenu">
					<a href="#">
						<span class="glyphicon glyphicon-home"></span>
						<span>Profile</span>
						<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
					</a>
					<ul class="nav">
						<li><a href="#">Developer</a></li>
						<li><a href="#">DBA</a></li>
						<li><a href="#">Servidores</a></li>
						<li><a href="#">Servidores</a></li>
					</ul>
				</li>
				<li>
					<a href="#"><span class="glyphicon glyphicon-home"></span>Messages</a>
				</li>
				<li class="submenu">
					<a href="#">
						<span class="glyphicon glyphicon-home"></span>
						<span>Profile</span>
						<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
					</a>
					<ul class="nav">
						<li><a href="#">Developer</a></li>
						<li><a href="#">DBA</a></li>
						<li><a href="#">Servidores</a></li>
						<li><a href="#">Servidores</a></li>
					</ul>
				</li>
				<li>
					<a href="#"><span class="glyphicon glyphicon-home"></span>Messages</a>
				</li>
			</ul>
		</div>
	</div>
	<div class="content-wrapper">
		@yield('message')
		@yield('page')
		@yield('content')
	</div>
	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('js/plugin/jquery.matchHeight-min.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>