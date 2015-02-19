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

/**
 *  Rutas de Menu
 */
Route::get('menu/ver-menu','MenuController@index');
Route::get('menu/registrar-menu','MenuController@create');
Route::post('menu/save-menu','MenuController@store');
Route::get('menu/{id}/editar-menu','MenuController@edit');
Route::delete('menu/delete-menu/{id}','MenuController@destroy');
Route::put('menu/update-menu/{id}','MenuController@update');
/**
 * Fin Rutas Menu
*/

/**
 *  Rutas de Menu
 */
Route::get('usuarios/ver-usuarios','MenuController@index');
Route::get('usuarios/registrar-usuarios','MenuController@create');
Route::post('usuarios/save-usuarios','MenuController@store');
Route::get('usuarios/{id}/editar-usuarios','MenuController@edit');
Route::delete('usuarios/delete-usuarios/{id}','MenuController@destroy');
Route::put('usuarios/update-usuarios/{id}','MenuController@update');
/**
 * Fin Rutas Menu
*/
/* Lista de  Usuarios*/
Route::get('usuarios/lista-usuarios','UsersController@index');
/* Crear Usuarios*/
Route::get('usuarios/crear-usuarios','UsersController@create');
/* ediar Usuarios*/
Route::get('usuarios/{id}/editar-usuarios','UsersController@edit');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
