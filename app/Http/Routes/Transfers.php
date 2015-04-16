<?php namespace Mep\Http\Routes;



use Illuminate\Support\Facades\Route;

/**
 * Rutas de Transferencias
 */
Route::get('transferencias','TransfersController@index');
Route::get('transferencias/ver-transferencias',['as'=>'ver-tipos-de-transferencias','uses'=>'TransfersController@index']);
Route::get('transferencias/registrar-transferencia','TransfersController@create');
Route::post('transferencias/save-transferencias','TransfersController@store');
Route::get('transferencias/ver-transferencia/{token}',['as'=>'view-transferencia','uses'=>'TransfersController@view']);
Route::get('transferencias/editar-transferencia/{token}',['as'=>'edit-transferencia','uses'=>'TransfersController@edit']);
Route::delete('transferencias/delete-transferencias/{token}',['as'=>'delete-transferencia','uses'=>'TransfersController@destroy']);
Route::patch('transferencias/active-transferencias/{token}',['as' => 'active-transferencia', 'uses' => 'TransfersController@active']);
Route::put('transferencias/update-transferencias','TransfersController@update');
/**
 * Fin Rutas Transferencias
 */