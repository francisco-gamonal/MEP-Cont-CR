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
Route::get('menu','MenuController@index');
Route::get('menu/ver-menu',['as'=> 'ver-menu', 'uses' => 'MenuController@index']);
Route::get('menu/registrar-menu','MenuController@create');
Route::post('menu/save-menu','MenuController@store');
Route::get('menu/editar-menu/{id}', ['as' => 'edit-menu', 'uses' =>'MenuController@edit']);
Route::delete('menu/delete-menu/{id}',['as' => 'delete-menu', 'uses' => 'MenuController@destroy']);
Route::patch('menu/active-menu/{id}',['as' => 'active-menu', 'uses' => 'MenuController@active']);
Route::put('menu/update-menu/{id}','MenuController@update');
/**
 * Fin Rutas Menu
*/

/**
 * Menu Tipo de Usuarios
 */
//Route::get('tipo-de-usuarios','TypeUsersController@index');
Route::get('tipo-de-usuario/ver-tipo-de-usuario',['as'=>'ver-tipo-de-usuario','uses'=>'TypeUsersController@index']);
Route::get('tipo-de-usuario/registrar-tipo-de-usuario','TypeUsersController@create');
Route::post('tipo-de-usuario/save-tipo-de-usuario','TypeUsersController@store');
Route::get('tipo-de-usuario/editar-tipo-de-usuario/{id}',['as'=>'edit-tipo-de-usuario','uses'=>'TypeUsersController@edit']);
Route::delete('tipo-de-usuario/delete-tipo-de-usuario/{id}',['as'=>'delete-tipo-de-usuario','uses'=>'TypeUsersController@destroy']);
Route::patch('tipo-de-usuario/active-tipo-de-usuario/{id}',['as' => 'active-tipo-de-usuario', 'uses' => 'TypeUsersController@active']);
Route::put('tipo-de-usuario/update-tipo-de-usuario/{id}','TypeUsersController@update');
/**
 * 
 */

/**
 *  Rutas de Menu
 */
Route::get('usuarios','UsersController@index');
Route::get('usuarios/ver-usuarios',['as'=>'ver-usuarios','uses'=>'UsersController@index']);
Route::get('usuarios/registrar-usuarios','UsersController@create');
Route::post('usuarios/save-usuarios','UsersController@store');
Route::get('usuarios/{id}/editar-usuarios',['as'=>'ver-usuarios','uses'=>'UsersController@edit']);
Route::delete('usuarios/delete-usuarios/{id}',['as'=>'delete-usuarios','uses'=>'UsersController@destroy']);
Route::patch('usuarios/active-usuarios/{id}',['as' => 'active-usuarios', 'uses' => 'UsersController@active']);
Route::put('usuarios/update-usuarios/{id}','UsersController@update');
/**
 * Fin Rutas Menu
*/
/* Lista de  Usuarios*/
Route::get('tarea/lista-tareas','TasksController@index');
/* Crear Usuarios*/
Route::get('usuarios/crear-usuarios','UsersController@create');
/* ediar Usuarios*/
Route::get('usuarios/{id}/editar-usuarios','UsersController@edit');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);
