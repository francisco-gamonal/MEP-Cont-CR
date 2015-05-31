<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 *  Rutas de Instituciones
 */
Route::get('institucion', 'SchoolsController@index');
Route::get('institucion/ver-institucion', ['as' => 'ver-institucion', 'uses' => 'SchoolsController@index']);
Route::get('institucion/registrar-institucion', ['as' => 'registrar-institucion', 'uses' => 'SchoolsController@create']);
Route::post('institucion/save-institucion', 'SchoolsController@store');
Route::get('institucion/editar-institucion/{id}', ['as' => 'edit-school', 'uses' => 'SchoolsController@edit']);
Route::delete('institucion/delete-institucion/{id}', ['as' => 'delete-school', 'uses' => 'SchoolsController@destroy']);
Route::patch('institucion/active-institucion/{id}', ['as' => 'active-school', 'uses' => 'SchoolsController@active']);
Route::put('institucion/update-institucion/{id}', 'SchoolsController@update');
/*
 * Fin Rutas de Instituciones
*/
