<?php

namespace Mep\Http\Controllers;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
use Maatwebsite\Excel\Facades\Excel;
use Mep\Http\Controllers\ReportExcel;
use Mep\Models\Transfer;
use Mep\Models\Balance;
use Mep\Models\Spreadsheet;

/**
 * Description of TransferExcelController
 *
 * @author Anwar Sarmiento
 */
class TransferExcelController  extends ReportExcel{
    //put your code here
    
    
    /**
     * **************************************inicio Excel de cuadro Transferencia *************************************.
     */
    public function excelTransfers($token) {
        $transfers = Transfer::where('token', $token)->get();
        $content = $this->CreateArrayTransfer($transfers);
        $file = Count($content);
        $firms = $this->firmTransfers();
        foreach ($firms as $firm):
            $content[] = $firm;
        endforeach;
        Excel::create('Transfers-', function ($excel) use ($content, $file) {
            $excel->sheet('Cuadro Transfers-', function ($sheet) use ($content, $file) {
                $sheet->mergeCells('A1:M1');
                $sheet->mergeCells('A2:M2');
                $sheet->mergeCells('A3:M3');
                $sheet->mergeCells('A5:F5');
                $sheet->mergeCells('A6:F6');
                $sheet->mergeCells('A7:F7');
                $sheet->setBorder('A8:F' . $file, 'thin');
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;
                $sheet->mergeCells('A' . $file . ':F' . $file);
                $file = $file + 1;

                $sheet->mergeCells('A' . $file . ':C' . $file);
                $sheet->mergeCells('D' . $file . ':F' . $file);
                $sheet->cells('A8:F8', function ($cells) {
                    $cells->setFontWeight(10);
                });
                $sheet->cells('A1:F3', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A4:F8', function ($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $file = $file - 9;
                $file1 = $file + 3;
                $sheet->cells('A' . $file . ':F' . $file1, function ($cells) {
                    $cells->setAlignment('left');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->setHeight(8, 50);
                $sheet->fromArray($content, null, 'A1', true, false);
            });
        })->export('xls');
    }

    private function CreateArrayTransfer($transfers) {
        $HeaderTransfers = $this->headerTransfers();
        $transfer = $this->contentTransfers($transfers);
        foreach ($transfer as $value):
            $HeaderTransfers[] = $value;
        endforeach;

        return $HeaderTransfers;
    }

    private function contentTransfers($transfers) {
        $content = array();
        $aumento = 0;
        $rebajo = 0;

        foreach ($transfers as $index => $transfer):
            $balance = Balance::BalanceInicialTotal($transfer->balanceBudgets->id, null, $transfer->spreadsheets, $transfer->spreadsheet_id, $transfer->code, 'transfers');
            if ($transfer->type == 'salida'):
                $balanceTotal = $balance - $transfer->amount;
                $content[] = array($transfer->balanceBudgets->catalogs->codeCuenta(), $transfer->balanceBudgets->catalogs->name, $balance, $transfer->amount, '', $balanceTotal);
                $aumento += $transfer->amount;
            else:
                $balanceTotal = $balance + $transfer->amount;
                $content[] = array($transfer->balanceBudgets->catalogs->codeCuenta(), $transfer->balanceBudgets->catalogs->name, $balance, '', $transfer->amount, $balanceTotal);
                $rebajo += $transfer->amount;
            endif;
        endforeach;
        $content[] = array('', '', 'TOTAL', $rebajo, $aumento, '');

        return $content;
    }

    private function firmTransfers() {
        $firm = array(
            array(''),
            array('Modifcacion(es) aprobada(s) según Acuerdo de junta N°___, en sesión (x) ordinaria () estraordinaria, de fecha'),
            array('___ de _____________________ del ____________'),
            array('Firma Presidente(a) de la junta _________________________________'),
            array('Firma Secretario(a) de la junta _________________________________'),
            array('Revisado por Tesorero Contador:_________________________'),
            array(''),
            array('Aprobación (para uso exclusivo de la Dirección Regional de Educación)'),
            array('Nombre y firma del funcionario que aprueba:_______________________________________'),
            array('Sello Dirección Regional:_______________________________________', '', '', 'Fecha de aprobación________________'),
        );

        return $firm;
    }

    private function headerTransfers() {
        $header = array(array('MINISTERIO DE EDUCACION PUBLICA'),
            array('DIRECCION REGIONAL DE EDUCACION DE AGUIRRE'),
            array('OFICINA DE JUNTAS DE EDUCACION Y ADMINISTRATIVAS'),
            array(''),
            array('F-3B MODIFICACIÓN PRESUPUESTARIA PARA APROBACIÓN EXTERNA'),
            array('MODIFICACIONES PRESUPUESTARIAS'),
            array('Junta: Administrativa CTP de Matapalo Cédula Jurídica 3-008-056599  CÓDIGO 5838'),
            array('CÓDIGO DE LA CUENTA', 'NOMBRE DE LA CUENTA', 'SALDO PRESUPUESTARIO DISPONIBLE', 'REBAJO', 'AUMENTO', 'SALDO ACTUAL'),
        );

        return $header;
    }

    protected function Header($budget) {
        
    }

    /**
     * **************************************fin Excel de cuadro Transferencia *************************************.
     */

  
}
