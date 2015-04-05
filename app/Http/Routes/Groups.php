<?php namespace Mep\Http\Routes;


use Illuminate\Support\Facades\Route;


/**
 *  Rutas de Menu
 */
Route::get('grupos','GroupsController@index');
Route::get('grupos/ver-grupos',['as'=> 'ver-grupos', 'uses' => 'GroupsController@index']);
Route::get('grupos/registrar-grupos','GroupsController@create');
Route::post('grupos/save-grupos','GroupsController@store');
Route::get('grupos/editar-grupos/{id}', ['as' => 'edit-grupos', 'uses' =>'GroupsController@edit']);
Route::delete('grupos/delete-grupos/{id}',['as' => 'delete-grupos', 'uses' => 'GroupsController@destroy']);
Route::patch('grupos/active-menu/{id}',['as' => 'active-grupos', 'uses' => 'GroupsController@active']);
Route::put('grupos/update-grupos/{id}','GroupsController@update');
/**
 * Fin Rutas Menu
*/