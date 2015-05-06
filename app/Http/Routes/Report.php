<?php
/**
 *  Routes Empleados
 */
Route::get('reporte/presupuesto', ['as' => 'reporte-presupuesto', 'uses' => 'ReportController@index']);
Route::get('reporte/presupuesto/excel/{token}', ['as' => 'reporte-presupuesto-excel', 'uses' => 'ExcelController@budgetInicialExcel']);
Route::get('reporte/presupuesto/excel/ordinario', ['as' => 'reporte-presupuesto-ordinario-excel', 'uses' => 'ExcelController@budgetGeneralExcel']);