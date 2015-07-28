<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Tipos de Usuarios
 */
Route::get('presupuestos/ver', ['as' => 'ver-presupuestos', 'uses' => 'BudgetsController@index']);
Route::get('presupuestos/crear', ['as' => 'crear-presupuestos', 'uses' => 'BudgetsController@create']);
Route::post('presupuestos/save', 'BudgetsController@store');
Route::get('presupuestos/editar/{token}', ['as' => 'editar-presupuestos', 'uses' => 'BudgetsController@edit']);
Route::delete('presupuestos/delete/{token}', ['as' => 'delete-presupuesto', 'uses' => 'BudgetsController@destroy']);
Route::patch('presupuestos/active/{token}', ['as' => 'active-presupuesto', 'uses' => 'BudgetsController@active']);
Route::put('presupuestos/update/{token}', 'BudgetsController@update');

Route::get('presupuestos/reporte-global/{token}/{global}/{year}', ['as' => 'report-global-presupuestos', 'uses' => 'BudgetsController@globalReport']);
Route::get('presupuestos/reporte/{token}', ['as' => 'report-presupuestos', 'uses' => 'BudgetsController@report']);
Route::get('presupuestos/reporte/actual/{token}', ['as' => 'actual-presupuestos', 'uses' => 'BudgetsController@reportActual']);
Route::get('presupuestos/reporte-poa/{token}', ['as' => 'reporte-poa-presupuestos', 'uses' => 'BudgetsController@poaReport']);

//Route::get('presupuestos/validate-report-presupuestos/{token}', ['as' => 'validacion-presupuestos', 'uses' => 'BudgetsController@valitation']);
Route::get('presupuestos/validacion/{token}', ['as' => 'validacion-presupuestos', 'uses' => 'BudgetsController@valitation']);
/*
 * Fin Rutas de Tipos de Usuarios
 */
