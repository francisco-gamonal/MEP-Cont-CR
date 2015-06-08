<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('tipos-de-presupuestos/ver-tipos-de-presupuestos', ['as' => 'ver-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@index']);
Route::get('tipos-de-presupuestos/crear-tipos-de-presupuestos', ['as' => 'crear-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@create']);
Route::post('tipos-de-presupuestos/save-tipos-de-presupuestos', 'TypeBudgetsController@store');
Route::get('tipos-de-presupuestos/editar-tipos-de-presupuestos/{token}', ['as' => 'editar-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@edit']);
Route::delete('tipos-de-presupuestos/delete-tipos-de-presupuestos/{token}', ['as' => 'delete-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@destroy']);
Route::patch('tipos-de-presupuestos/active-tipos-de-presupuestos/{token}', ['as' => 'active-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@active']);
Route::put('tipos-de-presupuestos/update-tipos-de-presupuestos', 'TypeBudgetsController@update');
/*
 * Fin Rutas de Tipos de Usuarios
 */
