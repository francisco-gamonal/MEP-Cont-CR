<?php

namespace Mep\Http\Controllers\Report;

use Maatwebsite\Excel\Facades\Excel;
use Mep\Models\Budget;
use Mep\Models\BalanceBudget;
use Mep\Models\Catalog;
use Mep\Models\School;
use Mep\Models\Group;
use Mep\Models\Balance;
use Illuminate\Support\Facades\DB;
use Mep\Http\Controllers\ReportExcel;

class BudgetInitialController extends ReportExcel {

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        $this->middleware('auth');
        set_time_limit(0);
    }

    protected function Header($budget) {
        $school = $budget->schools;
        $arrangement = $this->headerInicialTable($budget);
        $balance = BalanceBudget::balanceForType($budget, 'ingresos');
        $subHeader = array(
            array(''),
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array($school->name . ', CÉDULA JURÍDICA ' . $school->charter),
            array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code),
            array(''),
            array('RELACIÓN DE INGRESOS Y GASTOS'),
            array('FUENTE DE FINANCIAMIENTO: '.$budget->ffinancing),
            array('(Del 01 de enero al 31 de diciembre del ' . $budget->year . ')'),
            array('('.$this->convertLetters($balance).' )'),
            array(''),
            array('INGRESOS'),
            $arrangement['typeBudget'],
            array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F'),
        );
        return $subHeader;
    }

    /**
     * ***************** Inicia el codigo para el archivo de Excel Inicial para el presupuesto **********************.
     */

    /**
     * Con este methodo unimos dos los datos finales
     * para generar el archivo de excel
     * con la libreria de Maatwebsite
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function budgetInicialExcel($token) {
        try {
            DB::beginTransaction();
            $budget = Budget::Token($token);
            $school = $budget->schools;
            /* Con esta variable obtendremos el numero de filas de los egresos
             * para ponerle borde a la tabla
             * */
            $BalanceBudgets = $this->egresosBudget($budget, 'egresos');
            /* Con esta variables obtendremos la cantidad de las filas en los ingresos para
              crear los rangos de celdas */
            $cuenta = $this->CuentasSaldoBudget($budget, 'ingresos');
            /* Para saber las letras segun los tipos de presupuestos */
            $arrangement = $this->headerInicialTable($budget);
            /* Libreria de excel */
           
            Excel::create('Presupuesto', function ($excel) use ($school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
                $excel->sheet('Presupuesto', function ($sheet) use ($school, $arrangement, $budget, $BalanceBudgets, $cuenta) {
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
        } catch (Exception $e) {
            Log::error($e);
            DB::rollback();

            return $this->errores(array('key' => 'Se ha Generado un error Verifique la información o contacte el soporte Tecnico'));
        }
    }

   

    /**
     * Con este methodo generamos las cuentas de ingresos para
     * los archivos de excel.
     *
     * @param type $budget
     *
     * @return type
     */
    private function CuentasSaldoBudget($budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->headerBudget($budget);
         foreach ($budget->groups as $group):
            $groupBalanceBudget = BalanceBudget::balanceForGroup($budget, $group, $type);
            if ($group->type == $type):
                $ArregloCuentasDetalle = $this->detailsIncomeAccounts($group, $budget, $type);
          
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
     
        $ingresos[] = $this->saldoTypeBudget($budget, 'ingresos');
      
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
    private function egresosBudget($budget) {
        $countTypeBudget = $budget->typeBudgets->count();
        $ingresos = $this->CuentasSaldoBudget($budget, 'ingresos');
        $arrangement = $this->headerInicialTable($budget);

        $ingresos[] = array('');
        $ingresos[] = array('EGRESOS');
        $ingresos[] = $arrangement['typeBudget'];
        $ingresos[] = array('P', 'G', 'SP', '', '', '', '', '', '');

        foreach ($budget->groups as $group):
            $groupBalanceBudget = BalanceBudget::balanceForGroup($budget, $group, 'egresos');

            if ($group->type == 'egresos'):
                $ArregloCuentasDetalle = $this->detailsEgresosAccounts($group, $budget, 'egresos');
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
    private function detailsIncomeAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalog_id')
                        ->where('balance_budgets.budget_id', $budget->id)
                        ->where('catalogs.group_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget as $catalog):
            $typeBudget = $this->forTypeBudget($budget);
            $paso1 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]);
           // echo json_encode($typeBudget[1]); die;
            switch ($countTypeBudget):
                case 1:
                    $details[] =  array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, number_format($paso1, 2)
                        , number_format($paso1, 2));
                    break;
                case 2:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $subTotal = $paso1 + $paso2;

                    $details[] =  array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, '', number_format($subTotal, 2),);
                    break;
                case 3:
                    $paso2 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]);
                    $paso3 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 2));
                    break;
                case 4:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 2));
                    break;
                case 5:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 2));
                    break;
                case 6:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $paso4 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
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
    private function detailsEgresosAccounts($group, $budget, $type) {
        $countTypeBudget = $budget->typeBudgets->count();

        $catalogBalanceBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalog_id')
                        ->where('balance_budgets.budget_id', $budget->id)
                        ->where('catalogs.group_id', $group->id)
                        ->where('catalogs.type', $type)->get();

        foreach ($catalogBalanceBudget as $catalog):
            $typeBudget = $this->forTypeBudget($budget);
            $paso1 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[0]);

            switch ($countTypeBudget):
                case 1:
                    $details[] =  array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, number_format($paso1, 2), number_format($paso1, 2));
                    break;
                case 2:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $subTotal = $paso1 + $paso2;

                    $details[] =  array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, '', number_format($subTotal, 2), number_format($subTotal, 2),);
                    break;
                case 3:
                    $paso2 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]);
                    $paso3 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $subTotal = $paso1 + $paso2 + $paso3;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, number_format($subTotal, 2), number_format($subTotal, 2),);
                    break;
                case 4:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4;
                    $details[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg,
                        $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, number_format($subTotal, 2), number_format($subTotal, 2),);
                    break;
                case 5:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]));
                    $paso4 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, number_format($subTotal, 2), number_format($subTotal, 2),);
                    break;
                case 6:
                    $paso2 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[1]));
                    $paso3 = BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[2]);
                    $paso4 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[3]));
                    $paso5 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[4]));
                    $paso6 = (BalanceBudget::balanceTypeBudget($budget->id, $catalog->id, $typeBudget[5]));
                    $subTotal = $paso1 + $paso2 + $paso3 + $paso4 + $paso5 + $paso6;
                    $details[] = array($catalog->p, $catalog->g, $catalog->sp, '',
                        '', '', '', '', '',
                        $catalog->name, $paso1, $paso2, $paso3, $paso4, $paso5, $paso6, number_format($subTotal, 2), number_format($subTotal, 2),);
                    break;
            endswitch;
        endforeach;

        $string = array_unique($details, SORT_REGULAR);

        return $string;
    }

    public function reportValidation($token) {
        
    }

    public function tableValidation($token) {
        
    }

    public function valitation($token) {
        
    }
    public function convertLetters($number) {
        return $this->convertir_a_letras($number);
    }
}
