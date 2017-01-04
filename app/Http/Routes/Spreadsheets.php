<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('planillas/ver', ['as' => 'ver-planillas', 'uses' => 'SpreadsheetsController@index']);
Route::get('planillas/ver-anteriores', ['as' => 'ver-planillas', 'uses' => 'SpreadsheetsController@after']);
Route::get('planillas/crear', ['as' => 'crear-planillas', 'uses' => 'SpreadsheetsController@create']);
Route::post('planillas/save', 'SpreadsheetsController@store');
Route::get('planillas/editar/{token}', ['as' => 'editar-planillas', 'uses' => 'SpreadsheetsController@edit']);
Route::delete('planillas/delete/{token}', ['as' => 'delete-planilla', 'uses' => 'SpreadsheetsController@destroy']);
Route::patch('planillas/active/{token}', ['as' => 'active-planilla', 'uses' => 'SpreadsheetsController@active']);
Route::put('planillas/update', 'SpreadsheetsController@update');

Route::get('planillas/reporte/{token}', ['as' => 'report-planilla', 'uses' => 'SpreadsheetsController@report']);
/*
 * Fin Rutas de Tipos de Usuarios
 */
