<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Grupos
 */
Route::get('grupos-de-cuentas/ver-grupos-de-cuentas', ['as' => 'ver-grupos-de-cuentas', 'uses' => 'GroupsController@index']);
Route::get('grupos-de-cuentas/crear-grupos-de-cuentas', ['as' => 'crear-grupos-de-cuentas', 'uses' => 'GroupsController@create']);
Route::post('grupos-de-cuentas/save-grupos-de-cuentas', 'GroupsController@store');
Route::get('grupos-de-cuentas/editar-grupos-de-cuentas/{token}', ['as' => 'editar-grupos-de-cuentas', 'uses' => 'GroupsController@edit']);
Route::delete('grupos-de-cuentas/delete-grupos-de-cuentas/{code}', ['as' => 'delete-grupos-de-cuentas', 'uses' => 'GroupsController@destroy']);
Route::patch('grupos-de-cuentas/active-grupos-de-cuentas/{code}', ['as' => 'active-grupos-de-cuentas', 'uses' => 'GroupsController@active']);
Route::put('grupos-de-cuentas/update-grupos-de-cuentas', 'GroupsController@update');
/*
 * Fin Rutas Menu
*/
