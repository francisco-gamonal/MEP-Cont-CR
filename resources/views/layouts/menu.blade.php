<div class="menu">
	<ul class="nav">
		<?php $menus = \Html::menu(); ?>
		@foreach ($menus as $menu)
			<li class="submenu {{ ($menu['currentRoute'] != "inicio") ? ( $menu['currentRoute'] == strtolower(substr($menu['url'],1)) ? "active" : "" ): "" }}">
				<a href="#">
					<span class="glyphicon glyphicon-home"></span>
					<span>{{mb_convert_case($menu['name'], MB_CASE_TITLE, 'utf-8')}}</span>
					<span class="icon-menu glyphicon glyphicon-chevron-right pull-right"></span>
				</a>
				<ul class="nav" style='{{ ($menu['currentRoute'] != "inicio") ? ($menu['currentRoute'] == strtolower(substr($menu['url'],1)) ? "display:block" : "display:none" ) : "" }}'>
				@foreach($menu['tasks'] as $task)
					<li class="{{ ($menu['currentRoute'] != "inicio") ? ( (Route::currentRouteName() == strtolower($task['name']).'-'.$menu['currentRoute']) ? "active-menu" : ""): "" }}">
						<a href="{{ url(''.strtolower($menu['url']).'/'.strtolower($task['name']).'-'.strtolower(substr($menu['url'],1)))}}">{{$task['name']}}</a>
					</li>
				@endforeach
				</ul>
			</li>
		@endforeach
	</ul>
</div>