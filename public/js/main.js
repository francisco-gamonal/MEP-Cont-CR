$(function(){
	$('[class*="-wrapper"]').matchHeight();

	$('.submenu').on('click', function(e){
		e.preventDefault();
		var element = $(this);
		var exp = false;
		if($(this).hasClass('active')){
			exp = true;
		};
		removeActive();
		if(!$(this).hasClass('active')){
			if(!exp){
				addActive(element);
			}
		}
	});

	var removeActive = function (element) {
		$('.active').find('.icon-menu').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
		$('.active').find('.nav').hide('slide');
		$('.active').removeClass('active');
	};

	var addActive = function (element) {
		element.find('.icon-menu').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
		element.addClass('active');
		element.find('.nav').show('slide');
	}

	$("[name='my-checkbox']").bootstrapSwitch({size:'mini'});
	
});