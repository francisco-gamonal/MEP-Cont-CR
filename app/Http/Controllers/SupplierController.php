<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mep\Models\Supplier;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;
use Crypt;

class SupplierController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $suppliers = Supplier::withTrashed()->get();
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        //
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $supplier = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->createArray($supplier);
        /* Declaramos las clases a utilizar */
        $suppliers = new Supplier;
        /* Validamos los datos para guardar tabla menu */
        if ($suppliers->isValid((array) $ValidationData)):
            $suppliers->charter = strtoupper($ValidationData['charter']);
            $suppliers->name = strtoupper($ValidationData['name']);
            $suppliers->email = strtoupper($ValidationData['email']);
            $suppliers->phone = strtoupper($ValidationData['phone']);
            $suppliers->token = Crypt::encrypt($ValidationData['charter']);
            $suppliers->save();
            /* Traemos el id del ultimo registro guardado */
            $ultimoIdSupplier = $suppliers->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($supplier->statusSupplier == true):
                Supplier::withTrashed()->find($ultimoIdSupplier->id)->restore();
            else:
                Supplier::destroy($ultimoIdSupplier->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($suppliers->errors);
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
        $suppliers = Supplier::withTrashed()->where('token', '=', $token)->get();
        return view('suppliers.edit', compact('suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        /* Capturamos los datos enviados por ajax */
        $supplier = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->createArray($supplier);
        /* Declaramos las clases a utilizar */
       
        $suppliers = Supplier::Token($supplier->tokenSupplier);
        /* Validamos los datos para guardar tabla menu */
        if ($suppliers->isValid((array) $ValidationData)):
            $suppliers->charter = strtoupper($ValidationData['charter']);
            $suppliers->name = strtoupper($ValidationData['name']);
            $suppliers->email = strtoupper($ValidationData['email']);
            $suppliers->phone = strtoupper($ValidationData['phone']);
            $suppliers->token = $supplier->tokenSupplier;
            $suppliers->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($supplier->statusSupplier == true):
                Supplier::token($supplier->tokenSupplier)->restore();
            else:
                Supplier::token($supplier->tokenSupplier)->delete();
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($suppliers->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $suppliers = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = Supplier::token($suppliers->tokenSupplier)->delete();
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
        $suppliers = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = Supplier::token($suppliers->tokenSupplier)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }
       
    /**
     * 
     * @param type $supplier
     * @return type
     */
    private function createArray($supplier) {
        $suppliers = array('charter' => $supplier->charterSupplier,
            'name' => ($supplier->nameSupplier),
            'phone' => ($supplier->phoneSupplier),
            'token' => $supplier->tokenSupplier,
            'email' => ($supplier->emailSupplier));
        return $suppliers;
    }
}
