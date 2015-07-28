<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Transferencias
 */
Route::get('transferencias/ver', ['as' => 'ver-transferencias', 'uses' => 'TransfersController@index']);
Route::get('transferencias/crear', ['as' => 'crear-transferencias', 'uses' => 'TransfersController@create']);
Route::post('transferencias/save', 'TransfersController@store');
Route::get('transferencias/ver/{token}', ['as' => 'ver-detalle-transferencia', 'uses' => 'TransfersController@view']);
Route::get('transferencias/editar/{token}', ['as' => 'editar-transferencias', 'uses' => 'TransfersController@edit']);
Route::delete('transferencias/delete/{token}', ['as' => 'delete-transferencia', 'uses' => 'TransfersController@destroy']);
Route::put('transferencias/update', 'TransfersController@update');

Route::get('transferencias/reporte/{token}', ['as' => 'reporte-transferencias', 'uses' => 'TransfersController@report']);
/*
 * Fin Rutas Transferencias
 */
