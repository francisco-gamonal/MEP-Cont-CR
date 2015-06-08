<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('tipos-de-usuarios/ver-tipos-de-usuarios', ['as' => 'ver-tipos-de-usuarios', 'uses' => 'TypeUsersController@index']);
Route::get('tipos-de-usuarios/crear-tipos-de-usuarios', ['as' => 'crear-tipos-de-usuarios', 'uses' => 'TypeUsersController@create']);
Route::post('tipos-de-usuarios/save-tipos-de-usuarios', 'TypeUsersController@store');
Route::get('tipos-de-usuarios/editar-tipos-de-usuarios/{id}', ['as' => 'editar-tipos-de-usuarios', 'uses' => 'TypeUsersController@edit']);
Route::delete('tipos-de-usuarios/delete-tipos-de-usuarios/{id}', ['as' => 'delete-tipo-de-usuario', 'uses' => 'TypeUsersController@destroy']);
Route::patch('tipos-de-usuarios/active-tipos-de-usuarios/{id}', ['as' => 'active-tipo-de-usuario', 'uses' => 'TypeUsersController@active']);
Route::put('tipos-de-usuarios/update-tipos-de-usuarios/{id}', 'TypeUsersController@update');
/*
 * Fin Rutas de Tipos de Usuarios
 */
