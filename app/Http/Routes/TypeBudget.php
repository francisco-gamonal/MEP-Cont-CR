<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('tipos-de-presupuestos/ver', ['as' => 'ver-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@index']);
Route::get('tipos-de-presupuestos/crear', ['as' => 'crear-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@create']);
Route::post('tipos-de-presupuestos/save', 'TypeBudgetsController@store');
Route::get('tipos-de-presupuestos/editar/{token}', ['as' => 'editar-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@edit']);
Route::delete('tipos-de-presupuestos/delete/{token}', ['as' => 'delete-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@destroy']);
Route::patch('tipos-de-presupuestos/active/{token}', ['as' => 'active-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@active']);
Route::put('tipos-de-presupuestos/update', 'TypeBudgetsController@update');
/*
 * Fin Rutas de Tipos de Usuarios
 */
