<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

Route::get('depositos/ver', ['as' => 'ver-depositos', 'uses' => 'DepositsController@index']);
Route::get('depositos/crear', ['as' => 'crear-depositos', 'uses' => 'DepositsController@create']);
Route::post('depositos/save', 'DepositsController@store');
Route::get('depositos/editar/{token}', ['as' => 'editar-depositos', 'uses' => 'DepositsController@edit']);
Route::delete('depositos/delete/{token}', ['as' => 'delete-presupuesto', 'uses' => 'DepositsController@destroy']);
//Route::patch('depositos/active/{token}', ['as' => 'active-presupuesto', 'uses' => 'DepositsController@active']);
Route::post('depositos/update', 'DepositsController@update');
