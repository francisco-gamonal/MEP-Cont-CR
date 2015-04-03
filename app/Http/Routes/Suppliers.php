<?php namespace Mep\Http\Routes;


use Illuminate\Support\Facades\Route;

/**
 * Rutas de Proveedores
 */
//Route::get('tipo-de-usuarios','SupplierController@index');
Route::get('proveedores/ver-proveedores',['as'=>'ver-proveedores','uses'=>'SupplierController@index']);
Route::get('proveedores/registrar-proveedor','SupplierController@create');
Route::post('proveedores/save-proveedores','SupplierController@store');
Route::get('proveedores/editar-proveedor/{token}',['as'=>'edit-proveedor','uses'=>'SupplierController@edit']);
Route::delete('proveedores/delete-proveedores/{token}',['as'=>'delete-proveedor','uses'=>'SupplierController@destroy']);
Route::patch('proveedores/active-proveedores/{token}',['as' => 'active-proveedor', 'uses' => 'SupplierController@active']);
Route::put('proveedores/update-proveedores/{token}','SupplierController@update');
/**
 * Fin Rutas de Proveedores
 */