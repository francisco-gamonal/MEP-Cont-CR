<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('planillas/ver-planillas', ['as' => 'ver-planillas', 'uses' => 'SpreadsheetsController@index']);
Route::get('planillas/crear-planillas', ['as' => 'crear-planillas', 'uses' => 'SpreadsheetsController@create']);
Route::post('planillas/save-planillas', 'SpreadsheetsController@store');
Route::get('planillas/editar-planillas/{token}', ['as' => 'editar-planillas', 'uses' => 'SpreadsheetsController@edit']);
Route::delete('planillas/delete-planillas/{token}', ['as' => 'delete-planilla', 'uses' => 'SpreadsheetsController@destroy']);
Route::patch('planillas/active-planillas/{token}', ['as' => 'active-planilla', 'uses' => 'SpreadsheetsController@active']);
Route::put('planillas/update-planillas', 'SpreadsheetsController@update');

Route::get('planillas/reporte/{token}', ['as' => 'report-planilla', 'uses' => 'SpreadsheetsController@report']);
/*
 * Fin Rutas de Tipos de Usuarios
 */
