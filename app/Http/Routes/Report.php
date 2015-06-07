<?php

/**
 *  Routes Empleados.
 */
Route::get('reporte/presupuesto', ['as' => 'reporte-presupuesto', 'uses' => 'ReportController@index']);
Route::get('reporte/presupuesto/excel/{token}', ['as' => 'reporte-presupuesto-excel', 'uses' => 'BudgetInitialController@budgetInicialExcel']);
Route::get('reporte/planilla/excel/{token}', ['as' => 'reporte-planilla-excel', 'uses' => 'SpreadseehtExcelController@excelSpreadsheet']);
Route::get('reporte/transferencia/excel/{token}', ['as' => 'reporte-transfers-excel', 'uses' => 'TransferExcelController@excelTransfers']);
Route::get('reporte/ordinario/excel/{token}/{global}/{year}', ['as' => 'reporte-presupuesto-ordinario-excel', 'uses' => 'BudgetGlobalController@generalBudgetExcel']);
Route::get('reporte/saldo-de-presupuestos/excel/{token}', ['as' => 'reporte-saldo-de-presupuestos-poa', 'uses' => 'BudgetPoaController@excelPoa']);
Route::get('reporte/presupuestos/excel/{token}', ['as' => 'reporte-presupuestos', 'uses' => 'BudgetPoaController@excelPoaBudget']);
