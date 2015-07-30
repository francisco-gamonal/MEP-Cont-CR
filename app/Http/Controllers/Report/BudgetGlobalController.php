<?php

namespace Mep\Http\Controllers\Report;

use Mep\Http\Requests;
use Mep\Http\Controllers\ReportExcel;
use Mep\Entities\School;
use Mep\Entities\Catalog;
use Mep\Entities\Budget;
use Mep\Entities\Group;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class BudgetGlobalController extends ReportExcel {

    public function __construct() {
        set_time_limit(0);
    }

    /**
     * ***************** Inicia el codigo para el archivo de Excel General **********************.
     */
    public function generalBudgetExcel($token, $global, $year) {
        $school = School::Token($token);
        $catalogs = Catalog::all();

        foreach ($catalogs as $catalog) {
            $amount = Budget::join('balance_budgets', 'budgets.id', '=', 'balance_budgets.budget_id')
                    ->where('school_id', $school->id)
                    ->where('global', $global)
                    ->where('catalog_id', $catalog->id)
                    ->where('year', $year)
                    ->sum('amount');

            if ($amount > 0) {
                $groups[$catalog->group_id] = Group::find($catalog->group_id);
                $catalog->amount = $amount;
                $catalogsBudget[] = $catalog;
            }
        }

        foreach ($groups as $group) {
            $totGroup = 0;
            foreach ($catalogsBudget as $catalog) {
                if ($group->id == $catalog->group_id) {
                    $totGroup += $catalog->amount;
                }
            }
            $group->total = $totGroup;
        }
        $content = $this->generalOutExcel($groups, $catalogsBudget, $school);
        /* Con esta variable obtendremos el numero de filas de los egresos
         * para ponerle borde a la tabla
         * */
        $countFinal = count($content);

        $foots = $this->generalFootExcel($school);
        foreach ($foots as $foot):
            $content[] = $foot;
        endforeach;
        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para
          crear los rangos de celdas */
        $cuenta = $this->generalInExcel($groups, $catalogsBudget, $school);
        /**/
        $header = $this->headerGeneralExcel($school,$groups, $catalogsBudget);
        /* Libreria de excel */
        Excel::create('Presupuesto Global', function ($excel) use ($header, $content, $cuenta, $countFinal) {
            $excel->sheet('Presupuesto Global', function ($sheet) use ($header, $content, $cuenta, $countFinal) {
                $letraColumna = 'L';
                $count = count($cuenta);
                $countEgreso = 2 + $count;
                $countHeaderEgre = 3 + $count;
                $countHeaderCat = 4 + $count;
                $countDetailsCat = 5 + $count;
                $countHeader = count($header) - 2;
                $countHeaderTable = $countHeader + 1;
                $countCuadro = $countFinal + 3;
                $countCuadroFinal = $countCuadro + 17;
                $AlignCount = $countCuadro + 9;
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

                /* Firmas */
                $sheet->mergeCells('K' . $countCuadro . ':' . $letraColumna . $countCuadro, 'thin');
                $countCuadroX = $countCuadro + 3;
                $sheet->mergeCells('K' . $countCuadroX . ':' . $letraColumna . $countCuadroX, 'thin');
                $sheet->mergeCells('B' . $countCuadro . ':J' . $countCuadro, 'thin');
                $countCuadroZ = $countCuadroX + 1;
                $sheet->mergeCells('K' . $countCuadroZ . ':' . $letraColumna . $countCuadroZ, 'thin');
                $countCuadroY = $countCuadroZ + 4;
                $sheet->mergeCells('K' . $countCuadroY . ':' . $letraColumna . $countCuadroY, 'thin');
                $countCuadroJ = $countCuadro + 2;
                $sheet->mergeCells('B' . $countCuadroJ . ':J' . $countCuadroJ, 'thin');
                $countCuadroR = $countCuadroJ + 1;
                $sheet->mergeCells('B' . $countCuadroR . ':J' . $countCuadroR, 'thin');
                $countCuadroN = $countCuadroR + 1;
                $sheet->mergeCells('B' . $countCuadroN . ':J' . $countCuadroN, 'thin');
                $countCuadroA = $countCuadroN + 1;
                $sheet->mergeCells('B' . $countCuadroA . ':J' . $countCuadroA, 'thin');
                $countCuadroB = $countCuadroA + 1;
                $sheet->mergeCells('B' . $countCuadroB . ':J' . $countCuadroB, 'thin');
                $countCuadroC = $countCuadroB + 1;
                $sheet->mergeCells('B' . $countCuadroC . ':J' . $countCuadroC, 'thin');
                $countCuadroD = $countCuadroC + 1;
                $sheet->mergeCells('B' . $countCuadroD . ':J' . $countCuadroD, 'thin');
                $countCuadroE = $countCuadroD + 1;
                $sheet->mergeCells('B' . $countCuadroE . ':J' . $countCuadroE, 'thin');
                $countCuadroK = $countCuadroE + 1;
                $sheet->mergeCells('B' . $countCuadroK . ':J' . $countCuadroK, 'thin');
                $countCuadroL = $countCuadroK + 1;
                $sheet->mergeCells('B' . $countCuadroL . ':J' . $countCuadroL, 'thin');
                $countCuadroM = $countCuadroL + 1;
                $sheet->mergeCells('B' . $countCuadroM . ':J' . $countCuadroM, 'thin');
                $countCuadroO = $countCuadroM + 1;
                $sheet->mergeCells('B' . $countCuadroO . ':J' . $countCuadroO, 'thin');
                $countCuadroP = $countCuadroO + 1;
                $sheet->mergeCells('B' . $countCuadroP . ':I' . $countCuadroP, 'thin');
                $countCuadroQ = $countCuadroP + 1;
                $sheet->mergeCells('B' . $countCuadroQ . ':I' . $countCuadroQ, 'thin');
                $countCuadroT = $countCuadroQ + 3;
                $sheet->mergeCells('J' . $countCuadroP . ':J' . $countCuadroT, 'thin');
                /**/
                $sheet->cells('A1:' . $letraColumna . '13', function ($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cells('A11:' . $letraColumna . '13', function ($cells) {
                    $cells->setAlignment('left');
                });
                $sheet->cells('A' . $countHeader . ':' . $letraColumna . $countHeaderTable, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A' . $countCuadro . ':' . $letraColumna . $countCuadro, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->cells('A' . $countCuadro . ':' . $letraColumna . $AlignCount, function ($cells) {
                    $cells->setAlignment('center');
                });

                $sheet->cells('A' . $countCuadro . ':' . $letraColumna . $countCuadro, function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('J' . $countCuadroP . ':J' . $countCuadroT, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->cells('K' . $countCuadro . ':' . $letraColumna . $countCuadroFinal, function ($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cells('B' . $countCuadro . ':' . $letraColumna . $countCuadroFinal, function ($cells) {
                    $cells->setBorder('solid', 'none', 'none', 'none');
                });

                $sheet->fromArray($content, null, 'A1', true, false);

                /* fin Ingresos */
            });
        })->export('xls');
    }

    private function generalFootExcel($school) {
        $foot = array(
            array('', ''),
            array('', ''),
            array('', '', '', '', '', '', '', '', '', '', '( Uso de la Regional)'),
            array('', ''),
            array('', $school->president),
            array('', 'Presidente(a) de La Junta', '', '', '', '', '', '', '', '', '', '________________'),
            array('', 'Nombre, cédula y firma', '', '', '', '', '', '', '', '', 'Fecha de Recibido'),
            array('', ''),
            array('', $school->secretary),
            array('', 'Secretario(a) de La Junta'),
            array('', 'Nombre, cédula y firma', '', '', '', '', '', '', '', '', '', '________________'),
            array('', '', '', '', '', '', '', '', '', 'Recibido por'),
            array('', '****************************************************************************************'),
            array('', 'Nombre y firma del funcionario que revisó el documento : ____________________________________'),
            array('', ''),
            array('', 'Sello de aprobación de la Dirección Regional: '),
            array('', '', '', '', '', '', '', '', '', '( Sello)'),
            array('', 'Fecha de aprobación: _______________________'),
        );

        return $foot;
    }

    /**
     * @param type $groups
     * @param type $catalogsBudget
     * @param type $school
     *
     * @return type
     */
    private function generalOutExcel($groups, $catalogsBudget, $school) {
        $content = $this->generalInExcel($groups, $catalogsBudget, $school);
        $content[] = array('');
        $content[] = array('EGRESOS');
        $content[] = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', 'Monto', 'Total');
        $content[] = array('P', 'G', 'SP', '', '', '', '', '', '');
        $detaills = $this->generalDetaillAccount($groups, $catalogsBudget, 'egresos');
        foreach ($detaills AS $detaill):
            $content[] = $detaill;
        endforeach;
        return $content;
    }

    /**
     * @param type $groups
     * @param type $catalogsBudget
     * @param type $school
     *
     * @return type.
     */
    private function generalInExcel($groups, $catalogsBudget, $school) {
        $content = $this->headerGeneralExcel($school,$groups, $catalogsBudget);

        $detaills = $this->generalDetaillAccount($groups, $catalogsBudget, 'ingresos');
        foreach ($detaills AS $detaill):
            $content[] = $detaill;
        endforeach;

        return $content;
    }

    private function generalDetaillAmount($groups, $catalogsBudget, $type) {
        $Total = 0;
        foreach ($groups as $group):
            if ($group->type == $type):

                $Total += $group->total;

            endif;
        endforeach;

        return $Total;
    }

    private function generalDetaillAccount($groups, $catalogsBudget, $type) {
        $Total = 0;
        foreach ($groups as $group):
            if ($group->type == $type):
                $amount = 0;
                $content[] = array($group->code . ' - ' . $group->name, '', '', '', '', '', '', '', '', '', '', number_format($group->total, 2));
                foreach ($catalogsBudget as $catalog):
                    if ($group->id == $catalog->group_id):
                        if ($catalog->type == $type):
                            $content[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg, $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                                $catalog->name, number_format($catalog->amount, 2),);

                            $amount += $catalog->amount;
                        endif;
                    endif;
                endforeach;
                $Total += $amount;
            endif;
        endforeach;
        $content[] = array('', '', '', '', '', '', '', '', '', 'TOTAL', number_format($Total, 2));

        return $content;
    }

    /**
     * Con este methodo generamos el encabezado
     * para los archivos globales de excel.
     *
     * @param type $budget
     *
     * @return array
     */
    private function headerGeneralExcel($school,$groups, $catalogsBudget) {
$balance = $this->generalDetaillAmount($groups, $catalogsBudget, 'ingresos');
        $header = array(
            array(''),
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array($school->name . ', CÉDULA JURÍDICA ' . $school->charter),
            array('CIRCUITO ' . $school->circuit . '   CÓDIGO  ' . $school->code),
            array(''),
            array('PRESUPUESTO ORDINARIO PARA EL EJERCICIO ECONÓMICO ' . $school->budgets[0]->year),
            array(''),
            array('(Del 01 de enero al 31 de diciembre del ' . $school->budgets[0]->year . ')'),
            array('('.$this->convertir_a_letras($balance).')'),
            array('Transcripción del acuerdo de Junta de aprobación presupuestaria: '),
            array('Este proyecto de presupuesto fue aprobado en la sesión número _________, realizada el día ___, del mes de ______________, del'),
            array('año  ' . $school->budgets[0]->year . '. Todo lo anterior consta en el acta N. ___, artículo N. ___.'),
            array(''),
            array(''),
            array('INGRESOS'),
            array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', 'Monto', 'Total'),
            array('C', 'SC', 'G', 'SG', 'P', 'SP', 'R', 'SR', 'F'),
        );

        return $header;
    }

    protected function Header($budget) {
        
    }

    public function reportValidation($token) {
        
    }

    public function tableValidation($token) {
        
    }

    public function valitation($token) {
        
    }

    /**
     * ***************** Finaliza el codigo para el archivo de Excel General presupuesto **********************.
     */
}
