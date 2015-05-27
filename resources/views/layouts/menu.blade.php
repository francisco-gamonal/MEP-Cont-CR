<div class="menu">
	<ul class="nav">
		<?php $menus = \Mep\Facades\MenuFacades::Menu(); ?>
		@foreach ($menus as $key => $menu)
			@if(count($menu['tasks']) > 0)
				<li class='submenu {{ (explode("-", Route::currentRouteName())[1] == strtolower($key) ? "active" : "" ) }}'>
					<a href="#">
						<span class="glyphicon glyphicon-home"></span>
						<span>{{mb_convert_case($key, MB_CASE_TITLE, 'utf-8')}}</span>
						<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
					</a>
					<ul class="nav" style='{{ (explode("-", Route::currentRouteName())[1] == strtolower($key) ? "display:block" : "display:none" ) }}'>
					@foreach($menu['tasks'] as $task)
						<li class='{{ (Route::currentRouteName() == strtolower($task->name)."-".strtolower($key) ? "active-menu" : "") }}'><a href="{{ url(strtolower($menu['url']).'/'.strtolower($task->name).'-'.strtolower($key))}}">{{$task->name}}</a></li>
					@endforeach
					</ul>
				</li>
			@endif
		@endforeach
		<!-- <li class="active">
			<a href="{{ url('/') }}">
				<span class="glyphicon glyphicon-home"></span>
				<span>Home</span>
			</a>
		</li>
		<li class="submenu">
			<a href="#">
				<span class="glyphicon glyphicon-home"></span>
				<span>Profile1</span>
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
			<a href="#">
				<span class="glyphicon glyphicon-home"></span>
				<span>Messages</span>
			</a>
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
			<a href="#">
				<span class="glyphicon glyphicon-home"></span>
				<span>Messages</span>
			</a>
		</li> -->
	</ul>
</div>