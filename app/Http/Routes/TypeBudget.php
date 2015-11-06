<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('programas/ver', ['as' => 'ver-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@index']);
Route::get('programas/crear', ['as' => 'crear-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@create']);
Route::post('programas/save', 'TypeBudgetsController@store');
Route::get('programas/editar/{token}', ['as' => 'editar-tipos-de-presupuestos', 'uses' => 'TypeBudgetsController@edit']);
Route::delete('programas/delete/{token}', ['as' => 'delete-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@destroy']);
Route::patch('programas/active/{token}', ['as' => 'active-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@active']);
Route::put('programas/update', 'TypeBudgetsController@update');
/*
 * Fin Rutas de Tipos de Usuarios
 */
