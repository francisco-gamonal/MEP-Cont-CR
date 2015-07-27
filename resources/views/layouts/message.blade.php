<section class="message border-bottom">
	<div class="row">
		<div class="col-md-6">
			<a href="#"><span class="glyphicon glyphicon-th-list"></span></a>
			@if(userSchool())
				<span>{{ convertTitle(userSchool()->name) }}</span>
				<span> - Periodo</span>
			@endif
		</div>
		<div class="col-md-6">
			<div class="pull-right">
				<div class="list-inline-block">
					<ul>
						<li><a>Bienvenido {{ convertTitle(currentUser()->nameComplete()) }} - {{ convertTitle(currentUser()->typeUsers->name) }}</a></li>
						<li><a href="#"><span class="glyphicon glyphicon-envelope"></span></a></li>
						<li><a href="{{ url('/auth/logout') }}"><strong>| Cerrar Sesión</strong></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>