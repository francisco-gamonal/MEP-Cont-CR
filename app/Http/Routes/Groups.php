<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Grupos
 */
Route::get('grupos-de-cuentas/ver', ['as' => 'ver-grupos-de-cuentas', 'uses' => 'GroupsController@index']);
Route::get('grupos-de-cuentas/crear', ['as' => 'crear-grupos-de-cuentas', 'uses' => 'GroupsController@create']);
Route::post('grupos-de-cuentas/save', 'GroupsController@store');
Route::get('grupos-de-cuentas/editar/{token}', ['as' => 'editar-grupos-de-cuentas', 'uses' => 'GroupsController@edit']);
Route::delete('grupos-de-cuentas/delete/{code}', ['as' => 'delete-grupos-de-cuentas', 'uses' => 'GroupsController@destroy']);
Route::patch('grupos-de-cuentas/active/{code}', ['as' => 'active-grupos-de-cuentas', 'uses' => 'GroupsController@active']);
Route::put('grupos-de-cuentas/update', 'GroupsController@update');
/*
 * Fin Rutas Menu
*/
