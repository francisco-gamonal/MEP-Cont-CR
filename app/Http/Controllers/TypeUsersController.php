<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\TypeUser;
use Illuminate\Http\Request;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;

class TypeUsersController extends Controller {


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $typeUsers = TypeUser::withTrashed()->get();
        return view('typeUsers.index', compact('typeUsers'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        return view('typeUsers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $typeUser = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $typeUser->nameTypeUser);
        /* Declaramos las clases a utilizar */
        $typeUsers = new TypeUser;
        /* Validamos los datos para guardar tabla menu */
        if ($typeUsers->isValid((array) $ValidationData)):
            $typeUsers->name = strtoupper($ValidationData['name']);
            $typeUsers->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $newType = $typeUsers->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeUser->statusTypeUser == true):
                TypeUser::withTrashed()->find($newType->id)->restore();
            else:
                TypeUser::destroy($newType->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeUsers->errors);
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
        $typeUser = TypeUser::withTrashed()->find($id);
        return view('typeUsers.edit', compact('typeUser'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
         /* Capturamos los datos enviados por ajax */
        $typeUser = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $typeUser->nameTypeUser);
        /* Declaramos las clases a utilizar */
        $typeUsers =  TypeUser::withTrashed()->find($typeUser->idTypeUser);
        /* Validamos los datos para guardar tabla menu */
        if ($typeUsers->isValid((array) $ValidationData)):
            $typeUsers->name = strtoupper($ValidationData['name']);
            $typeUsers->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($typeUser->statusTypeUser == true):
                TypeUser::withTrashed()->find($typeUser->idTypeUser)->restore();
            else:
                TypeUser::destroy($typeUser->idTypeUser);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeUsers->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $TypeUser = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = TypeUser::destroy($TypeUser->idTypeUser);
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
        $TypeUser = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = TypeUser::onlyTrashed()->find($TypeUser->idTypeUser);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
       return $this->errores($data->errors);
    }

}
