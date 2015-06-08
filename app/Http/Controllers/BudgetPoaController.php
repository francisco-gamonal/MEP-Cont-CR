<?php
            namespace Mep\Http\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Mep\Http\Controllers\ReportExcel;
use Mep\Models\Budget;
use Mep\Models\BalanceBudget;
use Maatwebsite\Excel\Facades\Excel;
/**
 * Description of BudgetPoaController
 *
 * @author Anwar Sarmiento
 */
class BudgetPoaController extends ReportExcel {
    //put your code here
    
       /**
     * **************************************inicio Excel de cuadro POA *************************************.
     */
    public function excelPoaBudget($token) {
        $Budget = Budget::Token($token);
        $content = $this->CreateArrayPoaBudget($Budget);
        Excel::create('Transfers-', function ($excel) use ($content) {
            $excel->sheet('Cuadro Transfers-', function ($sheet) use ($content) {
                $sheet->mergeCells('A1:G1');
                $sheet->setBorder('A1:G1', 'thin');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A4:G4');
                $sheet->mergeCells('A6:G6');
                $sheet->mergeCells('A7:G7');
                $sheet->setBorder('A7:G7', 'thin');
                $sheet->setBorder('A8:G8', 'thin');
                $sheet->cells('A7:G8', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = count($content) - 4;
                $sheet->mergeCells('C' . $count . ':F' . $count);
                $sheet->setBorder('A9:G' . $count, 'thin');
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A6:G6', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($content, null, 'A1', true, false);
            });
        })->export('xls');
    }

    private function CreateArrayPoaBudget($Budget) {
        $content = $this->headerPoaBudget($Budget);
        $firm = $this->firmPoaBudget($Budget);
        $balanceBudget = $this->contentPoaBudget($Budget);

        foreach ($balanceBudget as $data):
            $content[] = $data;
        endforeach;
        foreach ($firm as $data):
            $content[] = $data;
        endforeach;

        return $content;
    }

    private function firmPoaBudget($Budget) {
        $firm = array(
            array(''),
            array('________________________________'),
            array('Fernando Enrique Espinoza'),
            array('Director ' . $Budget->name),
        );

        return $firm;
    }

    private function contentPoaBudget($Budget) {
        $balanceBudgetAmount = 0;
        foreach ($Budget->balancebudgets as $balanceBudget):
            $content[] = array($balanceBudget->policies, $balanceBudget->strategic, $balanceBudget->operational, $balanceBudget->goals, $balanceBudget->catalogs->codeCuenta(), $Budget->name, $balanceBudget->amount);
            $balanceBudgetAmount += $balanceBudget->amount;
        endforeach;
        $content[] = array('', '', 'TOTAL PRESUPUESTO ' . $Budget->name, '', '', '', $balanceBudgetAmount);

        return $content;
    }

    private function headerPoaBudget($Budget) {
        $year = $Budget->year - 1;
        $header = array(array('POA'),
            array('MATRIZ PARA VINCULAR EL PLAN OPERATIVO CENTRO EDUCATIVO Y PRESUPUESTO DE LA JUNTA ADMINISTRATIVA'),
            array($Budget->schools->name . ' CODIGO: ' . $Budget->schools->code),
            array('Presupuesto inicial de la institucion1' . $year . ' PARA GIRAR EL AÑO ' . $Budget->year),
            array($Budget->name),
            array(''),
            array('PLAN OPERATIVO'),
            array('POLITICAS', 'OBJECTIVO ESTRATEGICO', 'OBJETIVO OPERACIONAL', 'METAS', 'CODIGOS PRESUPUESTARIO', 'RECURSOS PROVINIENTES', 'MONTO DEL PROYECTO'),
        );

        return $header;
    }

    /**
     * **************************************FIN Excel de cuadro POA *************************************.
     */

    /**
     * **************************************inicio Excel de cuadro POA *************************************.
     */
    public function excelPoa($token) {
        $balanceBudget = BalanceBudget::Token($token);
        $content = $this->CreateArrayPoa($balanceBudget);
        Excel::create('Transfers-', function ($excel) use ($content) {
            $excel->sheet('Cuadro Transfers-', function ($sheet) use ($content) {
                $sheet->mergeCells('A1:G1');
                $sheet->setBorder('A1:G1', 'thin');
                $sheet->mergeCells('A2:G2');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A3:G3');
                $sheet->mergeCells('A4:G4');
                $sheet->mergeCells('A6:G6');
                $sheet->mergeCells('A7:G7');
                $sheet->setBorder('A7:G7', 'thin');
                $sheet->setBorder('A8:G8', 'thin');
                $sheet->cells('A7:G8', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = count($content) - 4;
                $sheet->mergeCells('C' . $count . ':F' . $count);
                $sheet->setBorder('A9:G' . $count, 'thin');
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function ($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A1:G1', function ($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A6:G6', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->fromArray($content, null, 'A1', true, false);
            });
        })->export('xls');
    }

    private function CreateArrayPoa($balanceBudget) {
        $content = $this->headerPoa($balanceBudget);
        $firm = $this->firmPoa($balanceBudget);
        $balanceBudget = $this->contentPoa($balanceBudget);

        foreach ($balanceBudget as $data):
            $content[] = $data;
        endforeach;
        foreach ($firm as $data):
            $content[] = $data;
        endforeach;

        return $content;
    }

    private function firmPoa($balanceBudget) {
        $firm = array(
            array(''),
            array('________________________________'),
            array('Fernando Enrique Espinoza'),
            array('Director ' . $balanceBudget->budgets->name),
        );

        return $firm;
    }

    private function contentPoa($balanceBudget) {
        $content[] = array($balanceBudget->policies, $balanceBudget->strategic, $balanceBudget->operational, $balanceBudget->goals, $balanceBudget->catalogs->codeCuenta(), $balanceBudget->budgets->name, $balanceBudget->amount);

        $content[] = array('', '', 'TOTAL PRESUPUESTO ' . $balanceBudget->budgets->name, '', '', '', $balanceBudget->amount);

        return $content;
    }

    private function headerPoa($balanceBudget) {
        // $balanceBudget->budgets->schools->name;
        $year = $balanceBudget->budgets->year - 1;
        $header = array(array('POA'),
            array('MATRIZ PARA VINCULAR EL PLAN OPERATIVO CENTRO EDUCATIVO Y PRESUPUESTO DE LA JUNTA ADMINISTRATIVA'),
            array($balanceBudget->budgets->schools->name . ' CODIGO: ' . $balanceBudget->budgets->schools->code),
            array('Presupuesto inicial de la institucion1' . $year . ' PARA GIRAR EL AÑO ' . $balanceBudget->budgets->year),
            array($balanceBudget->budgets->name),
            array(''),
            array('PLAN OPERATIVO'),
            array('POLITICAS', 'OBJECTIVO ESTRATEGICO', 'OBJETIVO OPERACIONAL', 'METAS', 'CODIGOS PRESUPUESTARIO', 'RECURSOS PROVINIENTES', 'MONTO DEL PROYECTO'),
        );

        return $header;
    }

    protected function Header($budget) {
        
    }

    /**
     * **************************************FIN Excel de cuadro POA *************************************.
     */


}
