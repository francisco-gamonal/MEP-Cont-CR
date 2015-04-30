<?php
/**
 *  Routes Empleados
 */
Route::get('reporte/presupuesto', ['as' => 'reporte-presupuesto', 'uses' => 'ReportController@index']);
Route::get('reporte/presupuesto/excel', ['as' => 'reporte-presupuesto-excel', 'uses' => 'ReportController@budgetExcel']);