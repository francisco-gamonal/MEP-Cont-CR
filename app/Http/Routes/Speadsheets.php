<?php namespace Mep\Http\Routes;



use Illuminate\Support\Facades\Route;

/**
 * Rutas de Tipos de Usuarios
 */
Route::get('planillas','SpreadsheetsController@index');
Route::get('planillas/ver-planillas',['as'=>'ver-planillas','uses'=>'SpreadsheetsController@index']);
Route::get('planillas/registrar-planilla','SpreadsheetsController@create');
Route::post('planillas/save-planilla','SpreadsheetsController@store');
Route::get('planillas/editar-planilla/{token}',['as'=>'edit-planilla','uses'=>'SpreadsheetsController@edit']);
Route::delete('planillas/delete-planilla/{token}',['as'=>'delete-planilla','uses'=>'SpreadsheetsController@destroy']);
Route::patch('planillas/active-planilla/{token}',['as' => 'active-planilla', 'uses' => 'SpreadsheetsController@active']);
Route::put('planillas/update-planillas','SpreadsheetsController@update');
/**
 * Fin Rutas de Tipos de Usuarios
 */