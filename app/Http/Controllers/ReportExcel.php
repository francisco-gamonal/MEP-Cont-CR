<?php

namespace Mep\Http\Controllers;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Mep\Models\BalanceBudget;
/**
 * Description of ReportExcel
 *
 * @author Anwar Sarmiento
 */
abstract class ReportExcel extends Controller {

    //put your code here

    abstract protected function Header($budget);

    /**
     * Conseguimos los id de los tipos de presupuestos
     * ligados a un presupuesto.
     *
     * @param type $budget
     *
     * @return type
     */
    protected function forTypeBudget($budget) {
        for ($i = 0; $i < count($budget->typeBudgets); $i++):
            $typeBudget[] = ($budget->typeBudgets[$i]->id);
        endfor;

        return $typeBudget;
    }

    /**
     * Con este methodo generamos el encabezado
     * para los archivos de excel.
     *
     * @param type $budget
     *
     * @return array
     */
    protected function headerBudget($budget) {

        return $this->Header($budget);
    }

    /**
     * Con este metrodo creamos el encabezado de las tablas para mostrar.
     *
     * @param type $budget
     *
     * @return string
     */
    protected function headerInicialTable($budget) {
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
    protected function saldoTypeBudget($budget, $type) {
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

}
