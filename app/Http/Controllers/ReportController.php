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
        return view('reports.budget.content', compact('budget'));
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
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    private function balanceForGroup($budget, $group) {
        $balanceGroup = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', 'ingresos')->sum('amount');
        return $balanceGroup;
    }

    /**
     * 
     * @param type $budget
     * @return type
     */
    private function ingresosBudget($budget) {
        $countTypeBudget = $budget->typeBudgets->count();
        foreach ($budget->groups AS $group):
            $groupBalanceBudget = $this->balanceForGroup($budget, $group);
            if ($group->type == 'ingresos'):
                switch ($countTypeBudget):
                    case 1:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget);
                        break;
                    case 2:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget);
                        break;
                    case 3:
                        $ingresos[] = array($group->code . '. ' . $group->name, '', '', '', '', '', '', '', '', '', '', '', '', '', number_format($groupBalanceBudget, 0));
                        $ingresos[] = $this->detailsIncomeAccounts($group, $budget);
                        break;
                endswitch;
            endif;

        endforeach;

        // echo json_encode($ingreso); die;
        return $ingresos;
    }

    private function detailsIncomeAccounts($group, $budget) {
        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', 'ingresos')->get();
        $countTypeBudget = $budget->typeBudgets->count();
        foreach ($catalogBalanceBudget AS $catalog):
            
 if ($catalog->type == 'ingresos'):
            $amountBalanceBudget = BalanceBudget::where('balance_budgets.budgets_id', $budget->id)
                            ->where('balance_budgets.types_budgets_id', $catalog->types_budgets_id)->get();
        echo json_encode($amountBalanceBudget); die;
    if($amountBalanceBudget):
        $level1='';
    endif;
            
                    return array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg, $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f, $catalog->name, number_format($amountBalanceBudget, 0), '', '', '', '');
         endif;       
        endforeach;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function budgetExcel() {


        $budget = Budget::find(1);
        $school = $budget->schools;
        $ingresoGroupBalanceBudgets = $this->ingresosBudget($budget);
        $arrangement = $this->headerTable($budget);


        // echo   json_encode($ingresoGroupBalanceBudgets); die;
//dd($data); die;

        Excel::create('Filename', function($excel) use ($school, $arrangement, $budget, $ingresoGroupBalanceBudgets) {
            $excel->sheet('Sheetname', function($sheet) use ( $school, $arrangement, $budget, $ingresoGroupBalanceBudgets) {


                $letraColumna = $arrangement['letras'];
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
                $sheet->cells('A1:' . $letraColumna . '10', function($cells) {
                    $cells->setAlignment('center');
                });

                /* fin Encabezado */

                /* Inicio Ingresos */
                $sheet->mergeCells('A11:' . $letraColumna . '11');
                $sheet->mergeCells('A12:' . $letraColumna . '12');
                $sheet->setBorder('A12:' . $letraColumna . '20', 'thin');
                $sheet->mergeCells('A13:I13');
                $sheet->cells('A12:' . $letraColumna . '14', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->row(2, array('MINISTERIO DE EDUCACIÓN PÚBLICA'));
                $sheet->row(3, array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'));
                $sheet->row(4, array($school->name . ', CÉDULA JURÍDICA ' . $school->charter));
                $sheet->row(5, array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code));
                $sheet->row(7, array('RELACIÓN DE INGRESOS Y GASTOS'));
                $sheet->row(8, array($school->ffinancing));
                $sheet->row(9, array('(Del 01 de enero al 31 de diciembre del ' . $budget->year . ')'));
                $sheet->row(10, array('(Veinti tres millones ochocientos  ochenta y cinco  mil novecientos  setenta y siete con 87/100)'));
                $sheet->row(12, array('INGRESOS'));
                $sheet->row(13, $arrangement['typeBudget']);
                $sheet->row(14, array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F'));

                $sheet->mergeCells('A15:J15');
                $sheet->fromArray($ingresoGroupBalanceBudgets, null, 'A15', false, false);


                /* fin Ingresos */
            });
        })->export('xls');
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
