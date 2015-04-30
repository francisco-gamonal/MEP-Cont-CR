<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Budget;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function budgetExcel() {
        $budget = Budget::find(1);
        
       // echo json_encode($budget->balanceBudgets->typeBudgets); die;
        
        $data = array(
            array('MINISTERIO DE EDUCACIÓN PÚBLICA'),
            array('DIRECCIÓN REGIONAL DE EDUCACIÓN DE AGUIRRE'),
            array('JUNTA ADMINISTRATIVA COLEGIO DE MATAPALO, CÉDULA JURÍDICA 3-008 05 6599'),
            array('CIRCUITO 02   CÓDIGO  4231'),
            array(''),
            array('RELACIÓN DE INGRESOS Y GASTOS'),
            array('FUENTE DE FINANCIAMIENTO: LEY 6746 FONDO GENERAL PARA JUNTAS DE EDUCACIÓN Y ADMINISTRATIVAS'),
            array('(Del 01 de enero al 31 de diciembre del 2012)'),
            array('(Veinti tres millones ochocientos  ochenta y cinco  mil novecientos  setenta y siete con 87/100)')
        );
        
        
        Excel::create('Filename', function($excel) use ($data) {
            $excel->sheet('Sheetname', function($sheet) use ($data) {
                /* Inicio Encabezado */
                $sheet->mergeCells('A1:T1');
                $sheet->mergeCells('A2:T2');
                $sheet->mergeCells('A3:T3');
                $sheet->mergeCells('A4:T4');
                $sheet->mergeCells('A5:T5');
                $sheet->mergeCells('A6:T6');
                $sheet->mergeCells('A7:T7');
                $sheet->mergeCells('A8:T8');
                $sheet->mergeCells('A9:T9');
                $sheet->mergeCells('A10:T10');
                $sheet->cells('A1:T10', function($cells) {
                    $cells->setAlignment('center');
                });
                 $sheet->fromArray($data, null, 'A1', true);
                /* fin Encabezado */

               
                
                /* Inicio Ingresos */
                $sheet->mergeCells('A12:T12');
                $sheet->setBorder('A1:T12', 'thin');
                $sheet->cells('A12:T12', function($cells) {
                    $cells->setAlignment('center');
                    $cells->setFontWeight('bold');
                });
                 $sheet->row(12,array('INGRESOS'));
                 $sheet->mergeCells('A13:I13');
                 $sheet->row(13,array('Códigos',true,true,true,true,true,true,true,true,'Descripción',true,true,true,true,true,true,'Colegio (III y IV Ciclo)','Educación Especial','Sub Total','Total'));
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
