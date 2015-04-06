<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\BalanceBudgets;
use Illuminate\Http\Request;
use Mep\Models\Catalog;
use Mep\Models\TypeBudget;
use Mep\Models\Budgets;

class BalanceBudgetsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $balanceBudgets = BalanceBudgets::withTrashed()->get();
        return view('balanceBudgets.index', compact('balanceBudgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $budgets = Budgets::all();
        $catalogs = Catalog::all();
        $typeBudget = TypeBudget::all();
        return view('balanceBudgets.create', compact('budgets', 'catalogs', 'typeBudget'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $balanceBudgets = $this->convertionObjeto();
        
        $catalog= Catalog::Token($balanceBudgets->catalogBalanceBudget);
        $budget= Budgets::Token($balanceBudgets->budgetBalanceBudget);
        $catalog= TypeBudget::Token($balanceBudgets->typeBudgetBalanceBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($balanceBudgets, 'BalanceBudget');
        $ValidationData['catalogs_id']= $catalog->id;
        $ValidationData['budgets_id']= $budget->id;
        $ValidationData['catalogs_id']= $catalog->id;
        /* Declaramos las clases a utilizar */
        $balanceBudget = new BalanceBudgets;
        /* Validamos los datos para guardar tabla menu */
        if ($balanceBudget->isValid((array) $ValidationData)):
            $balanceBudget->fill($ValidationData);
            $balanceBudget->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idCatalogs = $catalog->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($balanceBudgets->statusCatalog == true):
                BalanceBudgets::withTrashed()->find($idCatalogs->id)->restore();
            else:
                BalanceBudgets::destroy($idCatalogs->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($balanceBudget->errors);
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
        $balanceBudget= BalanceBudgets::Toke($token);
        $budgets = Budgets::all();
        $catalogs = Catalog::all();
        $typeBudget = TypeBudget::all();
        return view('balanceBudgets.create', compact('budgets', 'catalogs', 'typeBudget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
       /* Capturamos los datos enviados por ajax */
        $balanceBudgets = $this->convertionObjeto();
        
        $catalog= Catalog::Token($balanceBudgets->catalogBalanceBudget);
        $budget= Budgets::Token($balanceBudgets->budgetBalanceBudget);
        $catalog= TypeBudget::Token($balanceBudgets->typeBudgetBalanceBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($balanceBudgets, 'BalanceBudget');
        $ValidationData['catalogs_id']= $catalog->id;
        $ValidationData['budgets_id']= $budget->id;
        $ValidationData['catalogs_id']= $catalog->id;
        /* Declaramos las clases a utilizar */
        $catalog = BalanceBudgets::Token($balanceBudgets->tokenBalanceBudget);
        /* Validamos los datos para guardar tabla menu */
        if ($catalog->isValid((array) $ValidationData)):
            $catalog->fill($ValidationData);
            $catalog->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idCatalogs = $catalog->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($catalogs->statusCatalog == true):
                Catalog::withTrashed()->find($idCatalogs->id)->restore();
            else:
                Catalog::destroy($idCatalogs->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($catalog->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = BalanceBudgets::Token($token)->delete();
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
        $data = BalanceBudgets::Token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
