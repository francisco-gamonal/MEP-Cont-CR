<?php
/**
 *  Routes Empleados
 */
Route::get('reporte/presupuesto', ['as' => 'reporte-presupuesto', 'uses' => 'ReportController@index']);
Route::get('reporte/presupuesto/excel/{token}', ['as' => 'reporte-presupuesto-excel', 'uses' => 'ExcelController@budgetInicialExcel']);
Route::get('reporte/planilla/excel/{token}', ['as' => 'reporte-planilla-excel', 'uses' => 'ExcelController@excelSpreadsheet']);
Route::get('reporte/transferencia/excel/{token}', ['as' => 'reporte-transfers-excel', 'uses' => 'ExcelController@excelTransfers']);
Route::get('reporte/ordinario/excel/{token}/{global}/{year}', ['as' => 'reporte-presupuesto-ordinario-excel', 'uses' => 'ExcelController@generalBudgetExcel']);
Route::get('reporte/saldo-de-presupuestos/excel/{token}',['as'=>'reporte-saldo-de-presupuestos-excel','uses'=>'ExcelController@excelPoa']);
Route::get('reporte/presupuestos/excel/{token}',['as'=>'reporte-presupuestos','uses'=>'ExcelController@excelPoaBudget']);