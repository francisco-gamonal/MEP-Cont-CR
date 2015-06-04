<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Grupos
 */
Route::get('catalogo/ver-catalogos', ['as' => 'ver-catalogos', 'uses' => 'CatalogsController@index']);
Route::get('catalogos/registrar-catalogos', ['as' => 'registrar-catalogo', 'uses' => 'CatalogsController@create']);
Route::post('catalogos/save-catalogos', 'CatalogsController@store');
Route::get('catalogos/editar-catalogos/{token}', ['as' => 'edit-catalog', 'uses' => 'CatalogsController@edit']);
Route::delete('catalogos/delete-catalogos/{code}', ['as' => 'delete-catalogo', 'uses' => 'CatalogsController@destroy']);
Route::patch('catalogos/active-catalogos/{code}', ['as' => 'active-catalogo', 'uses' => 'CatalogsController@active']);
Route::put('catalogos/update-catalogos', 'CatalogsController@update');
/*
 * Fin Rutas Menu
*/
