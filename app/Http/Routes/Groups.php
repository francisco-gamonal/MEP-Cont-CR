<?php namespace Mep\Http\Routes;


use Illuminate\Support\Facades\Route;


/**
 *  Rutas de Grupos
 */
Route::get('grupos','GroupsController@index');
Route::get('grupos/ver-grupos',['as'=> 'ver-grupos', 'uses' => 'GroupsController@index']);
Route::get('grupos/registrar-grupo','GroupsController@create');
Route::post('grupos/save-grupos','GroupsController@store');
Route::get('grupos/editar-grupo/{token}', ['as' => 'edit-grupo', 'uses' =>'GroupsController@edit']);
Route::delete('grupos/delete-grupos/{code}',['as' => 'delete-grupo', 'uses' => 'GroupsController@destroy']);
Route::patch('grupos/active-grupos/{code}',['as' => 'active-grupo', 'uses' => 'GroupsController@active']);
Route::put('grupos/update-grupos/{code}','GroupsController@update');
/**
 * Fin Rutas Menu
*/