<?php 
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
Route::group(['before' => 'guest'], function ()
{*/
    //si el usuario ha iniciado sesión dar acceso a las rutas
    require (__DIR__ . '/Routes/User.php');
    require (__DIR__ . '/Routes/Menu.php');
    require (__DIR__ . '/Routes/Schools.php');
    require (__DIR__ . '/Routes/Roles.php');
    require (__DIR__ . '/Routes/TypeUser.php');
    require (__DIR__ . '/Routes/Task.php');
   
//});

Route::get('/', function()
{
	return view('auth.login');
});
/* Test para hacer pruebas */
Route::get('test','TestController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/* Lista de  Usuarios*/
Route::get('tarea/lista-tareas','TasksController@index');
/* Crear Usuarios*/
Route::get('usuarios/crear-usuarios','UsersController@create');
/* ediar Usuarios*/
Route::get('usuarios/{id}/editar-usuarios','UsersController@edit');