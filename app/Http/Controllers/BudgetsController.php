<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Budgets;
use Illuminate\Http\Request;
use Mep\Models\School;

class BudgetsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $budget = Budgets::withTrashed()->get();
        return view('budgets.index', compact('budget'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $school = School::all();
        return view('budgets.create', compact('school'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $budgets = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        /* Declaramos las clases a utilizar */
        $budget = new Budgets;
        /* Validamos los datos para guardar tabla menu */
        if ($budget->isValid($ValidationData)):
            $budget->fill($ValidationData);
            $budget->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idBudget = $budget->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($budgets->statusBudget == true):
                Budgets::withTrashed()->find($idBudget->id)->restore();
            else:
                Budgets::destroy($idBudget->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($budget->errors);
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
        $budget = Budgets::withTrashed()->find($id);
        $school = School::all();
        return view('budgets.edit', compact('school', 'budget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
       /* Capturamos los datos enviados por ajax */
        $budgets = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        /* Declaramos las clases a utilizar */
        $budget = Budgets::Token($token);
        /* Validamos los datos para guardar tabla menu */
        if ($budget->isValid($ValidationData)):
            $budget->fill($ValidationData);
            $budget->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($budgets->statusBudget == true):
                Budgets::withTrashed()->find($idBudget->id)->restore();
            else:
                Budgets::destroy($idBudget->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($budget->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Budgets::Token($token)->delete();
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
        $data = Budgets::Token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
