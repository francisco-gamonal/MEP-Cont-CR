<?php namespace Mep\Http\Routes;


use Illuminate\Support\Facades\Route;


/**
 *  Rutas de Grupos
 */
Route::get('grupos','GroupsController@index');
Route::get('grupos/ver-grupos-de-cuentas',['as'=> 'ver-grupos', 'uses' => 'GroupsController@index']);
Route::get('grupos/crear-grupos-de-cuentas',['as'=>'registrar-grupo','uses'=>'GroupsController@create']);
Route::post('grupos/save-grupos','GroupsController@store');
Route::get('grupos/editar-grupo/{token}', ['as' => 'edit-group', 'uses' =>'GroupsController@edit']);
Route::delete('grupos/delete-grupos/{code}',['as' => 'delete-grupo', 'uses' => 'GroupsController@destroy']);
Route::patch('grupos/active-grupos/{code}',['as' => 'active-grupo', 'uses' => 'GroupsController@active']);
Route::put('grupos/update-grupos','GroupsController@update');
/**
 * Fin Rutas Menu
*/