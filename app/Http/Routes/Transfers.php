<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Transferencias
 */
Route::get('transferencias/ver-transferencias', ['as' => 'ver-transferencias', 'uses' => 'TransfersController@index']);
Route::get('transferencias/crear-transferencias', ['as' => 'crear-transferencias', 'uses' => 'TransfersController@create']);
Route::post('transferencias/save-transferencias', 'TransfersController@store');
Route::get('transferencias/ver-transferencias/{token}', ['as' => 'ver-detalle-transferencias', 'uses' => 'TransfersController@view']);
Route::get('transferencias/editar-transferencias/{token}', ['as' => 'editar-transferencias', 'uses' => 'TransfersController@edit']);
Route::delete('transferencias/delete-transferencias/{token}', ['as' => 'delete-transferencia', 'uses' => 'TransfersController@destroy']);
Route::put('transferencias/update-transferencias', 'TransfersController@update');

Route::get('transferencias/reporte/{token}', ['as' => 'reporte-transferencias', 'uses' => 'TransfersController@report']);
/*
 * Fin Rutas Transferencias
 */
