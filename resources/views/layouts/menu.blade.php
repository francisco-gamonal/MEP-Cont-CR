<div class="menu">
	<ul class="nav">
		<?php $menus = \Html::menu(); ?>
		@foreach ($menus as $key => $menu)
			@if(count($menu['tasks']) > 0)
				<li class='submenu {{ (Route::currentRouteName() != "home") ? (explode("-", Route::currentRouteName())[1] == strtolower($key) ? "active" : "" ): "" }}'>
					<a href="#">
						<span class="glyphicon glyphicon-home"></span>
						<span>{{mb_convert_case($key, MB_CASE_TITLE, 'utf-8')}}</span>
						<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
					</a>
					<ul class="nav" style='{{ (Route::currentRouteName() != "home") ? (explode("-", Route::currentRouteName())[1] == strtolower($key) ? "display:block" : "display:none" ) : "" }}'>
					@foreach($menu['tasks'] as $task)
						<li class='{{ (Route::currentRouteName() != "home") ? (Route::currentRouteName() == strtolower($task->name)."-".strtolower($key) ? "active-menu" : "") : "" }}'><a href="{{ url(strtolower($menu['url']).'/'.strtolower($task->name).'-'.strtolower($key))}}">{{$task->name}}</a></li>
					@endforeach
					</ul>
				</li>
			@endif
		@endforeach
	</ul>
</div>