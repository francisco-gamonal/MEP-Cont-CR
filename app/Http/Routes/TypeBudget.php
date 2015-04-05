<?php namespace Mep\Http\Routes;



use Illuminate\Support\Facades\Route;

/**
 * Rutas de Tipos de Usuarios
 */
Route::get('tipos-de-presupuestos','TypesBudgetsController@index');
Route::get('tipos-de-presupuestos/ver-tipos-de-presupuestos',['as'=>'ver-tipos-de-presupuestos','uses'=>'TypesBudgetsController@index']);
Route::get('tipos-de-presupuestos/registrar-tipo-de-presupuesto','TypesBudgetsController@create');
Route::post('tipos-de-presupuestos/save-tipos-de-presupuestos','TypesBudgetsController@store');
Route::get('tipos-de-presupuestos/editar-tipo-de-presupuesto/{token}',['as'=>'edit-tipo-de-presupuesto','uses'=>'TypesBudgetsController@edit']);
Route::delete('tipos-de-presupuestos/delete-tipos-de-usuarios/{token}',['as'=>'delete-tipo-de-presupuesto','uses'=>'TypesBudgetsController@destroy']);
Route::patch('tipos-de-presupuestos/active-tipos-de-usuarios/{token}',['as' => 'active-tipo-de-presupuesto', 'uses' => 'TypesBudgetsController@active']);
Route::put('tipos-de-presupuestos/update-tipos-de-usuarios/{token}','TypesBudgetsController@update');
/**
 * Fin Rutas de Tipos de Usuarios
 */