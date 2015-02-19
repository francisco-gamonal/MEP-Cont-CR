$(function(){

	var data = {};

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

	var ajaxForm = function (url, type, data){
		console.log(url,type,data);
		var server = "http://localhost/MEP-Cont-CR/public/";
		var path = server + url;
		console.log(path);
		return $.ajax({
				url: path,
			    type: type,
			    data: {data: data},
			    datatype: 'json',
			    beforeSend: function(){
		    		console.log('Antes de ir');
			    },
			    error:function(){
			    	console.log('No se pueden grabar los datos.');
			    }
			});
	};

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

	$("[name='task-checkbox']").bootstrapSwitch({size:'normal'});

	$(document).on("click", "#save", function(e){
		e.preventDefault();
		var url;
		var stateTasks = [];
		var idTasks = [];
		var nameMenu;
		var urlMenu;
		url = $(this).data('url');
		url = url + '/save-' + url;
		$(".task_menu").each(function(index){
			stateTasks[index] = $(this).bootstrapSwitch('state');
			idTasks[index] = $(this).data('id');
		});
		data.nameMenu = $("#nameMenu").val();
		data.urlMenu = $("#urlMenu").val();
		data.idTasks = idTasks;
		data.stateTasks = stateTasks;
		ajaxForm(url,'post',data)
		.done( function (data) {
			console.log("Ok");
		})
	});

	
	
});