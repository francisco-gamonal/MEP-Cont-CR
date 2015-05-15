<div class="menu">
	<ul class="nav">
		<?php $temp = null; ?>
		@foreach (\Auth::user()->menus as $menu)
			@if($temp != $menu->id)
				<?php $temp = $menu->id; ?>
				@if(count($menu->tasksActive) > 0)
					<li class="submenu">
						<a href="#">
							<span class="glyphicon glyphicon-home"></span>
							<span>{{mb_convert_case($menu->name, MB_CASE_TITLE, 'utf-8')}}</span>
							<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
						</a>
						<ul class="nav">
						@foreach($menu->tasksActive()->select('name')->get() as $task)
							<li><a href="{{ url(''.strtolower($menu->url).'/'.strtolower($task->name))}}">{{$task->name}}</a></li>
						@endforeach
						</ul>
					</li>
				@else
					<li>
						<a href="{{ url(''.$menu->url) }}">
							<span class="glyphicon glyphicon-home"></span>
							<span>{{mb_convert_case($menu->name, MB_CASE_TITLE, 'utf-8')}}</span>
						</a>
					</li>
				@endif
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