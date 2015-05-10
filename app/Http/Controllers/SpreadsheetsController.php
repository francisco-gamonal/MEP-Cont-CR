<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Spreadsheet;
use Illuminate\Http\Request;
use Mep\Models\Budget;

class SpreadsheetsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $spreadsheets = Spreadsheet::withTrashed()->get();
        return view('spreadsheets.index', compact('spreadsheets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $budgets = Budget::all();
        return view('spreadsheets.create', compact('budgets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $spreadsheets = $this->convertionObjeto();
        /* Consulta por token de school */
        $budget = Budget::Token($spreadsheets->budgetSpreadsheets);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($spreadsheets, 'Spreadsheets');
        /* Asignacion de id de school */
        $ValidationData['budgets_id'] = $budget->id;
        $ValidationData['simulation']='false';
        /* Declaramos las clases a utilizar */
        $spreadsheet = new Spreadsheet;
        /* Validamos los datos para guardar tabla menu */
        if ($spreadsheet->isValid($ValidationData)):
            $spreadsheet->fill($ValidationData);
            $spreadsheet->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idSpreadsheet = $spreadsheet->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($spreadsheets->statusSpreadsheets == true):
                Spreadsheet::withTrashed()->find($idSpreadsheet->id)->restore();
            else:
                Spreadsheet::destroy($idSpreadsheet->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($spreadsheet->errors);
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
    public function edit($token) {
        $spreadsheet = Spreadsheet::Token($token);
        $budgets = Budget::all();
        return view('spreadsheets.edit', compact('budgets', 'spreadsheet'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
       /* Capturamos los datos enviados por ajax */
        $spreadsheets = $this->convertionObjeto();
        
        $budget = Budget::Token($spreadsheets->budgetSpreadsheets);
        /* Creamos un array para cambiar nombres de parametros */
       $ValidationData = $this->CreacionArray($spreadsheets, 'Spreadsheets');
        $ValidationData = $this->CreacionArray($spreadsheets, 'Spreadsheets');
        /* Asignacion de id de school */
        $ValidationData['budgets_id'] = $budget->id;
        $ValidationData['simulation']='false';
        /* Declaramos las clases a utilizar */
        $spreadsheet = Spreadsheet::Token($spreadsheets->token);
        /* Validamos los datos para guardar tabla menu */
        if ($spreadsheet->isValid($ValidationData)):
            $spreadsheet->fill($ValidationData);
            $spreadsheet->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($spreadsheets->statusSpreadsheets == true):
                Spreadsheet::Token($spreadsheets->token)->restore();
            else:
                Spreadsheet::Token($spreadsheets->token)->delete();
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($spreadsheet->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Spreadsheet::Token($token)->delete();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se desactivo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function active($token) {
        /* les quitamos la eliminacion pasavida */
        $data = Spreadsheet::Token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    public function report($token){
        return view('reports.spreadsheet.content');
    }

}
