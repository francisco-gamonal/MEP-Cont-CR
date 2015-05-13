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
use Mep\Models\Group;
use Mep\Models\Balance;
use Mep\Models\Transfer;

class ExcelController extends Controller {

     /**
     * **************************************inicio Excel de cuadro POA *************************************
     */
    public function excelPoaBudget($token) {
        $Budget = Budget::Token($token);
        $content = $this->CreateArrayPoaBudget($Budget);
        Excel::create('Transfers-', function($excel) use ($content) {
            $excel->sheet('Cuadro Transfers-', function($sheet) use ($content ) {
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
                $sheet->cells('A7:G8', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = count($content) - 4;
                $sheet->mergeCells('C' . $count . ':F' . $count);
                $sheet->setBorder('A9:G' . $count, 'thin');
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A6:G6', function($cells) {
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
        

        foreach ($balanceBudget AS $data):
            $content[] = $data;
        endforeach;
        foreach ($firm AS $data):
            $content[] = $data;
        endforeach;
        return $content;
    }

    private function firmPoaBudget($Budget) {
      
        $firm = array(
            array(''),
            array('________________________________'),
            array('Fernando Enrique Espinoza'),
            array('Director ' . $budgets->name)
        );
        return $firm;
    }

    private function contentPoaBudget($Budget) {
        foreach($Budget->balancebudgets AS $balanceBudget ):
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
            array('POLITICAS', 'OBJECTIVO ESTRATEGICO', 'OBJETIVO OPERACIONAL', 'METAS', 'CODIGOS PRESUPUESTARIO', 'RECURSOS PROVINIENTES', 'MONTO DEL PROYECTO')
        );

        return $header;
    }

    /**
     * **************************************FIN Excel de cuadro POA *************************************
     */
    
    /**
     * **************************************inicio Excel de cuadro POA *************************************
     */
    public function excelPoa($token) {
        $balanceBudget = BalanceBudget::Token($token);
        $content = $this->CreateArrayPoa($balanceBudget);
        Excel::create('Transfers-', function($excel) use ($content) {
            $excel->sheet('Cuadro Transfers-', function($sheet) use ($content ) {
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
                $sheet->cells('A7:G8', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = count($content) - 4;
                $sheet->mergeCells('C' . $count . ':F' . $count);
                $sheet->setBorder('A9:G' . $count, 'thin');
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $count = $count + 1;
                $sheet->mergeCells('A' . $count . ':G' . $count);
                $sheet->cells('A' . $count . ':G' . $count, function($cells) {
                    $cells->setAlignment('right');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A1:G1', function($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A6:G6', function($cells) {
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
        

        foreach ($balanceBudget AS $data):
            $content[] = $data;
        endforeach;
        foreach ($firm AS $data):
            $content[] = $data;
        endforeach;
        return $content;
    }

    private function firmPoa($balanceBudget) {
      
        $firm = array(
            array(''),
            array('________________________________'),
            array('Fernando Enrique Espinoza'),
            array('Director ' . $balanceBudget->budgets->name)
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
            array('POLITICAS', 'OBJECTIVO ESTRATEGICO', 'OBJETIVO OPERACIONAL', 'METAS', 'CODIGOS PRESUPUESTARIO', 'RECURSOS PROVINIENTES', 'MONTO DEL PROYECTO')
        );

        return $header;
    }

    /**
     * **************************************FIN Excel de cuadro POA *************************************
     */

    /**
     * **************************************inicio Excel de cuadro Transferencia *************************************
     */
    public function excelTransfers($token) {
        $transfers = Transfer::where('token', $token)->get();
        $content = $this->CreateArrayTransfer($transfers);
        $file = Count($content);
        $firms = $this->firmTransfers();
        foreach ($firms AS $firm):
            $content[] = $firm;
        endforeach;
        Excel::create('Transfers-', function($excel) use ($content, $file) {
            $excel->sheet('Cuadro Transfers-', function($sheet) use ($content, $file ) {
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
                $sheet->cells('A8:F8', function($cells) {
                    $cells->setFontWeight(10);
                });
                $sheet->cells('A1:F3', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('A4:F8', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $file = $file - 9;
                $file1 = $file + 3;
                $sheet->cells('A' . $file . ':F' . $file1, function($cells) {
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
        foreach ($transfer AS $value):
            $HeaderTransfers[] = $value;
        endforeach;

        return $HeaderTransfers;
    }

    private function contentTransfers($transfers) {
        $content = array();
        $aumento = 0;
        $rebajo = 0;
        
        foreach ($transfers AS $index => $transfer):
           
            $balance = Balance::BalanceInicialTotal($transfer->balanceBudgets->id, null, $transfer->spreadsheets, $transfer->spreadsheets_id);

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
            array('Sello Dirección Regional:_______________________________________', '', '', 'Fecha de aprobación________________')
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
            array('CÓDIGO DE LA CUENTA', 'NOMBRE DE LA CUENTA', 'SALDO PRESUPUESTARIO DISPONIBLE', 'REBAJO', 'AUMENTO', 'SALDO ACTUAL')
        );

        return $header;
    }

    /**
     * **************************************fin Excel de cuadro Transferencia *************************************
     */

    /**
     * **************************************inicio Excel de cuadro planilla *************************************
     */
    public function excelSpreadsheet($token) {
        $spreadsheet = Spreadsheet::Token($token);
        $spreadsheets = $this->CreateArraySpreadsheet($spreadsheet);
        $Content = count($spreadsheets);
        $firms = $this->firmSpreadshet();
        foreach ($firms AS $firm):
            $spreadsheets[] = $firm;
        endforeach;
        //  echo json_encode($Content); die;
        Excel::create('Planilla-', function($excel) use ($spreadsheets, $Content) {
            $excel->sheet('Cuadro Planilla-', function($sheet) use ( $spreadsheets, $Content) {
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
                $sheet->cells('B' . $firm . ':M' . $firm, function($cells) {
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

                $sheet->cells('B1:M5', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('B6:I10', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('J6:M10', function($cells) {
                    $cells->setBorder('solid', 'none', 'solid', 'none');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('B11:M13', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setFontWeight('bold');
                });
                $sheet->cells('G' . $Content . ':I' . $Content, function($cells) {
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
        foreach ($spreadsheet AS $value):
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
            array('Vicepresidente(a)', '', '', '', '', 'Contador')
        );

        return $firm;
    }

    private function contentSpreadsheet($spreadsheet) {
        $checks = Check::where('spreadsheets_id', $spreadsheet->id)->get();
        $balanceTotal = 0;
        $totalAmount = 0;
        $totalRetention = 0;
        $totalCancelar = 0;
        foreach ($checks AS $index => $check):
            if ($index == 0) {
                $balance = Balance::BalanceInicialTotal($check->balanceBudgets->id, $check->id, $spreadsheet, null);
            } else {
                $balance = $balance;
            }
            $balanceTotal = $balance - $check->amount;
            $content[] = array($check->balanceBudgets->catalogs->codeCuenta(),
                $balance, $check->bill, $check->supplier->name, $check->concept,
                $check->amount, $check->retention, $check->cancelarAmount(), $check->ckbill,
                $check->ckretention, $check->record, $balanceTotal
            );

            $balance = $balanceTotal;
            $totalAmount += $check->amount;
            $totalRetention+=$check->retention;
            $totalCancelar+=$check->cancelarAmount();
        endforeach;
        $content[] = array('', '', '', '', '', $totalAmount, $totalRetention, $totalCancelar, '', '', '', '');

        return $content;
    }

    private function headerSpreadsheet($spreadsheet) {
        $header = array(
            array('MINISTERIO DE EDUCACION PUBLICA'),
            array('DIRECCION REGIONAL DE EDUCACION DE AGUIRRE'),
            array('OFICINA DE JUNTAS DE EDUCACION Y ADMINISTRATIVAS'),
            array(''),
            array('FORMULARIO F-4 LISTA DE PAGOS A REALIZAR'),
            array('PLANILLA DE PAGO N. 71- 2011  FECHA  28  de Diciembre   del 2011', '', '', '', '', '', '', '', 'PROGRAMA:       Ley 6746'),
            array('Junta: Administrativa CTP de Matapalo'),
            array('Cédula Jurídica 3-008-056599'),
            array(''),
            array(''),
            array('Información presupuestaria', '', 'Información del pago', '', '', '', '', '', '# Cheques', ''),
            array(''),
            array('Codigo', 'Saldo presupuestario', '# Factura', 'Nombre del Proveedor', 'Concepto', 'Monto', 'Retención', 'Monto a Cancelar', 'Pago ck', 'Pago Retención', 'Acta N. / Acuerdo N.', 'Saldo Presupuestario Final'),
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
    public function generalBudgetExcel($token, $global, $year) {
        $school = School::Token($token);
        $catalogs = Catalog::all();

        foreach ($catalogs as $catalog) {
            $amount = Budget::join('balance_budgets', 'budgets.id', '=', 'balance_budgets.budgets_id')
                    ->where('schools_id', $school->id)
                    ->where('global', $global)
                    ->where('catalogs_id', $catalog->id)
                    ->where('year', $year)
                    ->sum('amount');

            if ($amount > 0) {
                $groups[$catalog->groups_id] = Group::find($catalog->groups_id);
                $catalog->amount = $amount;
                $catalogsBudget[] = $catalog;
            }
        }

        foreach ($groups as $group) {
            $totGroup = 0;
            foreach ($catalogsBudget as $catalog) {
                if ($group->id == $catalog->groups_id) {
                    $totGroup += $catalog->amount;
                }
            }
            $group->total = $totGroup;
        }
        $content = $this->generalOutExcel($groups, $catalogsBudget, $school);
        /** Con esta variable obtendremos el numero de filas de los egresos
         * para ponerle borde a la tabla
         * */
        $countFinal = count($content);

        $foots = $this->generalFootExcel();
        foreach ($foots AS $foot):
            $content[] = $foot;
        endforeach;
        /* Con esta variables obtendremos la cantidad de las filas en los ingresos para 
          crear los rangos de celdas */
        $cuenta = $this->generalInExcel($groups, $catalogsBudget, $school);
        /**/
        $header = $this->headerGeneralExcel($school);
        /* Libreria de excel */
        Excel::create('Filename', function($excel) use ($header, $content, $cuenta, $countFinal) {
            $excel->sheet('Sheetname', function($sheet) use ( $header, $content, $cuenta, $countFinal) {
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
                $sheet->cells('A' . $countCuadro . ':' . $letraColumna . $countCuadro, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });

                $sheet->cells('A' . $countCuadro . ':' . $letraColumna . $AlignCount, function($cells) {
                    $cells->setAlignment('center');
                });

                $sheet->cells('A' . $countCuadro . ':' . $letraColumna . $countCuadro, function($cells) {
                    $cells->setFontWeight('bold');
                });
                $sheet->cell('J' . $countCuadroP . ':J' . $countCuadroT, function($cells) {
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                });
                $sheet->cells('K' . $countCuadro . ':' . $letraColumna . $countCuadroFinal, function($cells) {
                    $cells->setAlignment('center');
                });
                $sheet->cells('B' . $countCuadro . ':' . $letraColumna . $countCuadroFinal, function($cells) {
                    $cells->setBorder('solid', 'none', 'none', 'none');
                });



                $sheet->fromArray($content, null, 'A1', true, false);

                /* fin Ingresos */
            });
        })->export('xls');
    }

    private function generalFootExcel() {
        $foot = array(
            array('', ''),
            array('', ''),
            array('', '', '', '', '', '', '', '', '', '', '( Uso de la Regional)'),
            array('', ''),
            array('', 'MARITZA Sanchez Gutierrez ced 6 158434'),
            array('', 'Presidente(a) de La Junta', '', '', '', '', '', '', '', '', '', '________________'),
            array('', 'Nombre, cédula y firma', '', '', '', '', '', '', '', '', 'Fecha de Recibido'),
            array('', ''),
            array('', 'Grettel Roman Ceciliano 6 300 310'),
            array('', 'Secretario(a) de La Junta'),
            array('', 'Nombre, cédula y firma', '', '', '', '', '', '', '', '', '', '________________'),
            array('', '', '', '', '', '', '', '', '', 'Recibido por'),
            array('', '****************************************************************************************'),
            array('', 'Nombre y firma del funcionario que revisó el documento : ____________________________________'),
            array('', ''),
            array('', 'Sello de aprobación de la Dirección Regional: '),
            array('', '', '', '', '', '', '', '', '', '( Sello)'),
            array('', 'Fecha de aprobación: _______________________')
        );
        return $foot;
    }

    /**
     * 
     * @param type $groups
     * @param type $catalogsBudget
     * @param type $school
     * @return type
     */
    private function generalOutExcel($groups, $catalogsBudget, $school) {
        $content = $this->generalInExcel($groups, $catalogsBudget, $school);
        $content[] = array('');
        $content[] = array('EGRESOS');
        $content[] = array('Códigos', '', '', '', '', '', '', '', '', 'Descripción', 'Monto', 'Total');
        $content[] = array('P', 'G', 'SP', '', '', '', '', '', '');
        foreach ($groups as $group):
            if ($group->type == 'egresos'):
                $content[] = array($group->code . ' - ' . $group->name, '', '', '', '', '', '', '', '', '', '', number_format($group->total));
                foreach ($catalogsBudget as $catalog):
                    if ($group->id == $catalog->groups_id):
                        if ($catalog->type == 'egresos'):
                            $content[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg, $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                                $catalog->name, number_format($catalog->amount));


                        endif;
                    endif;
                endforeach;

            endif;
        endforeach;
        return $content;
    }

    /**
     * 
     * @param type $groups
     * @param type $catalogsBudget
     * @param type $school
     * @return type.
     */
    private function generalInExcel($groups, $catalogsBudget, $school) {
        $content = $this->headerGeneralExcel($school);
        foreach ($groups as $group):
            if ($group->type == 'ingresos'):
                $content[] = array($group->code . ' - ' . $group->name, '', '', '', '', '', '', '', '', '', '', number_format($group->total));
                foreach ($catalogsBudget as $catalog):
                    if ($group->id == $catalog->groups_id):
                        if ($catalog->type == 'ingresos'):
                            $content[] = array($catalog->c, $catalog->sc, $catalog->g, $catalog->sg, $catalog->p, $catalog->sp, $catalog->r, $catalog->sr, $catalog->f,
                                $catalog->name, number_format($catalog->amount));


                        endif;
                    endif;
                endforeach;

            endif;
        endforeach;
        return $content;
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
            array('PRESUPUESTO ORDINARIO PARA EL EJERCICIO ECONÓMICO ' . $school->budgets[0]->year),
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
