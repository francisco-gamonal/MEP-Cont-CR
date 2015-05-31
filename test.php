@foreach($menu->Tasks as $taskMenu)
	@if($taskMenu->pivot->status == 1)
		@if(!$user->Tasks->isEmpty())
			@foreach($user->Tasks as $taskUser)
				@if($menu->id == $taskUser->pivot->menu_id && $taskMenu->id == $taskUser->pivot->task_id && $taskUser->pivot->status == 1)	
                    <div class="row text-center">
						<input class="role-checkbox" type="checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}" checked>
					</div>
				@elseif($menu->id == $taskUser->pivot->menu_id && $taskMenu->id == $taskUser->pivot->task_id && $taskUser->pivot->status == 0)
					<div class="row text-center">
						<input class="role-checkbox" type="checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}">
					</div>
				@endif
			@endforeach
		@else
			<div class="row text-center">
				<input class="role-checkbox" type="checkbox" data-on-text="Activado" data-off-text="Desactivado" data-on-color="info" data-off-color="danger" data-label-text="{{$taskMenu->name}}" data-id="{{$taskMenu->id}}">
			</div>
		@endif
	@endif
@endforeach
<script>
	$(".menu-role").each(function(index){
	  	if($(this).find('div.row').length == 0){
	    	$(this).remove();
	  	}
	});
</script>