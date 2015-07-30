<?php

namespace Mep\Http\Controllers\Report;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Maatwebsite\Excel\Facades\Excel;
use Mep\Http\Controllers\ReportExcel;
use Mep\Entities\Budget;
use Mep\Entities\BalanceBudget;
use Mep\Entities\Balance;

/**
 * Description of BudgetActualController
 *
 * @author Anwar Sarmiento
 */
class BudgetActualController extends ReportExcel {

    protected function Header($budget) {
        $school = $budget->schools;
        $arrangement = $this->headerInicialTable($budget);
        $subHeader = array(
            array(''),
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array($school->name . ', CÉDULA JURÍDICA ' . $school->charter),
            array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code),
            array(''),
            array('RELACIÓN DE INGRESOS Y GASTOS'),
            array($budget->schools->ffinancing),
            array('(Del 01 de enero al 31 de diciembre del ' . $budget->year . ')'),
            array('(Veinti tres millones ochocientos  ochenta y cinco  mil novecientos  setenta y siete con 87/100)'),
            array(''),
            array('INGRESOS'),
            $arrangement['typeBudget'],
            array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F'),
        );
        return $subHeader;
    }

    /**
     * ***************** Inicia el codigo para el archivo de Excel por periodo para el presupuesto **********************.
     */

    /**
     * Con este methodo unimos dos los datos finales
     * para generar el archivo de excel
     * con la libreria de Maatwebsite
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function budgetPeriodExcel($token) {
        $budget = Budget::Token($token);
        $school = $budget->schools;
        /* Con esta variable obtendremos el numero de filas de los egresos
         * para ponerle borde a la tabla
         * */
        $BalanceBudgets = $this->egresosPeriodBudget($budget, 'egresos');
        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para
          crear los rangos de celdas */
        $cuenta = $this->CuentasPeriodSaldoBudget($budget, 'ingresos');
        /* Para saber las letras segun los tipos de presupuestos */
        $arrangement = $this->headerPeriodTable($budget);
        /* Libreria de excel */
        Excel::create('Presupuesto Actual', function ($excel) use ($school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
            $excel->sheet('Presupuesto Actual', function ($sheet) use ($school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
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
                $sheet->cells('A1:' . $letraColumna . '13', function ($cells) {
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
                $sheet->cells('A12:' . $letraColumna . '14', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A' . $countEgreso . ':' . $letraColumna . $countHeaderCat, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($BalanceBudgets, null, 'A1', true, false);
                /* fin Ingresos */
            });
        })->export('xls');
    }

    /**
     * Con este metrodo creamos el encabezado de las tablas para mostrar.
     *
     * @param type $budget
     *
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
     * Con este methodo generamos los totales de cada cuadro
     * para los archivos de excel.
     *
     * @param type $budget
     * @param type $type
     *
     * @return type
     */
    private function saldoPeriodTypeBudget($budget, $type) {
        $typeBudget = $this->forTypeBudget($budget);
        $paso1 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[0], $type);
        $countTypeBudget = count($typeBudget);
        switch ($countTypeBudget):
            case 1:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 2), number_format($paso1, 2), number_format($paso1, 2));
                break;
            case 2:
                $paso2 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[1], $type);
                $subTotal = $paso1 + $paso2;

                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 2),
                    number_format($paso2, 2), number_format($subTotal, 2), number_format($subTotal, 2),);
                break;
            case 3:
                $paso2 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[2], $type);
                $subTotal = $paso1 + $paso2 + $paso3;

                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 2),
                    number_format($paso2, 2), number_format($paso3, 2), number_format($subTotal, 2), number_format($subTotal, 2),);
                break;
            case 4:
                $paso2 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[3], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4;

                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 2),
                    number_format($paso2, 2), number_format($paso3, 2), number_format($paso4, 2), number_format($subTotal, 2), number_format($subTotal, 2),);
                break;
            case 5:
                $paso2 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[3], $type);
                $paso5 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[4], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;

                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 2),
                    number_format($paso2, 2), number_format($paso3, 2), number_format($paso4, 2),
                    number_format($paso5, 2), number_format($subTotal, 2), number_format($subTotal, 2),);
                break;
            case 6:
                $paso2 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[1], $type);
                $paso3 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[2], $type);
                $paso4 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[3], $type);
                $paso5 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[4], $type);
                $paso6 = BalanceBudget::balanceForTypeBudget($budget, $typeBudget[5], $type);
                $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;

                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($paso1, 2),
                    number_format($paso2, 2), number_format($paso3, 2), number_format($paso4, 2),
                    number_format($paso5, 2), number_format($paso6, 2), number_format($subTotal, 2), number_format($subTotal, 2),);
                break;
        endswitch;
    }

    /**
     * Con este methodo generamos las cuentas de ingresos para
     * los archivos de excel.
     *
     * @param type $budget
     *
     * @return type
     */
    private function CuentasPeriodSaldoBudget($budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->Header($budget);
        foreach ($budget->groups as $group):
            $groupBalanceBudget = BalanceBudget::balanceForGroup($budget, $group, $type);
            if ($group->type == $type):
                $ArregloCuentasDetalle = $this->detailsPeriodIncomeAccounts($group, $budget, $type);
                switch ($countTypeBudget):
                    case 1:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 5:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 6:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
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
     * y unimos los datos del encabezado y los datos del ingresos.
     *
     * @param type $budget
     *
     * @return type
     */
    private function egresosPeriodBudget($budget) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->CuentasPeriodSaldoBudget($budget, 'ingresos');
        $arrangement = $this->headerInicialTable($budget);

        $ingresos[] = array('');
        $ingresos[] = array('EGRESOS');
        $ingresos[] = $arrangement['typeBudget'];
        $ingresos[] = array('P', 'G', 'SP', '', '', '', '', '', '');

        foreach ($budget->groups as $group):
            $groupBalanceBudget = BalanceBudget::balanceForGroup($budget, $group, 'egresos');

            if ($group->type == 'egresos'):
                $ArregloCuentasDetalle = $this->detailsPeriodEgresosAccounts($group, $budget, 'egresos');
                switch ($countTypeBudget):
                    case 1:

                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;

                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 5:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 6:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 2));
                        foreach ($ArregloCuentasDetalle as $detalle):
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
     * Con este methodo generamos el array de las cuentas de detalle.
     *
     * @param type $group
     * @param type $budget
     *
     * @return type
     */
    private function detailsPeriodIncomeAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::select('balance_budgets.id','catalogs.c','catalogs.sc','catalogs.sg','catalogs.sr','catalogs.f','catalogs.r','catalogs.p','catalogs.g','catalogs.sp','catalogs.name')
                        ->join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalog_id')
                        ->where('balance_budgets.budget_id', $budget->id)
                        ->where('catalogs.group_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget as $catalog):
            $typeBudget = $this->forTypeBudget($budget);
            $paso1 = Balance::BalanceBudgetActual($catalog->id);

            switch ($countTypeBudget):
                case 1:
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1
                        , number_format($paso1, 2));
                    break;
                case 2:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso5 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso6 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2;

                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, number_format($subTotal, 2));
                    break;
                case 3:
                    $paso2 = Balance::BalanceBudgetActual($catalog->id);
                    $paso3 = Balance::BalanceBudgetActual($catalog->id);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 2));
                    break;
                case 4:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 2));
                    break;
                case 5:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso5 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 2));
                    break;
                case 6:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = Balance::BalanceBudgetActual($catalog->id);
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso5 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso6 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 2));
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);

        return $string;
    }

    /**
     * Con este methodo generamos el array de las cuentas de detalle.
     *
     * @param type $group
     * @param type $budget
     *
     * @return type
     */
    private function detailsPeriodEgresosAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::select('balance_budgets.id','catalogs.p','catalogs.g','catalogs.sp','catalogs.name')
                        ->join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalog_id')
                        ->where('balance_budgets.budget_id', $budget->id)
                        ->where('catalogs.group_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget as $catalog):
            $typeBudget = $this->forTypeBudget($budget);
            $paso1 = Balance::BalanceBudgetActual($catalog->id);
            switch ($countTypeBudget):
                case 1:
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1
                        , number_format($paso1, 2));
                    break;
                case 2:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso5 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso6 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2;

                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, number_format($subTotal, 2));
                    break;
                case 3:
                    $paso2 = Balance::BalanceBudgetActual($catalog->id);
                    $paso3 = Balance::BalanceBudgetActual($catalog->id);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 2));
                    break;
                case 4:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 2));
                    break;
                case 5:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso5 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 2));
                    break;
                case 6:
                    $paso2 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso3 = Balance::BalanceBudgetActual($catalog->id);
                    $paso4 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso5 = (Balance::BalanceBudgetActual($catalog->id));
                    $paso6 = (Balance::BalanceBudgetActual($catalog->id));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 2));
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);

        return $string;
    }

}
