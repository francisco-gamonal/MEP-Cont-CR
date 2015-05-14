<section class="message border-bottom">
	<div class="row">
		<div class="col-md-4">
			<a href="#"><span class="glyphicon glyphicon-th-list"></span></a>
		</div>
		<div class="col-md-8">
			<div class="pull-right">
				<div class="list-inline-block">
					<ul>
						<li><a>Bienvenido {{Auth::user()->name.' '.Auth::user()->last}} - {{Auth::user()->typeUsers->name}}</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-envelope"></span></a></li>
						<li><a href="{{ url('/auth/logout') }}"><strong>| Cerrar Sesión</strong></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>