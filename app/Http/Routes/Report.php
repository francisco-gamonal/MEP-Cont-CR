<?php

/**
 *  Routes Empleados.
 */
Route::get('reporte/presupuesto/actual-excel/{token}', ['as' => 'reporte-presupuesto-actual', 'uses' => 'Report\BudgetActualController@budgetPeriodExcel']);
Route::get('reporte/presupuesto/excel/{token}', ['as' => 'reporte-presupuesto-excel', 'uses' => 'Report\BudgetInitialController@budgetInicialExcel']);
Route::get('reporte/planilla/excel/{token}', ['as' => 'reporte-planilla-excel', 'uses' => 'Report\SpreadseehtExcelController@excelSpreadsheet']);
Route::get('reporte/transferencia/excel/{token}', ['as' => 'reporte-transfers-excel', 'uses' => 'Report\TransferExcelController@excelTransfers']);
Route::get('reporte/ordinario/excel/{token}/{global}/{year}', ['as' => 'reporte-presupuesto-ordinario-excel', 'uses' => 'Report\BudgetGlobalController@generalBudgetExcel']);
Route::get('reporte/saldo-de-presupuestos/excel/{token}', ['as' => 'reporte-saldo-de-presupuestos-poa', 'uses' => 'Report\BudgetPoaController@excelPoa']);
Route::get('reporte/presupuestos/excel/{token}', ['as' => 'reporte-presupuestos', 'uses' => 'Report\BudgetPoaController@excelPoaBudget']);
