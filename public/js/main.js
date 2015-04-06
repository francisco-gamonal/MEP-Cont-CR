var server = "";
var pathname = document.location.pathname;
var pathnameArray= pathname.split("/public/");

server =  pathnameArray.length > 0 ? pathnameArray[0]+"/public/" : "";

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

$(function(){
	//setup Ajax
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	var data = {};
	
	//Height content-wrapper
	
	//Equals height
	$('.form-user .col-sm-6').matchHeight();
	$('.form-role .col-sm-6 fieldset').matchHeight();

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
	$(".role-checkbox").bootstrapSwitch({size:'small'});


	//Events
	$(document).off('click', '.form-role .checkAll');
	$(document).on('click', '.form-role .checkAll', function(e){
		e.preventDefault();
		$(this).parent().parent().find('.role-checkbox').bootstrapSwitch('state', true, true);
	});

	$(document).off('click', '.form-role .unCheckAll');
	$(document).on('click', '.form-role .unCheckAll', function(e){
		e.preventDefault();
		$(this).parent().parent().find('.role-checkbox').bootstrapSwitch('state', false, false);
	});

	$(document).off('click', '#checkAll');
	$(document).on('click', '#checkAll', function(e){
		e.preventDefault();
		$('.role-checkbox').bootstrapSwitch('state', true, true);
	});

	$(document).off('click', '#unCheckAll');
	$(document).on('click', '#unCheckAll', function(e){
		e.preventDefault();
		$('.role-checkbox').bootstrapSwitch('state', false, false);
	});

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
	
	/**
	 * User
	 */

	var urlUser = pathnameArray[1].split('/');
	if(urlUser[1] === 'registrar-usuario' || urlUser[1] === 'editar-usuario'){
		localStorage.clear();

		if(urlUser[1] === 'registrar-usuario'){
			var prefetch = '../json/schools.json';
		}else{
			var prefetch = '../../json/schools.json';
		}
		
		var schools = new Bloodhound({
			datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
			queryTokenizer: Bloodhound.tokenizers.whitespace,
			prefetch: prefetch
	    });
	    schools.initialize();

	    var elt = $('#schools');
	    elt.tagsinput({
			itemValue: 'value',
			itemText: 'text',
			typeaheadjs: {
				name: 'schools',
				displayKey: 'text',
				source: schools.ttAdapter()
			}
	    });

	    if(urlUser[1] === 'editar-usuario'){
			if($("#hdnSchools").attr('data-id').length === 1){
				var value = $("#hdnSchools").attr('data-id');
				var text  = $("#hdnSchools").attr('data-name');
		    	elt.tagsinput('add', {"value": value, "text": ''+ text})
			}else if($("#hdnSchools").attr('data-id').length > 1){
				var value = $("#hdnSchools").attr('data-id').split(',');
				var text  = $("#hdnSchools").attr('data-name').split(',');
				for(var i = 0; i<value.length; i++){
		    		elt.tagsinput('add', {"value": value[i], "text": '' + text[i]})
		    	}
			}
	    }
	}

	//Save User
	$(document).off('click', '#saveUser');
	$(document).on('click', '#saveUser', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save-' + url;
		var schools    = $("#schools").val();
		var arrSchools = schools.split(',');
		data.nameUser      = $('#nameUser').val();
		data.lastNameUser  = $('#lastNameUser').val();
		data.emailUser     = $('#emailUser').val();
		data.passwordUser  = $('#passwordUser').val();
		data.idTypeUser    = $('#typeUser').val();
		data.tokenSupplier = $('#supplier').val();
		data.schoolsUser   = arrSchools;
		data.statusUser    = $('#statusUser').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Update User
	$(document).off('click', '#updateUser');
	$(document).on('click', '#updateUser', function(e){
		e.preventDefault();
		var url;
		var idUser;
		idUser = $('#idUser').val();
		url    = $(this).data('url');
		url    = url + '/update-' + url + '/' + idUser;
		data.idUser        = idUser;
		var schools        = $("#schools").val();
		var arrSchools     = schools.split(',');
		data.nameUser      = $('#nameUser').val();
		data.lastNameUser  = $('#lastNameUser').val();
		data.emailUser     = $('#emailUser').val();
		data.passwordUser  = null;
		data.idTypeUser    = $('#typeUser').val();
		data.tokenSupplier = $('#supplier').val();
		data.schoolsUser   = arrSchools;
		data.statusUser    = $('#statusUser').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active User
	$(document).off('click', '#activeUser');
	$(document).on('click', '#activeUser', function(e){
		e.preventDefault();
		var url;
		var idUser  = $(this).parent().parent().find('.user_number').text();
		url         = $(this).data('url');
		url         = url + '/active-' + url + '/' + idUser;
		data.idUser = idUser;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete User
	$(document).off('click', '#deleteUser');
	$(document).on('click', '#deleteUser', function(e){
		e.preventDefault();
		var url;
		var idUser  = $(this).parent().parent().find('.user_number').text();
		url         = $(this).data('url');
		url         = url + '/delete-' + url + '/' + idUser;
		data.idUser = idUser;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * End User
	 */
	
	/**
	 * School
	 */
	
	//Save School
	$(document).off('click', '#saveSchool');
	$(document).on('click', '#saveSchool', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.nameSchool       = $('#nameSchool').val();
		data.charterSchool    = $('#charterSchool').val();
		data.circuitSchool    = $('#circuitSchool').val();
		data.codeSchool       = $('#codeSchool').val();
		data.ffinancingSchool = $('#ffinancingSchool').val();
		data.presidentSchool  = $('#presidentSchool').val();
		data.secretarySchool  = $('#secretarySchool').val();
		data.accountSchool    = $('#accountSchool').val();
		data.titleOneSchool   = $('#titleOneSchool').val();
		data.titleTwoSchool   = $('#titleTwoSchool').val();
		data.statusSchool     = $('#statusSchool').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Update School
	$(document).off('click', '#updateSchool');
	$(document).on('click', '#updateSchool', function(e){
		e.preventDefault();
		var url;
		var idSchool;
		idSchool = $('#idSchool').val();
		url = $(this).data('url');
		url = url + '/update-' + url + '/' + idSchool;
		data.idSchool     = idSchool;
		data.nameSchool       = $('#nameSchool').val();
		data.charterSchool    = $('#charterSchool').val();
		data.circuitSchool    = $('#circuitSchool').val();
		data.codeSchool       = $('#codeSchool').val();
		data.ffinancingSchool = $('#ffinancingSchool').val();
		data.presidentSchool  = $('#presidentSchool').val();
		data.secretarySchool  = $('#secretarySchool').val();
		data.accountSchool    = $('#accountSchool').val();
		data.titleOneSchool   = $('#titleOneSchool').val();
		data.titleTwoSchool   = $('#titleTwoSchool').val();
		data.statusSchool     = $('#statusSchool').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active School
	$(document).off('click', '#activeSchool');
	$(document).on('click', '#activeSchool', function(e){
		e.preventDefault();
		var url;
		var idSchool  = $(this).parent().parent().find('.school_number').text();
		url           = $(this).data('url');
		url           = url + '/active-' + url + '/' + idSchool;
		data.idSchool = idSchool;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete School
	$(document).off('click', '#deleteSchool');
	$(document).on('click', '#deleteSchool', function(e){
		e.preventDefault();
		var url;
		var idSchool  = $(this).parent().parent().find('.school_number').text();
		url           = $(this).data('url');
		url           = url + '/delete-' + url + '/' + idSchool;
		data.idSchool = idSchool;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	
	/**
	 * End School
	 */
	
	/**
	 * Roles
	 */
	
	$(document).off('click', '#updateRole');
	$(document).on('click', '#updateRole', function(e){
		e.preventDefault();
		var url;
		var idMenu;
		var roles = [];
		url = $(this).data('url');
		url = url + '/update-' + url;
		
		$('.menu-role').each(function (index) {
			idMenu = $(this).attr('data-menu');
			var idTasks     = [];
			var statusTasks = [];
			$('.menu-role:eq('+index+') .role-checkbox').each(function (i){
				idTasks[i]     = $(this).data('id');
				statusTasks[i] = $(this).bootstrapSwitch('state');
			});
			roles[idMenu] = {'idTasks': idTasks, 'statusTasks': statusTasks};
		});
		data.idUser = $("#idUser").val();
		data.roles  = roles;
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	
	/**
	 * End Roles
	 */

	/**
	 * Groups
	 */
	
	//Save Group
	$(document).off('click', '#saveGroup');
	$(document).on('click', '#saveGroup', function(e){
		e.preventDefault();
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.codeGroup   = $('#codeGroup').val();
		data.nameGroup   = $('#nameGroup').val();
		data.statusGroup = $('#statusGroup').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Active Group
	$(document).off('click', '#activeGroup');
	$(document).on('click', '#activeGroup', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.group_code').data('token');
		console.log(token);
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Group
	$(document).off('click', '#deleteGroup');
	$(document).on('click', '#deleteGroup', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.group_code').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Group
	$(document).off('click', '#updateGroups');
	$(document).on('click', '#updateGroups', function(e){
		e.preventDefault();
		var url;
		var roles = [];
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token       = $("#codeGroup").data('token');
		data.codeGroup   = $('#codeGroup').val();
		data.nameGroup   = $('#nameGroup').val();
		data.statusGroup = $('#statusGroup').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	
	/**
	 * End Groups
	 */
	
	/**
	 * Type Budgets
	 */
	
	//Save Type Budgets
	$(document).off('click', '#saveTypeBudget');
	$(document).on('click', '#saveTypeBudget', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.nameTypeBudget   = $('#nameTypeBudget').val();
		data.statusTypeBudget = $('#statusTypeBudget').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Active Type Budgets
	$(document).off('click', '#activeTypeBudget');
	$(document).on('click', '#activeTypeBudget', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.type_budget_name').data('token');
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Type Budgets
	$(document).off('click', '#deleteTypeBudget');
	$(document).on('click', '#deleteTypeBudget', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.type_budget_name').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Type Budgets
	$(document).off('click', '#updateTypeBudget');
	$(document).on('click', '#updateTypeBudget', function(e){
		e.preventDefault();
		var url;
		var roles = [];
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token            = $("#nameTypeBudget").data('token');
		data.nameTypeBudget   = $('#nameTypeBudget').val();
		data.statusTypeBudget = $('#statusTypeBudget').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	
	/**
	 * End Type Budgets
	 */
	

	/**
	 * Catalogs
	 */
	
	//Save Catalogs
	$(document).off('click', '#saveCatalog');
	$(document).on('click', '#saveCatalog', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.cCatalog      = $('#cCatalog').val();
		data.scCatalog     = $('#scCatalog').val();
		data.gCatalog      = $('#gCatalog').val();
		data.sgCatalog     = $('#sgCatalog').val();
		data.pCatalog      = $('#pCatalog').val();
		data.spCatalog     = $('#spCatalog').val();
		data.rCatalog      = $('#rCatalog').val();
		data.srCatalog     = $('#srCatalog').val();
		data.fCatalog      = $('#fCatalog').val();
		data.nameCatalog   = $('#nameCatalog').val();
		data.typeCatalog   = $('#typeCatalog').val();
		data.groupCatalog  = $('#groupCatalog').val();
		data.statusCatalog = $('#statusCatalog').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	//Active Catalogs
	$(document).off('click', '#activeCatalog');
	$(document).on('click', '#activeCatalog', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.catalog_name').data('token');
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Catalogs
	$(document).off('click', '#deleteCatalog');
	$(document).on('click', '#deleteCatalog', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.catalog_name').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Catalogs
	$(document).off('click', '#updateCatalog');
	$(document).on('click', '#updateCatalog', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token         = $('#nameCatalog').data('token');
		data.cCatalog      = $('#cCatalog').val();
		data.scCatalog     = $('#scCatalog').val();
		data.gCatalog      = $('#gCatalog').val();
		data.sgCatalog     = $('#sgCatalog').val();
		data.pCatalog      = $('#pCatalog').val();
		data.spCatalog     = $('#spCatalog').val();
		data.rCatalog      = $('#rCatalog').val();
		data.srCatalog     = $('#srCatalog').val();
		data.fCatalog      = $('#fCatalog').val();
		data.nameCatalog   = $('#nameCatalog').val();
		data.typeCatalog   = $('#typeCatalog').val();
		data.groupCatalog  = $('#groupCatalog').val();
		data.statusCatalog = $('#statusCatalog').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * End Catalogs
	 */
	

	/**
	 * Budgets
	 */

	//Save Catalogs
	$(document).off('click', '#saveBudget');
	$(document).on('click', '#saveBudget', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.nameBudget        = $('#nameBudget').val();
		data.sourceBudget      = $('#sourceBudget').val();
		data.descriptionBudget = $('#descriptionBudget').val();
		data.yearBudget        = $('#yearBudget').val();
		data.typeBudget        = $('#typeBudget').val();
		data.globalBudget      = $('#globalBudget').val();
		data.schoolBudget      = $('#schoolBudget').val();
		data.statusBudget      = $('#statusBudget').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		})
	});

	dataTable('#table_menu', 'menús');
	dataTable('#table_type_user', 'tipos de usuarios');
	dataTable('#table_supplier', 'proveedores');
	dataTable('#table_school', 'instituciones');
	dataTable('#table_user', 'usuarios');
	dataTable('#table_role', 'usuarios');
	dataTable('#table_groups', 'grupos');
	dataTable('#table_type_budget', 'tipos de presupuestos');
	dataTable('#table_catalogs', 'catálogos');
	dataTable('#table_budgets', 'presupuestos');

});
