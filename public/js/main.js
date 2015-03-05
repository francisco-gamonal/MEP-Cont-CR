$(function(){
	//Functions
	var dataTable = function(selector, list){
		var options = {
			"order": [
                [0, "asc"]
            ],
            "bLengthChange": true,
            //'iDisplayLength': 7,
            "oLanguage": {
            	"sLengthMenu": "_MENU_ registros por página",
            	"sInfoFiltered": " - filtrada de _MAX_ registros",
                "sSearch": "Buscar: ",
                "sZeroRecords": "No hay " + list,
                "sInfoEmpty": " ",
                "sInfo": 'Mostrando _END_ de _TOTAL_',
                "oPaginate": {
                    "sPrevious": "Anterior",
                    "sNext": "Siguiente"
                }
            }
		};
		$(selector).DataTable(options);
	};

	var messageAjax = function(data) {
		$.unblockUI();
		if(data.success){
			bootbox.alert('<p class="success-ajax">'+data.message+'</p>', function(){
				location.reload();
			});;
		}
		else{
			var errors = data.errors;
			var error = "";
			for (var element in errors){
				if(errors.hasOwnProperty(element)){
					error += errors[element] + '<br>';
				}
			}
			bootbox.alert('<p class="error-ajax">'+error+'</p>');
		}
	};

	//Functions Menu
	var addActive = function (element) {
		element.find('.icon-menu').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
		element.addClass('active');
		element.find('.nav').show('slide');
	}

	var removeActive = function (element) {
		$('.active').find('.icon-menu').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
		$('.active').find('.nav').hide('slide');
		$('.active').removeClass('active');
	};
	//End functions Menu

	//Function Overlay
	var loadingUI = function (message){
	    $.blockUI({ css: {
	        border: 'none',
	        padding: '15px',
	        backgroundColor: '#000',
	        '-webkit-border-radius': '10px',
	        '-moz-border-radius': '10px',
	        opacity: 0.5,
	        color: '#fff'
	    }, message: '<h2><img style="margin-right: 30px" src="' + server + 'img/spiffygif.gif" >' + message + '</h2>'});
	};

	var responseUI = function (message,color){
	    $.unblockUI();
	    $.blockUI({ css: {
	        border: 'none',
	        padding: '15px',
	        backgroundColor: color,
	        '-webkit-border-radius': '10px',
	        '-moz-border-radius': '10px',
	        opacity: 0.5,
	        color: '#fff'
	    }, message: '<h2>' + message + '</h2>'});
	    setTimeout(function(){
	        $.unblockUI();
	    },750);
	};
	//End functions overlay

	//Function Ajax
	var ajaxForm = function (url, type, data){
		var message;
		var path = server + url;
		if(type == 'post'){
			message = 'Registrando';
		}else{
			message = 'Actualizando';
		}
		//console.log(path,type,data);return;
		return $.ajax({
					url: path,
				    type: type,
				    data: {data: JSON.stringify(data)},
				    datatype: 'json',
				    beforeSend: function(){
			    		loadingUI(message);
				    },
				    error:function(){
				    	$.unblockUI();
				    	bootbox.alert("<p class='red'>No se pueden grabar los datos.</p>")
				    	//responseUI('No se pueden grabar los datos.', 'red');
				    }
				});
	};	

	//setup Ajax
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	var data = {};
	var server = 'http://localhost/MEP-Cont-CR/public/';

	//Equals height
	$('[class*="-wrapper"]').matchHeight();

	//Event menu expand
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

	//Switch Checkbox
	$("[name='task-checkbox']").bootstrapSwitch({size:'normal'});
	$("[name='status-checkbox']").bootstrapSwitch({size:'normal'});


	/**
	 * Menu
	 */
	
	//Save Menu
	$(document).off('click', '#saveMenu');
	$(document).on('click', '#saveMenu', function(e){
		e.preventDefault();
		var url;
		var stateTasks = [];
		var idTasks = [];
		url = $(this).data('url');
		url = url + '/save-' + url;
		$('.task_menu').each(function(index){
			stateTasks[index] = $(this).bootstrapSwitch('state');
			idTasks[index]    = $(this).data('id');
		});
		data.nameMenu   = $('#nameMenu').val();
		data.urlMenu    = $('#urlMenu').val();
		data.idTasks    = idTasks;
		data.stateTasks = stateTasks;
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Menu
	$(document).off('click', '#updateMenu');
	$(document).on('click', '#updateMenu', function(e){
		e.preventDefault();
		var url;
		var idMenu;
		var statusMenu;
		var stateTasks = [];
		var idTasks = [];
		url        = $(this).data('url');
		idMenu     = $('#idMenu').val();
		statusMenu = $('#statusMenu').bootstrapSwitch('state');
		url        = url + '/update-' + url + '/' + idMenu;
		$('.task_menu').each(function(index){
			stateTasks[index] = $(this).bootstrapSwitch('state');
			idTasks[index]    = $(this).data('id');
		});
		data.idMenu     = idMenu;
		data.statusMenu = statusMenu;
		data.nameMenu   = $('#nameMenu').val();
		data.urlMenu    = $('#urlMenu').val();
		data.idTasks    = idTasks;
		data.stateTasks = stateTasks;
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Menu
	$(document).off('click', '#activeMenu');
	$(document).on('click', '#activeMenu', function(e){
		e.preventDefault();
		var url;
		var idMenu  = $(this).parent().parent().find('.iglesia_number').text();
		url         = $(this).data('url');
		url         = url + '/active-' + url + '/' + idMenu;
		data.idMenu = idMenu;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
			location.reload();
		});
	});

	//Delete Menu
	$(document).off('click', '#deleteMenu');
	$(document).on('click', '#deleteMenu', function(e){
		e.preventDefault();
		var url;
		var idMenu  = $(this).parent().parent().find('.iglesia_number').text();
		url         = $(this).data('url');
		url         = url + '/delete-' + url + '/' + idMenu;
		data.idMenu = idMenu;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * End Menu
	 */

	/**
	 * Type User
	 */
	//Save Type User
	$(document).off('click', '#saveTypeUser');
	$(document).on('click', '#saveTypeUser', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.nameTypeUser   = $('#nameTypeUser').val();
		data.statusTypeUser = $('#statusTypeUser').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Update Type User
	$(document).off('click', '#updateTypeUser');
	$(document).on('click', '#updateTypeUser', function(e){
		e.preventDefault();
		var url;
		var idTypeUser;
		idTypeUser = $('#idTypeUser').val();
		url = $(this).data('url');
		url = url + '/update-' + url + '/' + idTypeUser;
		data.idTypeUser     = idTypeUser;
		data.nameTypeUser   = $('#nameTypeUser').val();
		data.statusTypeUser = $('#statusTypeUser').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Type User
	$(document).off('click', '#activeTypeUser');
	$(document).on('click', '#activeTypeUser', function(e){
		e.preventDefault();
		var url;
		var id_type_user = $(this).parent().parent().find('.type_user_number').text();
		url              = $(this).data('url');
		url              = url + '/active-' + url + '/' + id_type_user;
		data.idTypeUser = id_type_user;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Type User
	$(document).off('click', '#deleteTypeUser');
	$(document).on('click', '#deleteTypeUser', function(e){
		e.preventDefault();
		var url;
		var id_type_user = $(this).parent().parent().find('.type_user_number').text();
		url              = $(this).data('url');
		url              = url + '/delete-' + url + '/' + id_type_user;
		data.idTypeUser  = id_type_user;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * End Type User
	 */

	/**
	 * Supplier
	 */
	//Save Supplier
	$(document).off('click', '#saveSupplier');
	$(document).on('click', '#saveSupplier', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.charterSupplier = $('#charterSupplier').val();
		data.nameSupplier    = $('#nameSupplier').val();
		data.phoneSupplier   = $('#phoneSupplier').val();
		data.emailSupplier   = $('#emailSupplier').val();
		data.statusSupplier  = $('#statusSupplier').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Update Supplier
	$(document).off('click', '#updateSupplier');
	$(document).on('click', '#updateSupplier', function(e){
		e.preventDefault();
		var url;
		var tokenSupplier;
		tokenSupplier = $('#tokenSupplier').val();
		url           = $(this).data('url');
		url           = url + '/update-' + url + '/' + tokenSupplier;
		data.tokenSupplier = tokenSupplier;
		data.charterSupplier = $('#charterSupplier').val();
		data.nameSupplier    = $('#nameSupplier').val();
		data.phoneSupplier   = $('#phoneSupplier').val();
		data.emailSupplier   = $('#emailSupplier').val();
		data.statusSupplier  = $('#statusSupplier').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Supplier
	$(document).off('click', '#activeSupplier');
	$(document).on('click', '#activeSupplier', function(e){
		e.preventDefault();
		var url;
		var tokenSupplier  = $(this).parent().parent().find('#tokenSupplier').val();
		url                = $(this).data('url');
		url                = url + '/active-' + url + '/' + tokenSupplier;
		data.tokenSupplier = tokenSupplier;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Type User
	$(document).off('click', '#deleteSupplier');
	$(document).on('click', '#deleteSupplier', function(e){
		e.preventDefault();
		var url;
		var tokenSupplier  = $(this).parent().parent().find('#tokenSupplier').val();
		url                = $(this).data('url');
		url                = url + '/delete-' + url + '/' + tokenSupplier;
		data.tokenSupplier = tokenSupplier;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});


	/**
	 * End Supplier
	 */

	dataTable('#table_menu', 'menús');
	dataTable('#table_type_user', 'tipo de usuarios');
	dataTable('#table_supplier', 'proveedores');
});