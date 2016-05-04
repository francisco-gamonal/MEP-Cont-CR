<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('auth.login');
});

/* Log */
Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

/* Rutas del login*/
Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/* Test para hacer pruebas */
Route::get('test', 'TestController@index');

/* Lista de  Usuarios */
Route::get('/inicio', ['as' => 'home', 'uses' => 'HomeController@index']);

//si el usuario ha iniciado sesión dar acceso a las rutas
require __DIR__.'/Routes/User.php';
require __DIR__.'/Routes/Menu.php';
require __DIR__.'/Routes/Schools.php';
require __DIR__.'/Routes/Roles.php';
require __DIR__.'/Routes/TypeUser.php';
//require (__DIR__ . '/Routes/Task.php');

Route::group(['prefix' => 'institucion'], function () {

    Route::get('/', 'SchoolsController@listSchools');
    /* Test para hacer pruebas */

    Route::group(['prefix' =>  'inst', 'middleware'=> 'userSchool'], function () {

        Route::get('/', ['as' => 'dashboard', function () {  return view('home'); }]);
        
        Route::get('test', 'TestController@index');

        require __DIR__.'/Routes/Groups.php';
        require __DIR__.'/Routes/TypeBudget.php';
        require __DIR__.'/Routes/Catalogs.php';
        require __DIR__.'/Routes/Suppliers.php';
        require __DIR__.'/Routes/Budgets.php';
        require __DIR__.'/Routes/BalanceBudgets.php';
        require __DIR__.'/Routes/Spreadsheets.php';
        require __DIR__.'/Routes/Checks.php';
        require __DIR__.'/Routes/Transfers.php';
        require __DIR__.'/Routes/Report.php';
        require __DIR__.'/Routes/BankAccounts.php';
        require __DIR__.'/Routes/Deposits.php';

    });

});

Route::post('route-institucion', 'SchoolsController@routeUser');