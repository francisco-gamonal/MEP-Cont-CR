<?php namespace Mep\Http\Routes;



use Illuminate\Support\Facades\Route;

/**
 * Rutas de Tipos de Usuarios
 */
Route::get('tipos-de-presupuestos','TypeBudgetsController@index');
Route::get('tipos-de-presupuestos/ver-tipos-de-presupuestos',['as'=>'ver-tipos-de-presupuestos','uses'=>'TypeBudgetsController@index']);
Route::get('tipos-de-presupuestos/registrar-tipo-de-presupuesto','TypeBudgetsController@create');
Route::post('tipos-de-presupuestos/save-tipos-de-presupuestos','TypeBudgetsController@store');
Route::get('tipos-de-presupuestos/editar-tipo-de-presupuesto/{token}',['as'=>'edit-tipo-de-presupuesto','uses'=>'TypeBudgetsController@edit']);
Route::delete('tipos-de-presupuestos/delete-tipos-de-presupuesto/{token}',['as'=>'delete-tipo-de-presupuesto','uses'=>'TypeBudgetsController@destroy']);
Route::patch('tipos-de-presupuestos/active-tipos-de-presupuesto/{token}',['as' => 'active-tipo-de-presupuesto', 'uses' => 'TypeBudgetsController@active']);
Route::put('tipos-de-presupuestos/update-tipos-de-usuarios/{token}','TypeBudgetsController@update');
/**
 * Fin Rutas de Tipos de Usuarios
 */