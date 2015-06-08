<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('saldo-de-presupuestos/ver-saldo-de-presupuestos', ['as' => 'ver-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@index']);
Route::get('saldo-de-presupuestos/crear-saldo-de-presupuestos', ['as' => 'crear-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@create']);
Route::post('saldo-de-presupuestos/save-saldo-de-presupuestos', 'BalanceBudgetsController@store');
Route::get('saldo-de-presupuestos/editar-saldo-de-presupuestos/{token}', ['as' => 'editar-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@edit']);
Route::delete('saldo-de-presupuestos/delete-saldo-de-presupuestos/{token}', ['as' => 'delete-saldo-de-presupuesto', 'uses' => 'BalanceBudgetsController@destroy']);
Route::patch('saldo-de-presupuestos/active-saldo-de-presupuestos/{token}', ['as' => 'active-saldo-de-presupuesto', 'uses' => 'BalanceBudgetsController@active']);
Route::put('saldo-de-presupuestos/update-saldo-de-presupuestos', 'BalanceBudgetsController@update');
Route::get('saldo-de-presupuestos/reporte/{token}', ['as' => 'reporte-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@report']);

/*
 * Fin Rutas de Tipos de Usuarios
 */
