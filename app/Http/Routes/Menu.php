<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Menu
 */
Route::get('menu/ver', ['as' => 'ver-menu', 'uses' => 'MenuController@index']);
Route::get('menu/crear', ['as' => 'crear-menu', 'uses' => 'MenuController@create']);
Route::post('menu/save-menu', 'MenuController@store');
Route::get('menu/editar-menu/{id}', ['as' => 'editar-menu', 'uses' => 'MenuController@edit']);
Route::delete('menu/delete-menu/{id}', ['as' => 'delete-menu', 'uses' => 'MenuController@destroy']);
Route::patch('menu/active-menu/{id}', ['as' => 'active-menu', 'uses' => 'MenuController@active']);
Route::put('menu/update-menu/{id}', 'MenuController@update');
/*
 * Fin Rutas Menu
*/
