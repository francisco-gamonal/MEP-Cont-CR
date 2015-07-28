<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('saldo-de-presupuestos/ver', ['as' => 'ver-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@index']);
Route::get('saldo-de-presupuestos/crear', ['as' => 'crear-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@create']);
Route::post('saldo-de-presupuestos/save', 'BalanceBudgetsController@store');
Route::get('saldo-de-presupuestos/editar/{token}', ['as' => 'editar-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@edit']);
Route::delete('saldo-de-presupuestos/delete/{token}', ['as' => 'delete-saldo-de-presupuesto', 'uses' => 'BalanceBudgetsController@destroy']);
Route::patch('saldo-de-presupuestos/active/{token}', ['as' => 'active-saldo-de-presupuesto', 'uses' => 'BalanceBudgetsController@active']);
Route::put('saldo-de-presupuestos/update', 'BalanceBudgetsController@update');
Route::get('saldo-de-presupuestos/reporte/{token}', ['as' => 'reporte-saldo-de-presupuestos', 'uses' => 'BalanceBudgetsController@report']);

/*
 * Fin Rutas de Tipos de Usuarios
 */
