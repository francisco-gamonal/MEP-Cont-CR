var server        = "";
var pathname      = document.location.pathname;
var pathnameArray = pathname.split("/public/");

server =  pathnameArray.length > 0 ? pathnameArray[0]+"/public/" : "";

/**
 * @param  {[string]} selector [id table]
 * @param  {[string]} list [comment the table]
 * @return {[dataTable]}   [table with options dataTable]
 */
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

/**
 * [messageAjax - Response message after request ]
 * @param  {[json]} data [description messages error after request]
 * @return {[alert]}     [errors in alert]
 */
var messageAjax = function(data) {
	console.log(data.errors);
	$.unblockUI();
	if(data.success){
		bootbox.alert('<p class="success-ajax">'+data.message+'</p>', function(){
			location.reload();
		});
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

/**
 * [addActive - Add class for submenu active]
 * @param {[string]} element [submenu]
 */
var addActive = function (element) {
	element.find('.icon-menu').removeClass('glyphicon-chevron-right').addClass('glyphicon-chevron-down');
	element.addClass('active');
	element.find('.nav').show('slide');
};

/**
 * [removeActive - Remove class for submenu active]
 * @param {[string]} element [submenu]
 */
var removeActive = function (element) {
	$('.active').find('.icon-menu').removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-right');
	$('.active').find('.nav').hide('slide');
	$('.active').removeClass('active');
};

/**
 * [loadingUI - Message before ajax for request]
 * @param  {[string]} message [message for before ajax]
 * @return {[message]}        [blockUI response with message]
 */
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

/**
 * [responseUI description]
 * @param  {[string]} message [message for after Ajax request]
 * @param  {[string]} color   [class for response message]
 * @return {[blockUI]}        [BlockUI]
 */
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


/**
 * [ajaxForm - setup ajax for request]
 * @param  {[string]} url  [description]
 * @param  {[string]} type [description]
 * @param  {[json]} data [description]
 * @return {[type]}      [description]
 */
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
	
	//Equals height
	$('.form-user .col-sm-6').matchHeight();
	$('.form-role .col-sm-6 fieldset').matchHeight();
	$('.form-spreadsheet .col-sm-6').matchHeight();

	//Event menu expand
	$('.submenu').on('click', function(e){
		e.preventDefault();
		var element = $(this);
		var exp = false;
		if($(this).hasClass('active')){
			exp = true;
		}
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
	//Add account transfer
	$(document).on('click', '#addAccount', function(e){
		e.preventDefault();
		if($('.outBalance').length == 1){
			$('#removeAccount').removeClass('hide');
		}
		var account = $('.outBalance aside:first').clone(true,true);
		account.appendTo('.outBalance');
	});
	//Delete account transfer
	$(document).on('click', '#removeAccount', function(e){
		e.preventDefault();
		var element = $(this);
		var account = $('.outBalance aside:first');
		account.remove();
		if($('.outBalance aside').length == 1){
			element.addClass('hide');
		}
	});

	//Ajax Select Number Account
	$(document).off('change', '#spreadsheetCheck');
	$(document).on('change', '#spreadsheetCheck', function(){
		var token = $(this).val();
		var url   = server + 'cheques/registrar-cheque/' + token;
		$('#balanceBudgetCheck').prop('disabled', true);
		$.get( url, function( data ) {
		  	$("#balanceBudgetCheck").html(data);
			$('#balanceBudgetCheck').prop('disabled', false);
		});
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
		});
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
		});
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
		}else {
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
		});
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
		});
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
		});
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
		});
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
		});
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

	//Save Budgets
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
		});
	});

	//Active Budgets
	$(document).off('click', '#activeBudget');
	$(document).on('click', '#activeBudget', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.budget_name').data('token');
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Budgets
	$(document).off('click', '#deleteBudget');
	$(document).on('click', '#deleteBudget', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.budget_name').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Budgets
	$(document).off('click', '#updateBudget');
	$(document).on('click', '#updateBudget', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token             = $('#nameBudget').data('token');
		data.nameBudget        = $('#nameBudget').val();
		data.sourceBudget      = $('#sourceBudget').val();
		data.descriptionBudget = $('#descriptionBudget').val();
		data.yearBudget        = $('#yearBudget').val();
		data.typeBudget        = $('#typeBudget').val();
		data.globalBudget      = $('#globalBudget').val();
		data.schoolBudget      = $('#schoolBudget').val();
		data.statusBudget      = $('#statusBudget').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * Balance Budgets
	 */

	//Save balanceBudgets
	$(document).off('click', '#saveBalanceBudget');
	$(document).on('click', '#saveBalanceBudget', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.amountBalanceBudget      = $('#amountBalanceBudget').val();
		data.policiesBalanceBudget    = $('#policiesBalanceBudget').val();
		data.strategicBalanceBudget   = $('#strategicBalanceBudget').val();
		data.operationalBalanceBudget = $('#operationalBalanceBudget').val();
		data.goalsBalanceBudget       = $('#goalsBalanceBudget').val();
		data.catalogsBalanceBudget    = $('#catalogsBalanceBudget').val();
		data.budgetBalanceBudget      = $('#budgetBalanceBudget').val();
		data.typeBudgetBalanceBudget  = $('#typeBudgetBalanceBudget').val();
		data.simulationBalanceBudget  = $('#simulationBalanceBudget').val();
		data.statusBalanceBudget      = $('#statusBalanceBudget').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Budgets
	$(document).off('click', '#activeBalanceBudget');
	$(document).on('click', '#activeBalanceBudget', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.balanceBudget_amount').data('token');
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete BalanceBudgets
	$(document).off('click', '#deleteBalanceBudget');
	$(document).on('click', '#deleteBalanceBudget', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.balanceBudget_amount').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Budgets
	$(document).off('click', '#updateBalanceBudget');
	$(document).on('click', '#updateBalanceBudget', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token                    = $('#amountBalanceBudget').data('token');
		data.amountBalanceBudget      = $('#amountBalanceBudget').val();
		data.policiesBalanceBudget    = $('#policiesBalanceBudget').val();
		data.strategicBalanceBudget   = $('#strategicBalanceBudget').val();
		data.operationalBalanceBudget = $('#operationalBalanceBudget').val();
		data.goalsBalanceBudget       = $('#goalsBalanceBudget').val();
		data.catalogsBalanceBudget    = $('#catalogsBalanceBudget').val();
		data.budgetBalanceBudget      = $('#budgetBalanceBudget').val();
		data.typeBudgetBalanceBudget  = $('#typeBudgetBalanceBudget').val();
		//data.simulationBalanceBudget  = $('#simulationBalanceBudget').val();
		data.statusBalanceBudget      = $('#statusBalanceBudget').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * End BalanceBudget
	 */

	/**
	 * Spreadsheets
	 */

	//Save Spreadsheet
	$(document).off('click', '#saveSpreadsheets');
	$(document).on('click', '#saveSpreadsheets', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.numberSpreadsheets = $('#numberSpreadsheets').val();
		data.yearSpreadsheets   = $('#yearSpreadsheets').val();
		data.dateSpreadsheets   = $('#dateSpreadsheets').val();
		data.budgetSpreadsheets = $('#budgetSpreadsheets').val();
		data.statusSpreadsheets = $('#statusSpreadsheets').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Spreadsheet
	$(document).off('click', '#activeSpreadsheet');
	$(document).on('click', '#activeSpreadsheet', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.tokenSpreadsheet').val();
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Spreadsheet
	$(document).off('click', '#deleteSpreadsheet');
	$(document).on('click', '#deleteSpreadsheet', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.tokenSpreadsheet').val();
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Spreadsheet
	$(document).off('click', '#updateSpreadsheet');
	$(document).on('click', '#updateSpreadsheet', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token              = $('#numberSpreadsheets').data('token');
		data.numberSpreadsheets = $('#numberSpreadsheets').val();
		data.yearSpreadsheets   = $('#yearSpreadsheets').val();
		data.dateSpreadsheets   = $('#dateSpreadsheets').val();
		data.budgetSpreadsheets = $('#budgetSpreadsheets').val();
		data.statusSpreadsheets = $('#statusSpreadsheets').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	/**
	 * End Spreadsheet
	 */
	
	/**
	 * Checks
	 */

	//Save Checks
	$(document).off('click', '#saveCheck');
	$(document).on('click', '#saveCheck', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/save-' + url;
		data.billCheck          = $('#billCheck').val();
		data.conceptCheck       = $('#conceptCheck').val();
		data.amountCheck        = $('#amountCheck').val();
		data.retentionCheck     = $('#retentionCheck').val();
		data.ckbillCheck        = $('#ckbillCheck').val();
		data.ckretentionCheck   = $('#ckretentionCheck').val();
		data.recordCheck        = $('#recordCheck').val();
		data.dateCheck          = $('#dateCheck').val();
		data.voucherCheck       = $('#voucherCheck').val();
		data.spreadsheetCheck   = $('#spreadsheetCheck').val();
		data.balanceBudgetCheck = $('#balanceBudgetCheck').val();
		data.supplierCheck      = $('#supplierCheck').val();
		data.statusCheck        = $('#statusCheck').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Check
	$(document).off('click', '#activeCheck');
	$(document).on('click', '#activeCheck', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.balanceBudgetCheck').data('token');
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Check
	$(document).off('click', '#deleteCheck');
	$(document).on('click', '#deleteCheck', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.balanceBudgetCheck').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Spreadsheet
	$(document).off('click', '#updateCheck');
	$(document).on('click', '#updateCheck', function(e){
		e.preventDefault();
		var url;
		url = $(this).data('url');
		url = url + '/update-' + url;
		data.token 		        = $('#billCheck').data('token');
		data.billCheck          = $('#billCheck').val();
		data.conceptCheck       = $('#conceptCheck').val();
		data.amountCheck        = $('#amountCheck').val();
		data.retentionCheck     = $('#retentionCheck').val();
		data.ckbillCheck        = $('#ckbillCheck').val();
		data.ckretentionCheck   = $('#ckretentionCheck').val();
		data.recordCheck        = $('#recordCheck').val();
		data.dateCheck          = $('#dateCheck').val();
		data.voucherCheck       = $('#voucherCheck').val();
		data.spreadsheetCheck   = $('#spreadsheetCheck').val();
		data.balanceBudgetCheck = $('#balanceBudgetCheck').val();
		data.supplierCheck      = $('#supplierCheck').val();
		data.statusCheck        = $('#statusCheck').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	/**
	 * End Check
	 */
	
	/**
	 * Transfer
	 */
	// Save Transfer
	$(document).off('click', '#saveTransfer');
	$(document).on('click', '#saveTransfer', function(e){
		e.preventDefault();
		var url;
		var outBalanceBudgetTransfer    = [];
		var amountBalanceBudgetTransfer = [];
		url = $(this).data('url');
		url = url + '/save-' + url;
		$(".outBalanceBudgetTransfer").each(function(index,value){
		    outBalanceBudgetTransfer[index] = $(this).val();
		});
		$(".amountBalanceBudgetTransfer").each(function(index,value){
		    amountBalanceBudgetTransfer[index] = $(this).val();
		});
		data.dateTransfer                = $('#dateTransfer').val();
		data.simulationTransfer          = $('#simulationTransfer').val();
		data.spreadsheetTransfer         = $('#spreadsheetTransfer').val();
		data.inBalanceBudgetTransfer     = $('#inBalanceBudgetTransfer').val();
		data.outBalanceBudgetTransfer    = outBalanceBudgetTransfer;
		data.amountBalanceBudgetTransfer = amountBalanceBudgetTransfer;
		data.statusTransfer              = $('#statusTransfer').bootstrapSwitch('state');
		ajaxForm(url,'post',data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Active Transfer
	$(document).off('click', '#activeTransfer');
	$(document).on('click', '#activeTransfer', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.codeTransfer').data('token');
		url       = $(this).data('url');
		url       = url + '/active-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'patch', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Delete Transfer
	$(document).off('click', '#deleteTransfer');
	$(document).on('click', '#deleteTransfer', function(e){
		e.preventDefault();
		var url;
		var token = $(this).parent().parent().find('.codeTransfer').data('token');
		url       = $(this).data('url');
		url       = url + '/delete-' + url + '/' + token;
		data.token = token;
		ajaxForm(url, 'delete', data)
		.done( function (data) {
			messageAjax(data);
		});
	});

	//Update Transfer
	$(document).off('click', '#updateTransfer');
	$(document).on('click', '#updateTransfer', function(e){
		e.preventDefault();
		var url;
		var outBalanceBudgetTransfer    = [];
		var amountBalanceBudgetTransfer = [];
		url = $(this).data('url');
		url = url + '/update-' + url;
		$(".outBalanceBudgetTransfer").each(function(index,value){
		    outBalanceBudgetTransfer[index] = $(this).val();
		});
		$(".amountBalanceBudgetTransfer").each(function(index,value){
		    amountBalanceBudgetTransfer[index] = $(this).val();
		});
		data.token                       = $('#codeTransfer').data('token');
		data.dateTransfer                = $('#dateTransfer').val();
		data.simulationTransfer          = $('#simulationTransfer').val();
		data.spreadsheetTransfer         = $('#spreadsheetTransfer').val();
		data.inBalanceBudgetTransfer     = $('#inBalanceBudgetTransfer').val();
		data.outBalanceBudgetTransfer    = outBalanceBudgetTransfer;
		data.amountBalanceBudgetTransfer = amountBalanceBudgetTransfer;
		data.statusTransfer              = $('#statusTransfer').bootstrapSwitch('state');
		ajaxForm(url,'put',data)
		.done( function (data) {
			messageAjax(data);
		});
	});
	
	/**
	 * Transfer
	 */
	
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
	dataTable('#table_balanceBudgets', 'saldo de presupuestos');
	dataTable('#table_spreadsheets', 'planillas');
	dataTable('#table_checks', 'cheques');
	dataTable('#table_transfers', 'transferencias');
});
