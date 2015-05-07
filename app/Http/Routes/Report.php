<?php
/**
 *  Routes Empleados
 */
Route::get('reporte/presupuesto', ['as' => 'reporte-presupuesto', 'uses' => 'ReportController@index']);
Route::get('reporte/presupuesto/excel/{token}', ['as' => 'reporte-presupuesto-excel', 'uses' => 'ExcelController@budgetInicialExcel']);
Route::get('reporte/planilla/excel', ['as' => 'reporte-planilla-excel', 'uses' => 'ExcelController@excelSpreadsheet']);
Route::get('reporte/ordinario/excel', ['as' => 'reporte-presupuesto-ordinario-excel', 'uses' => 'ExcelController@generalBudgetExcel']);