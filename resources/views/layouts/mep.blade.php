<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MEP</title>
	<link rel="stylesheet" href="{{ asset('css/app.css') }}">
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
		@yield('menu')
		<div class="logo paddingWrapper">
			<figure><a href="{{ url('/') }}"><img class="center-block" src="{{ asset('img/mep-logo.png') }}"></a></figure>
		</div>
		<ul class="nav">
			<li><a href="#">Home</a></li>
			<li><a href="#">Profile</a></li>
			<li><a href="#">Messages</a></li>
		</ul>
	</div>
	<div class="content-wrapper ">
		@yield('message')
		<div class="message border-bottom">
			Message
		</div>
		@yield('content')
		<aside class="page"> 
			<h2>Home	</h2>
			<ul>
				<li class="active">Home</li>
			</ul>
		</aside>
		<div id="content" class="paddingWrapper">
			<div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque a repellat dolorem fuga, fugiat facere, voluptatem odio hic consequatur commodi qui repellendus, iusto, quae reprehenderit id eius! Magnam, ex, laborum.</div>
			<div>Eveniet culpa quo eligendi. Non consequuntur in quod officia, dicta. Dicta veniam labore aliquam, odit et rem quos maiores, dolor maxime expedita, ratione corrupti. Eius sapiente neque, exercitationem tempora iure!</div>
			<div>Reprehenderit, blanditiis laborum cupiditate illo eius fuga voluptates cumque labore numquam ducimus quaerat aliquid commodi debitis pariatur iste minima dicta, beatae natus repudiandae sequi earum dolore at dolorem. Cumque, necessitatibus!</div>
			<div>Fugit labore porro, iure earum voluptatem tenetur iusto dignissimos atque sit reiciendis quisquam ducimus provident veniam dicta ipsum velit numquam distinctio, consectetur ad amet sunt ab eius sint error? Saepe.</div>
			<div>Consectetur repellendus, debitis, autem odit repellat corporis nostrum sunt provident facilis suscipit, veniam officiis quod. Similique eveniet, assumenda molestias mollitia itaque, sapiente reiciendis labore ipsa ut eos architecto voluptas at.</div>
			<div>Dolores officia dolorum reprehenderit tempora laborum adipisci, minima earum, animi odio deleniti mollitia ab possimus explicabo qui vel nulla error sequi impedit nihil, itaque, alias dolorem perferendis quos nemo. Voluptatum.</div>
			<div>Corrupti eum totam quasi dolores quos laudantium quia vero cumque perferendis nemo, quo incidunt fugiat sapiente, atque, enim accusantium dignissimos repellendus ipsam cupiditate voluptas fugit iste, architecto pariatur. Neque, perferendis.</div>
			<div>Esse natus ducimus illo magnam labore ut, odit reiciendis, optio vero vitae! Nemo dolor mollitia, libero, neque nihil reprehenderit tenetur sit rerum dolorem quam aut. Corporis ratione repellat praesentium suscipit.</div>
			<div>Voluptatibus non eum consequuntur doloribus nostrum culpa distinctio, dolor maxime, quis voluptates inventore. Totam repellendus ut vero optio voluptatibus ex perspiciatis, dolorum, earum fugit tempora, eius debitis porro nulla pariatur?</div>
			<div>Labore minus, odio quidem aliquam consequatur quam, vitae sit eaque. Culpa, necessitatibus! Itaque ipsum aut qui aliquam dolore vero culpa voluptatum, voluptatibus blanditiis quaerat, animi, molestiae accusantium porro aspernatur eos.</div>
		</div>
	</div>

	<!-- Scripts -->
	<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
	<script src="{{ asset('js/plugin/jquery.matchHeight-min.js') }}"></script>
	<script src="{{ asset('js/main.js') }}"></script>
</body>
</html>