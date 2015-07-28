<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Grupos
 */
Route::get('catalogo/ver', ['as' => 'ver-catalogos', 'uses' => 'CatalogsController@index']);
Route::get('catalogo/crear', ['as' => 'crear-catalogos', 'uses' => 'CatalogsController@create']);
Route::post('catalogo/save', 'CatalogsController@store');
Route::get('catalogo/editar/{token}', ['as' => 'editar-catalogos', 'uses' => 'CatalogsController@edit']);
Route::delete('catalogo/delete/{code}', ['as' => 'delete-catalogo', 'uses' => 'CatalogsController@destroy']);
Route::patch('catalogo/active/{code}', ['as' => 'active-catalogo', 'uses' => 'CatalogsController@active']);
Route::put('catalogo/update', 'CatalogsController@update');
/*
 * Fin Rutas Menu
*/
