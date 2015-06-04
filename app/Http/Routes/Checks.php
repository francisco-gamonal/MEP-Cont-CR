<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('cheques/ver-chequess', ['as' => 'ver-cheques', 'uses' => 'ChecksController@index']);
Route::get('cheques/registrar-cheques', ['as' => 'registrar-cheque', 'uses' => 'ChecksController@create']);
Route::get('cheques/registrar-cheque/{token}', 'ChecksController@budget');
Route::post('cheques/save-cheques', 'ChecksController@store');
Route::get('cheques/editar-cheques/{token}', ['as' => 'edit-cheque', 'uses' => 'ChecksController@edit']);
Route::delete('cheques/delete-cheques/{token}', ['as' => 'delete-cheque', 'uses' => 'ChecksController@destroy']);
Route::patch('cheques/active-cheques/{token}', ['as' => 'active-cheque', 'uses' => 'ChecksController@active']);
Route::put('cheques/update-cheques', 'ChecksController@update');
Route::get('cheques/cuentas-de-saldo-presupuesto', ['as' => 'cuentas-saldo-presupuesto', 'uses' => 'ChecksController@accountBalanceBudgets']);
/*
 * Fin Rutas de Tipos de Usuarios
 */
