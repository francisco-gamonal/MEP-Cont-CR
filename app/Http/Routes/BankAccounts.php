<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

Route::get('cuentas-bancarias/ver', ['as' => 'ver-cuentas-bancarias', 'uses' => 'BankAccountsController@index']);
Route::get('cuentas-bancarias/crear', ['as' => 'crear-cuentas-bancarias', 'uses' => 'BankAccountsController@create']);
Route::post('cuentas-bancarias/save', 'BankAccountsController@store');
Route::get('cuentas-bancarias/editar/{token}', ['as' => 'editar-cuentas-bancarias', 'uses' => 'BankAccountsController@edit']);
Route::delete('cuentas-bancarias/delete/{token}', ['as' => 'delete-presupuesto', 'uses' => 'BankAccountsController@destroy']);
//Route::patch('cuentas-bancarias/active/{token}', ['as' => 'active-presupuesto', 'uses' => 'BankAccountsController@active']);
Route::put('cuentas-bancarias/update', 'BankAccountsController@update');
