<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mep\Models\Suppliers;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;
class SupplierController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
       $suppliers = Suppliers::all();
       return view('suppliers.index',  compact('suppliers'));
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
        $json = Input::get('data');
        $supplier = json_decode($json);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('charter' => $supplier->charterSupplier,
            'name' => $supplier->nameSupplier,
            'phone' => $supplier->phoneSupplier,
            'token' => sha1(md5(uniqid($supplier->charterSupplier,true))),
            'email' => $supplier->emailSupplier);
        /* Declaramos las clases a utilizar */
        $suppliers = new Suppliers;
        /* Validamos los datos para guardar tabla menu */
        if ($suppliers->isValid((array) $ValidationData)):
            $suppliers->charter = strtoupper($ValidationData['charter']);
            $suppliers->name = strtoupper($ValidationData['name']);
            $suppliers->email = strtoupper($ValidationData['email']);
            $suppliers->phone = strtoupper($ValidationData['phone']);
            $suppliers->token = sha1(md5(uniqid($ValidationData['charter'],true)));
            $suppliers->save();
            /* Traemos el id del ultimo registro guardado */
            $ultimoIdSupplier = $suppliers->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($supplier->statusSupplier == true):
                Suppliers::withTrashed()->find($ultimoIdSupplier->id)->restore();
            else:
                Suppliers::destroy($ultimoIdSupplier->id);
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
    public function edit($id) {
        $suppliers = Suppliers::withTrashed()->where('token','=',$id);
        return view('suppliers.edit', compact('suppliers'));
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
