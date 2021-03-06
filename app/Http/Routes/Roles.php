<?php

namespace Mep\Http\Routes;

use Illuminate\Support\Facades\Route;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/*
 *  Rutas de Privilegios
 */

Route::get('roles/ver',['as'=>'ver-roles','uses'=>'UsersController@indexRole']);
Route::get('roles/crear',['as'=>'crear-roles','uses'=>'UsersController@indexRole']);
Route::get('roles/editar/{id}',['as'=>'editar-roles','uses'=>'UsersController@editRole']);
Route::put('roles/update','UsersController@updateRole');

/**
 * Fin Rutas de Privilegios
*/
