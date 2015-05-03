<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Budget;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mep\Models\BalanceBudget;
use Mep\Models\Catalog;

class ReportController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $budget = Budget::find(1);
        $balanceBudgets = BalanceBudget::where('budgets_id', $budget->id)->get();
        return view('reports.budget.content', compact('budget', 'balanceBudgets'));
    }

    /**
     * Con este methodo unimos dos los datos finales
     * para generar el archivo de excel
     * con la libreria de Maatwebsite
     * Show the form for creating a new resource.
     * @return Response
     */
    public function budgetExcel() {
        $budget = Budget::find(1);
        $school = $budget->schools;
        /**/
        $BalanceBudgets = $this->egresosBudget($budget, 'egresos');
        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para 
          crear los rangos de celdas */
        $cuenta = $this->CuentasSaldoBudget($budget, 'ingresos');
        /* Para saber las letras segun los tipos de presupuestos */
        $arrangement = $this->headerTable($budget);
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
    private function headerTable($budget) {
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
        $arrangement = $this->headerTable($budget);
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
        $countTypeBudget = count($typeBudget);
        switch ($countTypeBudget):
            case 1:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($this->balanceForTypeBudget($budget, $typeBudget[0], $type), 0));
                break;
            case 2:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($this->balanceForTypeBudget($budget, $typeBudget[0], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[1], $type), 0));
                break;
            case 3:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($this->balanceForTypeBudget($budget, $typeBudget[0], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[1], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[2], $type), 0));
                break;
            case 4:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($this->balanceForTypeBudget($budget, $typeBudget[0], 0), $type),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[1], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[2], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[3], $type), 0));
                break;
            case 5:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($this->balanceForTypeBudget($budget, $typeBudget[0], 0), $type),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[1], 0), $type),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[2], 0), $type),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[3], 0), $type),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[4], 0), $type));
                break;
            case 6:
                return array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($this->balanceForTypeBudget($budget, $typeBudget[0], 0), $type),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[1], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[2], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[3], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[4], $type), 0),
                    number_format($this->balanceForTypeBudget($budget, $typeBudget[5], $type), 0));
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
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget, $type);
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget, $type);
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;
                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget, $type);
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
        $arrangement = $this->headerTable($budget);

        $ingresos[] = array('');
        $ingresos[] = array('EGRESOS');
        $ingresos[] = $arrangement['typeBudget'];
        $ingresos[] = array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F');

        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balanceForGroup($budget, $group, 'egresos');

            if ($group->type == 'egresos'):
                $ArregloCuentasDetalle = $this->detailsIncomeAccounts($group, $budget, 'egresos');
                switch ($countTypeBudget):
                    case 1:

                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):

                        endforeach;
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget, 'egresos');
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        foreach ($ArregloCuentasDetalle AS $detalle):
                            $ingresos[] = $detalle;
                        endforeach;

                        break;
                    case 4:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget, 'egresos');
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
            switch ($countTypeBudget):
                case 1:
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name,
                        number_format($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]), 0), '', '', '', '');
                    break;
                case 2:
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name,
                        number_format($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]), 0),
                        number_format($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]), 0), '', '', '');
                    break;
                case 3:
                    $echo[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name,
                        number_format($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]), 0),
                        number_format($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]), 0),
                        number_format($this->balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]), 0), '', '');

                    break;
            endswitch;
        endforeach;

        $string = array_unique($echo, SORT_REGULAR);
        return $string;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id) {
        //
    }

}
