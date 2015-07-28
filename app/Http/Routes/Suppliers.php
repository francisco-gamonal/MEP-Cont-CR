<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * Rutas de Proveedores
 */
Route::get('proveedores/ver', ['as' => 'ver-proveedores', 'uses' => 'SupplierController@index']);
Route::get('proveedores/crear', ['as' => 'crear-proveedores', 'uses' => 'SupplierController@create']);
Route::post('proveedores/save', 'SupplierController@store');
Route::get('proveedores/editar/{token}', ['as' => 'editar-proveedores', 'uses' => 'SupplierController@edit']);
Route::delete('proveedores/delete/{token}', ['as' => 'delete-proveedor', 'uses' => 'SupplierController@destroy']);
Route::patch('proveedores/active/{token}', ['as' => 'active-proveedor', 'uses' => 'SupplierController@active']);
Route::put('proveedores/update/{token}', 'SupplierController@update');
/*
 * Fin Rutas de Proveedores
 */
