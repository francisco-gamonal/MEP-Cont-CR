<div class="menu">
	<ul class="nav">
		<?php $temp = null; ?>
		@foreach (\Auth::user()->menus as $key => $menu)
			@if($temp != $menu->id)
				<?php $temp = $menu->id; ?>
				@if(count($menu->tasksActive) > 0)
					<li class="submenu {{ (Route::currentRouteName() != "home") ? (explode("-", Route::currentRouteName())[1] == strtolower($key) ? "active" : "" ): "" }}">
						<a href="#">
							<span class="glyphicon glyphicon-home"></span>
							<span>{{mb_convert_case($menu->name, MB_CASE_TITLE, 'utf-8')}}</span>
							<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
						</a>
						<ul class="nav" style='{{ (Route::currentRouteName() != "home") ? (explode("-", Route::currentRouteName())[1] == strtolower($key) ? "display:block" : "display:none" ) : "" }}'>
						@foreach($menu->tasksActive()->select('name')->get() as $task)
							<li><a href="{{ url(''.strtolower($menu->url).'/'.strtolower($task->name).'-'.strtolower(substr($menu->url,1)))}}">{{$task->name}}</a></li>
						@endforeach
						</ul>
					</li>
				@endif
			@endif
		@endforeach
	</ul>
</div>