<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\School;
use Illuminate\Http\Request;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;
use Crypt;
use Illuminate\Support\Facades\Hash;

class SchoolsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $schools = School::withTrashed()->orderBy('name', 'ASC')->get();
        return View('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return View('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->createArray($schools, "Schools");
        /* Declaramos las clases a utilizar */
        $saveSchools = new School;
        /* Validamos los datos para guardar tabla menu */
        if ($saveSchools->isValid((array) $Validation)):
            $saveSchools->name = strtoupper($Validation['name']);
            $saveSchools->charter = strtoupper($Validation['charter']);
            $saveSchools->circuit = ($Validation['circuit']);
            $saveSchools->code = ($Validation['code']);
            $saveSchools->ffinancing = strtoupper($Validation['ffinancing']);
            $saveSchools->president = strtoupper($Validation['president']);
            $saveSchools->secretary = strtoupper($Validation['secretary']);
            $saveSchools->account = strtoupper($Validation['account']);
            $saveSchools->title_1 = strtoupper($Validation['title_1']);
            $saveSchools->title_2 = ($Validation['title_2']);
            $saveSchools->token = ($Validation['token']);
            $saveSchools->save();
            /* Traemos el id del ultimo registro guardado */
            $ultimoIdSchools = $saveSchools->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($schools->statusSchool == true):
                School::withTrashed()->find($ultimoIdSchools->id)->restore();
            else:
                School::destroy($ultimoIdSchools->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($saveSchools->errors);
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
        return View('schools.edit');
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
     * Creamos el array para la validacion con los
     * nombre de los campos
     * @param type $user
     * @param type $supplier
     * @return type
     */
    private function createArray($schools) {
        $school = array('name' => $schools->nameSchool,
            'charter' => $schools->charterSchool,
            'circuit' => $schools->circuitSchool,
            'code' => ($schools->codeSchool),
            'ffinancing' => $schools->ffinancingSchool,
            'president' => $schools->presidentSchool,
            'secretary' => $schools->secretarySchool,
            'account' => $schools->accountSchool,
            'title_1' => $schools->titleOneSchool,
            'title_2' => ($schools->titleTwoSchool),
            'token' => Crypt::encrypt($schools->charterSchool));
        return $school;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = School::token($schools->tokenUser)->delete();
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
    public function active() {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = School::token($schools->tokenUser)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
