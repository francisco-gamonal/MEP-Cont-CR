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

//Route::get('/', 'WelcomeController@index');

Route::get('/', function()
{
	return view('layouts.content');
});
/* Test para hacer pruebas */
Route::get('test','TestController@index');
/* Lista de  Usuarios*/
Route::get('lista-usuarios','UsersController@index');
/* Crear Usuarios*/
Route::get('crear-usuarios','UsersController@create');
/* ediar Usuarios*/
Route::get('editar-usuarios','UsersController@edit');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
