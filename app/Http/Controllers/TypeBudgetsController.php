<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\TypeBudget;
use Illuminate\Http\Request;
use Crypt;
class TypeBudgetsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $typeBudgets = TypeBudget::withTrashed()->get();
        return view('typeBudgets.index', compact('typeBudgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('typeBudgets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $typeBudgets = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $typeBudgets->nameTypeBudget);
        /* Declaramos las clases a utilizar */
        $typeBudget = new TypeBudgets;
        /* Validamos los datos para guardar tabla menu */
        if ($typeBudget->isValid((array) $ValidationData)):
            $typeBudget->name = strtoupper($ValidationData['name']);
            $typeBudget->token = Crypt::encrypt($ValidationData['name']);
            $typeBudget->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idGroup = $typeBudget->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeBudgets->statusTypeBudget == true):
                TypeBudgets::withTrashed()->find($typeBudgets->id)->restore();
            else:
                TypeBudgets::destroy($typeBudgets->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($group->errors);
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
        $typeBudget = TypeBudget::withTrashed()->where('token', '=', $token)->get();
        return view('typeBudgets.edit', compact('typeBudget'));
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
        /* les damos eliminacion pasavida */
        $data = TypeBudget::destroy($id);
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
    public function active($id) {
        /* les quitamos la eliminacion pasavida */
        $data = TypeBudget::onlyTrashed()->find($id);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
