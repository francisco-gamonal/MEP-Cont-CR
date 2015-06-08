<?php
namespace Mep\Http\Controllers\Report;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Maatwebsite\Excel\Facades\Excel;
use Mep\Http\Controllers\ReportExcel;
use Mep\Models\Spreadsheet;
use Mep\Models\Check;
use Mep\Models\Budget;
use Mep\Models\Balance;
/**
 * Description of SpreadseehtExcelController
 *
 * @author Anwar Sarmiento
 */
class SpreadseehtExcelController extends ReportExcel {
  
   

      /**
     * **************************************inicio Excel de cuadro planilla *************************************.
     */
    public function excelSpreadsheet($token) {
        $spreadsheet = Spreadsheet::Token($token);
        $spreadsheets = $this->CreateArraySpreadsheet($spreadsheet);
        $Content = count($spreadsheets);
        $firms = $this->firmSpreadshet();
        foreach ($firms as $firm):
            $spreadsheets[] = $firm;
        endforeach;
        //  echo json_encode($Content); die;
        Excel::create('Planilla-', function ($excel) use ($spreadsheets, $Content) {
            $excel->sheet('Cuadro Planilla-', function ($sheet) use ($spreadsheets, $Content) {
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
                $sheet->mergeCells('L11:M12');
                $firm = $Content + 3;
                $sheet->cells('B' . $firm . ':M' . $firm, function ($cells) {
                    $cells->setAlignment('center');
                    //   $cells->setFontWeight('bold');
                });
                $sheet->mergeCells('B' . $firm . ':D' . $firm);
                $sheet->mergeCells('G' . $firm . ':K' . $firm);
                $firm = $firm + 1;
                $sheet->mergeCells('B' . $firm . ':D' . $firm);
                $sheet->mergeCells('G' . $firm . ':K' . $firm);
                $firm = $firm + 2;
                $sheet->mergeCells('B' . $firm . ':D' . $firm);
                $sheet->mergeCells('G' . $firm . ':K' . $firm);
                $firm = $firm + 1;
                $sheet->mergeCells('B' . $firm . ':D' . $firm);
                $sheet->mergeCells('G' . $firm . ':K' . $firm);
                $firm = $firm + 1;
                $sheet->mergeCells('B' . $firm . ':D' . $firm);
                $sheet->mergeCells('G' . $firm . ':K' . $firm);
                $sheet->setHeight(13, 50);

                $sheet->cells('B1:M5', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('B6:I10', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('J6:M10', function ($cells) {
                    $cells->setBorder('solid', 'none', 'solid', 'none');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('B11:M13', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('G' . $Content . ':I' . $Content, function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $content = $Content - 1;

                //   $sheet->setBorder('B6:M10', 'thin');
                $sheet->setBorder('J6:M10', 'thin');
                $sheet->setBorder('B11:K12', 'thin');
                $sheet->setBorder('L11:M12', 'thin');
                $sheet->setBorder('B13:M13', 'thin');
                $sheet->setBorder('B15:M' . $content, 'thin');
                $sheet->setBorder('G' . $Content . ':I' . $Content, 'thin');

                $sheet->fromArray($spreadsheets, null, 'B1', true, false);
            });
        })->export('xls');
    }

    private function CreateArraySpreadsheet($spreadsheet) {
        $spreadsheets = $this->headerSpreadsheet($spreadsheet);
       
        $spreadsheet = $this->contentSpreadsheet($spreadsheet);
        
        foreach ($spreadsheet as $value):
            $spreadsheets[] = $value;
        endforeach;

        return $spreadsheets;
    }

    private function firmSpreadshet() {
        $firm = array(
            array(''),
            array(''),
            array('Aprobado por:_________________________', '', '', '', '', 'Revisado por:___________________________'),
            array('Nombre, firma, cédula  del Secretario (a)y sello de Junta', '', '', '', '', 'Nombre, firma, cédula y sello   del Director (a)'),
            array(''),
            array('Aprobado por:_________________________', '', '', '', '', 'Revisado por:___________________________'),
            array('Nombre, firma, cédula  del Presidente(a) ó', '', '', '', '', 'Nombre, firma, cédula  y sello del Tesorero-'),
            array('Vicepresidente(a)', '', '', '', '', 'Contador'),
        );

        return $firm;
    }

    private function contentSpreadsheet($spreadsheet) {
       
        $checks = Check::where('spreadsheet_id', $spreadsheet->id)->get();
        if(count($spreadsheet->transfers)>0):
            $lastTransfer = $spreadsheet->transfers[count($spreadsheet->transfers) - 1]->code;
        else:
            $lastTransfer = "";
        endif;
        
       
        $balanceTotal = 0;
        $totalAmount = 0;
        $totalRetention = 0;
        $totalCancelar = 0;
        $balanceInicial = 0;
        $count = 0;
        foreach ($checks as $index => $check):
            $balance = Balance::BalanceInicialTotal($check->balanceBudgets->id, $check->id, $spreadsheet, null, $lastTransfer, 'spreadsheet');
            $id = $check->balanceBudgets->id;
            if ($count == 0) {
                $idT = $check->balanceBudgets->id;
                $balanceInicial = $balance;
                $balanceTotal = $balanceInicial - $check->amount;
                $count++;
            } else {

                if ($idT != $id):
                    $balanceInicial = $balance;
                    $balanceTotal = $balanceInicial - $check->amount;
                    $count++;
                else:
                    $count == 0;
                    $balanceInicial = $balanceTotal;
                    $balanceTotal = $balanceInicial - $check->amount;
                endif;
            }

            $content[] = array($check->balanceBudgets->catalogs->codeCuenta(),
                number_format($balanceInicial, 2), $check->bill, $check->supplier->name, $check->concept,
                number_format($check->amount, 2), number_format($check->retention, 2), number_format($check->cancelarAmount(), 2), $check->ckbill,
                $check->ckretention, $check->record, number_format($balanceTotal, 2),
            );

            $totalAmount += $check->amount;
            $totalRetention += $check->retention;
            $totalCancelar += $check->cancelarAmount();
        endforeach;
        $content[] = array('', '', '', '', '', number_format($totalAmount, 2), number_format($totalRetention, 2), number_format($totalCancelar, 2), '', '', '', '');

        return $content;
    }

    private function headerSpreadsheet($spreadsheet) {
        $header = array(
            array('MINISTERIO DE EDUCACION PUBLICA'),
            array('DIRECCION REGIONAL DE EDUCACION DE AGUIRRE'),
            array('OFICINA DE JUNTAS DE EDUCACION Y ADMINISTRATIVAS'),
            array(''),
            array('FORMULARIO F-4 LISTA DE PAGOS A REALIZAR'),
            array('PLANILLA DE PAGO N. ' . $spreadsheet->number . '-' . $spreadsheet->year . '  FECHA  ' . $spreadsheet->date, '', '', '', '', '', '', '', 'PROGRAMA:       Ley 6746'),
            array('Junta: ' . $spreadsheet->budgets->schools->name),
            array('Cédula Jurídica ' . $spreadsheet->budgets->schools->charter),
            array(''),
            array(''),
            array('Información presupuestaria', '', 'Información del pago', '', '', '', '', '', '# Cheques', ''),
            array(''),
            array('Codigo', 'Saldo presupuestario', '# Factura', 'Nombre del Proveedor', 'Concepto', 'Monto', 'Retención', 'Monto a Cancelar', 'Pago ck', 'Pago Retención', 'Acta N. / Acuerdo N.', 'Saldo Presupuestario Final'),
            array(''),
        );

        return $header;
    }

  

    protected function Header($budget) {
        
    }

}
