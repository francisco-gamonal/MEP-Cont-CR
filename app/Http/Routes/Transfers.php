<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Transferencias
 */
Route::get('transferencias/ver-transferencias', ['as' => 'ver-transferencias', 'uses' => 'TransfersController@index']);
Route::get('transferencias/registrar-transferencia', ['as' => 'registrar-transferencia', 'uses' => 'TransfersController@create']);
Route::post('transferencias/save-transferencias', 'TransfersController@store');
Route::get('transferencias/ver-transferencia/{token}', ['as' => 'view-transferencia', 'uses' => 'TransfersController@view']);
Route::get('transferencias/editar-transferencia/{token}', ['as' => 'edit-transferencia', 'uses' => 'TransfersController@edit']);
Route::delete('transferencias/delete-transferencias/{token}', ['as' => 'delete-transferencia', 'uses' => 'TransfersController@destroy']);
Route::patch('transferencias/active-transferencias/{token}', ['as' => 'active-transferencia', 'uses' => 'TransfersController@active']);
Route::put('transferencias/update-transferencias', 'TransfersController@update');
Route::get('transferencias/reporte/{token}', ['as' => 'reporte-transferencias', 'uses' => 'TransfersController@report']);
/*
 * Fin Rutas Transferencias
 */
