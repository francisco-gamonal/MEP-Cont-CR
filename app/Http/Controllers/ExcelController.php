<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mep\Models\Budget;
use Mep\Models\BalanceBudget;
use Mep\Models\Catalog;
use Mep\Models\Spreadsheet;
use Mep\Models\Check;
use Mep\Models\School;
class ExcelController extends Controller {

    /**
     * **************************************inicio Excel de cuadro planilla *************************************
     */
    public function excelSpreadsheet() {
        $spreadsheet = Spreadsheet::find(2);
        $spreadsheets = $this->CreateArraySpreadsheet($spreadsheet);
        Excel::create('Planilla-', function($excel) use ($spreadsheets) {
            $excel->sheet('Cuadro Planilla-', function($sheet) use ( $spreadsheets) {
                $sheet->mergeCells('B1:M1');
                $sheet->mergeCells('B2:M2');
                $sheet->mergeCells('B3:M3');
                $sheet->mergeCells('B5:I5');
                $sheet->mergeCells('B6:I6');
                $sheet->mergeCells('B7:I7');
                $sheet->mergeCells('B8:I8');
                $sheet->mergeCells('B9:I9');
                $sheet->mergeCells('B10:I10');
                $sheet->mergeCells('J6:M10');
                $sheet->mergeCells('B11:C12');
                $sheet->mergeCells('D11:I12');
                $sheet->mergeCells('J11:K12');   
                $sheet->cells('B1:M5', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('B6:I10', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('J6:M10', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('B11:M13', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->setBorder('B11:K12','thin');
                $sheet->setBorder('B13:M13','thin');
                $sheet->fromArray($spreadsheets, null, 'B1', true, false);
            });
        })->export('xls');
    }

    private function CreateArraySpreadsheet($spreadsheet) {
        
        $spreadsheets = $this->headerSpreadsheet($spreadsheet);
        $spreadsheets[] = $this->contentSpreadsheet($spreadsheet);
        return $spreadsheets;
    }
    private function contentSpreadsheet($spreadsheet){
       $checks = Check::where('spreadsheets_id', $spreadsheet->id)->get();
        
            foreach ($checks AS $check):
                 $content[]= ($check->balanceBudgets->catalogs->codeCuenta());
            endforeach;
       
           
       return  $content;
    }

    private function headerSpreadsheet($spreadsheet) {
        $header = array(
            array('MINISTERIO DE EDUCACION PUBLICA'),
            array('DIRECCION REGIONAL DE EDUCACION DE AGUIRRE'),
            array('OFICINA DE JUNTAS DE EDUCACION Y ADMINISTRATIVAS'),
            array(''),
            array('FORMULARIO F-4 LISTA DE PAGOS A REALIZAR'),
            array('PLANILLA DE PAGO N. 71- 2011  FECHA  28  de Diciembre   del 2011','','','','','','','','PROGRAMA:       Ley 6746'),
            array('Junta: Administrativa CTP de Matapalo'),
            array('Cédula Jurídica 3-008-056599'),
            array(''),
            array(''),
            array('Información presupuestaria','','Información del pago','','','','','','# Cheques',''),
            array(''),
            array('Codigo','Saldo presupuestario','# Factura','Nombre del Proveedor','Concepto','Monto','Retención','Monto a Cancelar','Pago ck','Retención','Acta N. / Acuerdo N.','Saldo Presupuestario Final'),
            array('')
            
        );
        return $header;
    }

    /**
     * **************************************Final Excel de cuadro planilla *************************************
     */
    /**
     * ***************** Inicia el codigo para el archivo de Excel por periodo para el presupuesto **********************
     */

    /**
     * Con este methodo unimos dos los datos finales
     * para generar el archivo de excel
     * con la libreria de Maatwebsite
     * Show the form for creating a new resource.
     * @return Response
     */
    public function budgetPeriodExcel() {
        $budget = Budget::find(1);
        $school = $budget->schools;
        /** Con esta variable obtendremos el numero de filas de los egresos
         * para ponerle borde a la tabla
         * */
        $BalanceBudgets = $this->egresosPeriodBudget($budget, 'egresos');
        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para 
          crear los rangos de celdas */
        $cuenta = $this->CuentasPeriodSaldoBudget($budget, 'ingresos');
        /* Para saber las letras segun los tipos de presupuestos */
        $arrangement = $this->headerPeriodTable($budget);
        /* Libreria de excel */
        Excel::create('Filename', function($excel) use ($school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
            $excel->sheet('Sheetname', function($sheet) use ( $school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
                $letraColumna = $arrangement['letras'];
                $count = count($cuenta);
                $countFinal = count($BalanceBudgets);
                $countEgreso = 2 + $count;
                $countHeaderEgre = 3 + $count;
                $countHeaderCat = 4 + $count;
                $countDetailsCat = 5 + $count;
                /* Inicio Encabezado */
                $sheet->mergeCells('A1:' . $letraColumna . '1');
                $sheet->mergeCells('A2:' . $letraColumna . '2');
                $sheet->mergeCells('A3:' . $letraColumna . '3');
                $sheet->mergeCells('A4:' . $letraColumna . '4');
                $sheet->mergeCells('A5:' . $letraColumna . '5');
                $sheet->mergeCells('A6:' . $letraColumna . '6');
                $sheet->mergeCells('A7:' . $letraColumna . '7');
                $sheet->mergeCells('A8:' . $letraColumna . '8');
                $sheet->mergeCells('A9:' . $letraColumna . '9');
                $sheet->mergeCells('A10:' . $letraColumna . '10');
                $sheet->cells('A1:' . $letraColumna . '13', function($cells) {
                    $cells->setAlignment('center');
                });
                /* fin Encabezado */

                /* Inicio Ingresos */
                $sheet->mergeCells('A11:' . $letraColumna . '11');
                $sheet->mergeCells('A12:' . $letraColumna . '12');
                $sheet->mergeCells('A' . $countEgreso . ':' . $letraColumna . $countEgreso);
                $sheet->mergeCells('A' . $countHeaderEgre . ':I' . $countHeaderEgre);
                $sheet->setBorder('A12:' . $letraColumna . $count, 'thin');
                $sheet->setBorder('A' . $countEgreso . ':' . $letraColumna . $countFinal, 'thin');
                $sheet->mergeCells('A13:I13');
                $sheet->cells('A12:' . $letraColumna . '14', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A' . $countEgreso . ':' . $letraColumna . $countHeaderCat, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($BalanceBudgets, null, 'A1', true, false);
                /* fin Ingresos */
            });
        })->export('xls');
    }

    /**
     * Con este metrodo creamos el encabezado de las tablas para mostrar
     * @param type $budget
     * @return string
     */
    private function headerPeriodTable($budget) {
        $countTypeBudget = $budget->typeBudgets->count();

        for ($i = 0; $i < count($budget->typeBudgets); $i++):
            $typeBudget[] = ($budget->typeBudgets[$i]->name);
        endfor;

        switch ($countTypeBudget):
            case 1:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], 'Sub Total', 'Total');
                $letraColumna = 'M';
                break;
            case 2:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], 'Sub Total', 'Total');
                $letraColumna = 'N';
                break;
            case 3:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], 'Sub Total', 'Total');
                $letraColumna = 'O';
                break;
            case 4:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], $typeBudget[3], 'Sub Total', 'Total');
                $letraColumna = 'P';
                break;
            case 5:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], $typeBudget[3], $typeBudget[4], 'Sub Total', 'Total');
                $letraColumna = 'Q';
                break;
            case 6:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], $typeBudget[3], $typeBudget[4], $typeBudget[5], 'Sub Total', 'Total');
                $letraColumna = 'R';
                break;
        endswitch;
        $arrangement = array('typeBudget' => $typeBudgetQ, 'letras' => $letraColumna);
        return $arrangement;
    }

    /**
     * Con este methodo generamos el encabezado 
     * para los archivos de excel 
     * @param type $budget
     * @return array
     */
    private function headerPeriodExcel($budget) {
        $school = $budget->schools;
        $arrangement = $this->headerPeriodTable($budget);
        $header = array(
            array(''),
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array($school->name . ', CÉDULA JURÍDICA ' . $school->charter),
            array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code),
            array(''),
            array('RELACIÓN DE INGRESOS Y GASTOS'),
            array($school->ffinancing),
            array('(Del 01 de enero al 31 de diciembre del ' . $budget->year . ')'),
            array('(Veinti tres millones ochocientos  ochenta y cinco  mil novecientos  setenta y siete con 87/100)'),
            array(''),
            array('INGRESOS'),
            $arrangement['typeBudget'],
            array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F')
        );
        return $header;
    }

    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    private function balancePeriodForGroup($budget, $group, $type) {
        $balanceGroup = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->sum('amount');
        return $balanceGroup;
    }

    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    private function balancePeriodForTypeBudget($budget, $typeBudget, $type) {
        $balanceTypeBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.type', $type)
                        ->where('balance_budgets.types_budgets_id', $typeBudget)->sum('amount');
        return $balanceTypeBudget;
    }

    /**
     * Con este methodo generamos los totales de cada cuadro
     * para los archivos de excel
     * @param type $budget
     * @param type $type
     * @return type
     */
    private function saldoPeriodTypeBudget($budget, $type) {
        $typeBudget = $this->PeriodForTypeBudget($budget);
        $paso1 = $this->balancePeriodForTypeBudget($budget, $typeBudget[0], $type);
        $countTypeBudget = count($typeBudget);
        switch ($countTypeBudget):
            case 1:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0), number_format($paso1, 0), number_format($paso1, 0));
                break;
            case 2:
                $paso2 = $this->balancePeriodForTypeBudget($budget, $typeBudget[1], $type);
                $subTotal = $paso1 + $paso2;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 3:
                $paso2 = $this->balancePeriodForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balancePeriodForTypeBudget($budget, $typeBudget[2], $type);
                $subTotal = $paso1 + $paso2 + $paso3;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 4:
                $paso2 = $this->balancePeriodForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balancePeriodForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = $this->balancePeriodForTypeBudget($budget, $typeBudget[3], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($paso4, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 5:
                $paso2 = $this->balancePeriodForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balancePeriodForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = $this->balancePeriodForTypeBudget($budget, $typeBudget[3], $type);
                $paso5 = $this->balancePeriodForTypeBudget($budget, $typeBudget[4], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($paso4, 0),
                    number_format($paso5, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 6:
                $paso2 = $this->balancePeriodForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balancePeriodForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = $this->balancePeriodForTypeBudget($budget, $typeBudget[3], $type);
                $paso5 = $this->balancePeriodForTypeBudget($budget, $typeBudget[4], $type);
                $paso6 = $this->balancePeriodForTypeBudget($budget, $typeBudget[5], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($paso4, 0),
                    number_format($paso5, 0), number_format($paso6, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
        endswitch;
    }

    /**
     * Con este methodo generamos las cuentas de ingresos para 
     * los archivos de excel.
     * @param type $budget
     * @return type
     */
    private function CuentasPeriodSaldoBudget($budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->headerPeriodExcel($budget);
        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balancePeriodForGroup($budget, $group, $type);
            if ($group->type == $type):
                $ArregloCuentasDetalle = $this->detailsPeriodIncomeAccounts($group, $budget, $type);
                switch ($countTypeBudget):
                    case 1:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 5:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 6:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                endswitch;
            endif;
        endforeach;
        $ingresos[] = $this->saldoPeriodTypeBudget($budget, 'ingresos');
        return $ingresos;
    }

    /**
     * Con este metodos generamos el array de las cuentas de detalle para generar el excel
     * y unimos los datos del encabezado y los datos del ingresos
     * @param type $budget
     * @return type
     */
    private function egresosPeriodBudget($budget) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->CuentasPeriodSaldoBudget($budget, 'ingresos');
        $arrangement = $this->headerTable($budget);

        $ingresos[] = array('');
        $ingresos[] = array('EGRESOS');
        $ingresos[] = $arrangement['typeBudget'];
        $ingresos[] = array('P', 'G', 'SP', '', '', '', '', '', '');

        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balancePeriodForGroup($budget, $group, 'egresos');

            if ($group->type == 'egresos'):
                $ArregloCuentasDetalle = $this->detailsPeriodEgresosAccounts($group, $budget, 'egresos');
                switch ($countTypeBudget):
                    case 1:

                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;

                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 5:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 6:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                endswitch;
            endif;

        endforeach;
        $ingresos[] = $this->saldoTypeBudget($budget, 'egresos');
        return $ingresos;
    }

    /**
     * Obtenemos el saldo de cada una de las cuentas
     * @param type $budget
     * @param type $catalog
     * @param type $type
     * @return type
     */
    private function balancePeriodTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = BalanceBudget::where('balance_budgets.budgets_id', $budget)
                        ->where('balance_budgets.catalogs_id', $catalog)
                        ->where('balance_budgets.types_budgets_id', $type)->sum('amount');


        return $amountBalanceBudget;
    }

    /**
     * Conseguimos los id de los tipos de presupuestos
     * ligados a un presupuesto.
     * @param type $budget
     * @return type
     */
    private function PeriodForTypeBudget($budget) {

        for ($i = 0; $i < count($budget->typeBudgets); $i++):
            $typeBudget[] = ($budget->typeBudgets[$i]->id);
        endfor;
        return $typeBudget;
    }

    /**
     * Con este methodo generamos el array de las cuentas de detalle
     * @param type $group
     * @param type $budget
     * @return type
     */
    private function detailsPeriodIncomeAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget AS $catalog):
            $typeBudget = $this->PeriodForTypeBudget($budget);
            $paso1 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[0]);


            switch ($countTypeBudget):
                case 1:
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1
                        , '', '', number_format($paso1, 0), number_format($paso1, 0));
                    break;
                case 2:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2;
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, '', number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 3:
                    $paso2 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]);
                    $paso3 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 4:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 5:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 6:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);
        return $string;
    }

    /**
     * Con este methodo generamos el array de las cuentas de detalle
     * @param type $group
     * @param type $budget
     * @return type
     */
    private function detailsPeriodEgresosAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget AS $catalog):
            $typeBudget = $this->PeriodForTypeBudget($budget);
            $paso1 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[0]);


            switch ($countTypeBudget):
                case 1:
                    return array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1
                        , '', '', number_format($paso1, 0), number_format($paso1, 0));
                    break;
                case 2:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2;
                    return array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, '', number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 3:
                    $paso2 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]);
                    $paso3 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 4:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 5:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 6:
                    $paso2 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = $this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $paso4 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balancePeriodTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);
        return $string;
    }

    /**
     * ***************** Fin del codigo para el archivo de Excel por periodo para el presupuesto **********************
     */

    /**
     * ***************** Inicia el codigo para el archivo de Excel General **********************
     */
    public function generalBudgetExcel() {
        $school= School::Token('qkwewqkewqklqeklkl123');
        $budgets = Budget::where('schools_id', $school->id)->where('global', 1)->get();
        $content= $this->headerGeneralExcel($school);
        foreach($budgets AS  $budget):
            //$content[]= $this->CuentasGeneralSaldoBudget($budget, 'ingresos');
             echo json_encode($content); 
        endforeach;
      // echo json_encode($budget); 
       die;
        /** Con esta variable obtendremos el numero de filas de los egresos
         * para ponerle borde a la tabla
         * */
        $BalanceBudgets = $this->egresosGeneralBudget($budget[0], 'egresos');

        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para 
          crear los rangos de celdas */
        $cuenta = $this->CuentasGeneralSaldoBudget($budget[0], 'ingresos');
        /**/
        $header = $this->headerGeneralExcel($budget[0]);
        /* Libreria de excel */
        Excel::create('Filename', function($excel) use ($header, $BalanceBudgets, $cuenta) {
            $excel->sheet('Sheetname', function($sheet) use ( $header, $BalanceBudgets, $cuenta) {
                $letraColumna = 'L';
                $count = count($cuenta);
                $countFinal = count($BalanceBudgets);
                $countEgreso = 2 + $count;
                $countHeaderEgre = 3 + $count;
                $countHeaderCat = 4 + $count;
                $countDetailsCat = 5 + $count;
                $countHeader = count($header) - 2;
                $countHeaderTable = $countHeader + 1;
                $countCuadro = $countFinal + 3;
                $countCuadroFinal = $countCuadro + 17;
                /* Inicio Encabezado */
                $sheet->mergeCells('A1:' . $letraColumna . '1');
                $sheet->mergeCells('A2:' . $letraColumna . '2');
                $sheet->mergeCells('A3:' . $letraColumna . '3');
                $sheet->mergeCells('A4:' . $letraColumna . '4');
                $sheet->mergeCells('A5:' . $letraColumna . '5');
                $sheet->mergeCells('A6:' . $letraColumna . '6');
                $sheet->mergeCells('A7:' . $letraColumna . '7');
                $sheet->mergeCells('A8:' . $letraColumna . '8');
                $sheet->mergeCells('A9:' . $letraColumna . '9');
                $sheet->mergeCells('A10:' . $letraColumna . '10');
                $sheet->mergeCells('A11:' . $letraColumna . '11');
                $sheet->mergeCells('A12:' . $letraColumna . '12');
                $sheet->mergeCells('A13:' . $letraColumna . '13');

                /* fin Encabezado */

                /* Inicio Ingresos */
                $sheet->mergeCells('A' . $countHeader . ':' . $letraColumna . $countHeader);
                $sheet->mergeCells('A' . $countHeaderTable . ':I' . $countHeaderTable);
                // $sheet->mergeCells('A12:' . $letraColumna . '12');
                $sheet->mergeCells('A' . $countEgreso . ':' . $letraColumna . $countEgreso);
                $sheet->mergeCells('A' . $countHeaderEgre . ':I' . $countHeaderEgre);
                $sheet->setBorder('A' . $countHeader . ':' . $letraColumna . $count, 'thin');
                $sheet->setBorder('A' . $countEgreso . ':' . $letraColumna . $countFinal, 'thin');



                $sheet->cells('A1:' . $letraColumna . '13', function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cells('A11:' . $letraColumna . '13', function($cells) {
                    $cells->setAlignment('left');
                });
                $sheet->cells('A' . $countHeader . ':' . $letraColumna . $countHeaderTable, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A' . $countEgreso . ':' . $letraColumna . $countHeaderCat, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });


                $sheet->fromArray($BalanceBudgets, null, 'A1', true, false);
                $sheet->cell('B40:L50', function($cells) {
                    $cells->setBorder('solid', 'none', 'none', 'solid');
                });
                /* fin Ingresos */
            });
        })->export('xls');
    }

    /**
     * Con este metodos generamos el array de las cuentas de detalle para generar el excel
     * y unimos los datos del encabezado y los datos del ingresos
     * @param type $budget
     * @return type
     */
    private function egresosGeneralBudget($budget) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->CuentasGeneralSaldoBudget($budget, 'ingresos');
        $ingresos[] = array('');
        $ingresos[] = array('EGRESOS');
        $ingresos[] = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', 'Monto', 'Total');
        $ingresos[] = array('P', 'G', 'SP', '', '', '', '', '', '');

        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balanceForGroup($budget, $group, 'egresos');

            if ($group->type == 'egresos'):
                $ArregloCuentasDetalle = $this->detailsGlobalIncomeAccounts($group, $budget, 'egresos');
                $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                foreach ($ArregloCuentasDetalle AS $detalle):
                    $ingresos[] = $detalle;
                endforeach;

            endif;

        endforeach;
        $ingresos[] = $this->saldoGlobalTypeBudget($budget, 'egresos');
        return $ingresos;
    }

    /**
     * Con este methodo generamos las cuentas de ingresos para 
     * los archivos de excel.
     * @param type $budget
     * @return type
     */
    private function CuentasGeneralSaldoBudget($budget, $type) {
        $ingresos = $this->headerGeneralExcel($budget);

        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balanceForGroup($budget, $group, $type);

            if ($group->type == $type):
                $ArregloCuentasDetalle = $this->detailsGlobalIncomeAccounts($group, $budget, $type);

                $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                foreach ($ArregloCuentasDetalle AS $detalle):
                    $ingresos[] = $detalle;
                endforeach;
            endif;
        endforeach;

        $ingresos[] = $this->saldoGlobalTypeBudget($budget, 'ingresos');
        return $ingresos;
    }

    /**
     * Con este methodo generamos el array de las cuentas de detalle
     * @param type $group
     * @param type $budget
     * @return type
     */
    private function detailsGlobalIncomeAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->get();
        foreach ($catalogBalanceBudget AS $catalog):
            $paso1 = $this->balanceGlobalTypeBudget($budget->id, $catalog->id);
            $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                $catalog->name, number_format($paso1, 0), '');
        endforeach;

        $string = array_unique($details, SORT_REGULAR);
        return $string;
    }

    /**
     * Con este methodo generamos los totales de cada cuadro
     * para los archivos de excel
     * @param type $budget
     * @param type $type
     * @return type
     */
    private function saldoGlobalTypeBudget($budget, $type) {
        $paso1 = $this->balanceGlobalForTypeBudget($budget, $type);
        return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0), number_format($paso1, 0));
    }

    /**
     * Obtenemos el saldo de cada una de las cuentas
     * @param type $budget
     * @param type $catalog
     * @param type $type
     * @return type
     */
    private function balanceGlobalTypeBudget($budget, $catalog) {
        $amountBalanceBudget = BalanceBudget::where('balance_budgets.budgets_id', $budget)
                        ->where('balance_budgets.catalogs_id', $catalog)->sum('amount');


        return $amountBalanceBudget;
    }

    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    private function balanceGlobalForTypeBudget($budget, $type) {
        $balanceTypeBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.type', $type)->sum('amount');
        return $balanceTypeBudget;
    }

    /**
     * Con este methodo generamos el encabezado 
     * para los archivos globales de excel
     * @param type $budget
     * @return array
     */
    private function headerGeneralExcel($school) {
        
        $header = array(
            array(''),
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array($school->name . ', CÉDULA JURÍDICA ' . $school->charter),
            array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code),
            array(''),
            array('PRESUPUESTO ORDINARIO PARA EL EJERCICIO ECONÓMICO ' . $school->budgets[0]->year ),
            array(''),
            array('(Del 01 de enero al 31 de diciembre del ' . $school->budgets[0]->year . ')'),
            array('(Veinti tres millones ochocientos  ochenta y cinco  mil novecientos  setenta y siete con 87/100)'),
            array('Transcripción del acuerdo de Junta de aprobación presupuestaria: '),
            array('Este proyecto de presupuesto fue aprobado en la sesión número _________, realizada el día ___, del mes de ______________, del'),
            array('año  ' . $school->budgets[0]->year . '. Todo lo anterior consta en el acta N. ___, artículo N. ___.'),
            array(''),
            array(''),
            array('INGRESOS'),
            array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', 'Monto', 'Total'),
            array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F')
        );
       
        return $header;
    }

    /**
     * ***************** Finaliza el codigo para el archivo de Excel General presupuesto **********************
     */
    /**
     * ***************** Inicia el codigo para el archivo de Excel Inicial para el presupuesto **********************
     */

    /**
     * Con este methodo unimos dos los datos finales
     * para generar el archivo de excel
     * con la libreria de Maatwebsite
     * Show the form for creating a new resource.
     * @return Response
     */
    public function budgetInicialExcel($token) {
        $budget = Budget::Token($token);
        $school = $budget->schools;
        /** Con esta variable obtendremos el numero de filas de los egresos
         * para ponerle borde a la tabla
         * */
        $BalanceBudgets = $this->egresosBudget($budget, 'egresos');
        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para 
          crear los rangos de celdas */
        $cuenta = $this->CuentasSaldoBudget($budget, 'ingresos');
        /* Para saber las letras segun los tipos de presupuestos */
        $arrangement = $this->headerInicialTable($budget);
        /* Libreria de excel */
        Excel::create('Filename', function($excel) use ($school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
            $excel->sheet('Sheetname', function($sheet) use ( $school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
                $letraColumna = $arrangement['letras'];
                $count = count($cuenta);
                $countFinal = count($BalanceBudgets);
                $countEgreso = 2 + $count;
                $countHeaderEgre = 3 + $count;
                $countHeaderCat = 4 + $count;
                $countDetailsCat = 5 + $count;
                /* Inicio Encabezado */
                $sheet->mergeCells('A1:' . $letraColumna . '1');
                $sheet->mergeCells('A2:' . $letraColumna . '2');
                $sheet->mergeCells('A3:' . $letraColumna . '3');
                $sheet->mergeCells('A4:' . $letraColumna . '4');
                $sheet->mergeCells('A5:' . $letraColumna . '5');
                $sheet->mergeCells('A6:' . $letraColumna . '6');
                $sheet->mergeCells('A7:' . $letraColumna . '7');
                $sheet->mergeCells('A8:' . $letraColumna . '8');
                $sheet->mergeCells('A9:' . $letraColumna . '9');
                $sheet->mergeCells('A10:' . $letraColumna . '10');
                $sheet->cells('A1:' . $letraColumna . '13', function($cells) {
                    $cells->setAlignment('center');
                });
                /* fin Encabezado */

                /* Inicio Ingresos */
                $sheet->mergeCells('A11:' . $letraColumna . '11');
                $sheet->mergeCells('A12:' . $letraColumna . '12');
                $sheet->mergeCells('A' . $countEgreso . ':' . $letraColumna . $countEgreso);
                $sheet->mergeCells('A' . $countHeaderEgre . ':I' . $countHeaderEgre);
                $sheet->setBorder('A12:' . $letraColumna . $count, 'thin');
                $sheet->setBorder('A' . $countEgreso . ':' . $letraColumna . $countFinal, 'thin');
                $sheet->mergeCells('A13:I13');
                $sheet->cells('A12:' . $letraColumna . '14', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A' . $countEgreso . ':' . $letraColumna . $countHeaderCat, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($BalanceBudgets, null, 'A1', true, false);
                /* fin Ingresos */
            });
        })->export('xls');
    }

    /**
     * Con este metrodo creamos el encabezado de las tablas para mostrar
     * @param type $budget
     * @return string
     */
    private function headerInicialTable($budget) {
        $countTypeBudget = $budget->typeBudgets->count();

        for ($i = 0; $i < count($budget->typeBudgets); $i++):
            $typeBudget[] = ($budget->typeBudgets[$i]->name);
        endfor;

        switch ($countTypeBudget):
            case 1:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], 'Sub Total', 'Total');
                $letraColumna = 'M';
                break;
            case 2:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], 'Sub Total', 'Total');
                $letraColumna = 'N';
                break;
            case 3:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], 'Sub Total', 'Total');
                $letraColumna = 'O';
                break;
            case 4:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], $typeBudget[3], 'Sub Total', 'Total');
                $letraColumna = 'P';
                break;
            case 5:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], $typeBudget[3], $typeBudget[4], 'Sub Total', 'Total');
                $letraColumna = 'Q';
                break;
            case 6:
                $typeBudgetQ = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', $typeBudget[0], $typeBudget[1], $typeBudget[2], $typeBudget[3], $typeBudget[4], $typeBudget[5], 'Sub Total', 'Total');
                $letraColumna = 'R';
                break;
        endswitch;
        $arrangement = array('typeBudget' => $typeBudgetQ, 'letras' => $letraColumna);
        return $arrangement;
    }

    /**
     * Con este methodo generamos el encabezado 
     * para los archivos de excel 
     * @param type $budget
     * @return array
     */
    private function headerExcel($budget) {
        $school = $budget->schools;
        $arrangement = $this->headerInicialTable($budget);
        $header = array(
            array(''),
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array($school->name . ', CÉDULA JURÍDICA ' . $school->charter),
            array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code),
            array(''),
            array('RELACIÓN DE INGRESOS Y GASTOS'),
            array($school->ffinancing),
            array('(Del 01 de enero al 31 de diciembre del ' . $budget->year . ')'),
            array('(Veinti tres millones ochocientos  ochenta y cinco  mil novecientos  setenta y siete con 87/100)'),
            array(''),
            array('INGRESOS'),
            $arrangement['typeBudget'],
            array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F')
        );
        return $header;
    }

    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    private function balanceForGroup($budget, $group, $type) {
        $balanceGroup = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->sum('amount');
        return $balanceGroup;
    }

    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    private function balanceForTypeBudget($budget, $typeBudget, $type) {
        $balanceTypeBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.type', $type)
                        ->where('balance_budgets.types_budgets_id', $typeBudget)->sum('amount');
        return $balanceTypeBudget;
    }

    /**
     * Con este methodo generamos los totales de cada cuadro
     * para los archivos de excel
     * @param type $budget
     * @param type $type
     * @return type
     */
    private function saldoTypeBudget($budget, $type) {
        $typeBudget = $this->forTypeBudget($budget);
        $paso1 = $this->balanceForTypeBudget($budget, $typeBudget[0], $type);
        $countTypeBudget = count($typeBudget);
        switch ($countTypeBudget):
            case 1:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0), number_format($paso1, 0), number_format($paso1, 0));
                break;
            case 2:
                $paso2 = $this->balanceForTypeBudget($budget, $typeBudget[1], $type);
                $subTotal = $paso1 + $paso2;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 3:
                $paso2 = $this->balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balanceForTypeBudget($budget, $typeBudget[2], $type);
                $subTotal = $paso1 + $paso2 + $paso3;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 4:
                $paso2 = $this->balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balanceForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = $this->balanceForTypeBudget($budget, $typeBudget[3], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($paso4, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 5:
                $paso2 = $this->balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balanceForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = $this->balanceForTypeBudget($budget, $typeBudget[3], $type);
                $paso5 = $this->balanceForTypeBudget($budget, $typeBudget[4], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($paso4, 0),
                    number_format($paso5, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
            case 6:
                $paso2 = $this->balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = $this->balanceForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = $this->balanceForTypeBudget($budget, $typeBudget[3], $type);
                $paso5 = $this->balanceForTypeBudget($budget, $typeBudget[4], $type);
                $paso6 = $this->balanceForTypeBudget($budget, $typeBudget[5], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 0),
                    number_format($paso2, 0), number_format($paso3, 0), number_format($paso4, 0),
                    number_format($paso5, 0), number_format($paso6, 0), number_format($subTotal, 0), number_format($subTotal, 0));
                break;
        endswitch;
    }

    /**
     * Con este methodo generamos las cuentas de ingresos para 
     * los archivos de excel.
     * @param type $budget
     * @return type
     */
    private function CuentasSaldoBudget($budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->headerExcel($budget);
        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balanceForGroup($budget, $group, $type);
            if ($group->type == $type):
                $ArregloCuentasDetalle = $this->detailsIncomeAccounts($group, $budget, $type);
                switch ($countTypeBudget):
                    case 1:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 5:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 6:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                endswitch;
            endif;
        endforeach;
        $ingresos[] = $this->saldoTypeBudget($budget, 'ingresos');
        return $ingresos;
    }

    /**
     * Con este metodos generamos el array de las cuentas de detalle para generar el excel
     * y unimos los datos del encabezado y los datos del ingresos
     * @param type $budget
     * @return type
     */
    private function egresosBudget($budget) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->CuentasSaldoBudget($budget, 'ingresos');
        $arrangement = $this->headerInicialTable($budget);

        $ingresos[] = array('');
        $ingresos[] = array('EGRESOS');
        $ingresos[] = $arrangement['typeBudget'];
        $ingresos[] = array('P', 'G', 'SP', '', '', '', '', '', '');

        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balanceForGroup($budget, $group, 'egresos');

            if ($group->type == 'egresos'):
                $ArregloCuentasDetalle = $this->detailsEgresosAccounts($group, $budget, 'egresos');
                switch ($countTypeBudget):
                    case 1:

                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;

                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 5:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 6:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                endswitch;
            endif;

        endforeach;
        $ingresos[] = $this->saldoTypeBudget($budget, 'egresos');
        return $ingresos;
    }

    /**
     * Obtenemos el saldo de cada una de las cuentas
     * @param type $budget
     * @param type $catalog
     * @param type $type
     * @return type
     */
    private function balanceTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = BalanceBudget::where('balance_budgets.budgets_id', $budget)
                        ->where('balance_budgets.catalogs_id', $catalog)
                        ->where('balance_budgets.types_budgets_id', $type)->sum('amount');


        return $amountBalanceBudget;
    }

    /**
     * Conseguimos los id de los tipos de presupuestos
     * ligados a un presupuesto.
     * @param type $budget
     * @return type
     */
    private function forTypeBudget($budget) {

        for ($i = 0; $i < count($budget->typeBudgets); $i++):
            $typeBudget[] = ($budget->typeBudgets[$i]->id);
        endfor;
        return $typeBudget;
    }

    /**
     * Con este methodo generamos el array de las cuentas de detalle
     * @param type $group
     * @param type $budget
     * @return type
     */
    private function detailsIncomeAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget AS $catalog):
            $typeBudget = $this->forTypeBudget($budget);
            $paso1 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]);


            switch ($countTypeBudget):
                case 1:
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1
                        , '', '', number_format($paso1, 0), number_format($paso1, 0));
                    break;
                case 2:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2;
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, '', number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 3:
                    $paso2 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]);
                    $paso3 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 4:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 5:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 6:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);
        return $string;
    }

    /**
     * Con este methodo generamos el array de las cuentas de detalle
     * @param type $group
     * @param type $budget
     * @return type
     */
    private function detailsEgresosAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget AS $catalog):
            $typeBudget = $this->forTypeBudget($budget);
            $paso1 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]);


            switch ($countTypeBudget):
                case 1:
                    return array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1
                        , '', '', number_format($paso1, 0), number_format($paso1, 0));
                    break;
                case 2:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2;
                    return array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, '', number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 3:
                    $paso2 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]);
                    $paso3 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 4:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 5:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
                case 6:
                    $paso2 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = $this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $paso4 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = ($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 0), number_format($subTotal, 0));
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);
        return $string;
    }

}
