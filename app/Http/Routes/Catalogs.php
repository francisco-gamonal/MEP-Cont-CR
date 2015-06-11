<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Grupos
 */
Route::get('catalogo/ver-catalogo', ['as' => 'ver-catalogos', 'uses' => 'CatalogsController@index']);
Route::get('catalogo/crear-catalogo', ['as' => 'crear-catalogos', 'uses' => 'CatalogsController@create']);
Route::post('catalogo/save-catalogo', 'CatalogsController@store');
Route::get('catalogo/editar-catalogo/{token}', ['as' => 'editar-catalogos', 'uses' => 'CatalogsController@edit']);
Route::delete('catalogo/delete-catalogo/{code}', ['as' => 'delete-catalogo', 'uses' => 'CatalogsController@destroy']);
Route::patch('catalogo/active-catalogo/{code}', ['as' => 'active-catalogo', 'uses' => 'CatalogsController@active']);
Route::put('catalogo/update-catalogo', 'CatalogsController@update');
/*
 * Fin Rutas Menu
*/
