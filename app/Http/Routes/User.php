<?php namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;
/**
 *  Rutas de usuarios
 */
Route::get('usuarios','UsersController@index');
Route::get('usuarios/ver-usuarios',['as'=>'ver-usuarios','uses'=>'UsersController@index']);
Route::get('usuarios/crear-usuarios',['as'=>'registrar-usuario', 'uses'=>'UsersController@create']);
Route::post('usuarios/save-usuarios','UsersController@store');
Route::get('usuarios/editar-usuarios/{id}',['as'=>'edit-usuario','uses'=>'UsersController@edit']);
Route::delete('usuarios/delete-usuarios/{id}',['as'=>'delete-usuario','uses'=>'UsersController@destroy']);
Route::patch('usuarios/active-usuarios/{id}',['as' => 'active-usuario', 'uses' => 'UsersController@active']);
Route::put('usuarios/update-usuarios/{id}','UsersController@update');
/**
 * Fin Rutas de Usuarios
 */
