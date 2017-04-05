<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('cheques/ver', ['as' => 'ver-cheques', 'uses' => 'ChecksController@index']);
Route::post('cheques/ver', ['as' => 'search-cheques', 'uses' => 'ChecksController@search']);
Route::get('cheques/plailla/crear/{token}', ['as' => 'crear-cheques', 'uses' => 'ChecksController@create']);
Route::post('cheques/detalle', ['as' => 'detail-cheques', 'uses' => 'ChecksController@detail']);
Route::get('cheques/detalle/{token}', ['as' => 'detalle-cheques', 'uses' => 'ChecksController@invoices']);
Route::get('cheques/crear/{token}', 'ChecksController@budget');
Route::post('cheques/save', 'ChecksController@store');
Route::get('cheques/editar/{token}', ['as' => 'editar-cheques', 'uses' => 'ChecksController@edit']);
Route::delete('cheques/delete/{token}', ['as' => 'delete-cheque', 'uses' => 'ChecksController@destroy']);
Route::patch('cheques/active/{token}', ['as' => 'active-cheque', 'uses' => 'ChecksController@active']);
Route::put('cheques/update', 'ChecksController@update');

Route::get('cheques/cuentas-de-saldo-presupuesto', ['as' => 'cuentas-saldo-presupuesto', 'uses' => 'ChecksController@accountBalanceBudgets']);
/*
 * Fin Rutas de Tipos de Usuarios
 */
