<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\BalanceBudget;
use Illuminate\Http\Request;
use Mep\Models\Catalog;
use Mep\Models\TypeBudget;
use Mep\Models\Budget;

class BalanceBudgetsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $balanceBudget = BalanceBudget::withTrashed()->get();
        return view('balanceBudgets.index', compact('balanceBudget'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $budgets = Budget::all();
        $catalogs = Catalog::all();
        $typeBudgets = TypeBudget::all();
        return view('balanceBudgets.create', compact('budgets', 'catalogs', 'typeBudgets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $balanceBudgets = $this->convertionObjeto();
        
        $catalog= Catalog::Token($balanceBudgets->catalogsBalanceBudget);
        $budget= Budget::Token($balanceBudgets->budgetBalanceBudget);
        $typeBudget= TypeBudget::Token($balanceBudgets->typeBudgetBalanceBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($balanceBudgets, 'BalanceBudget');
        $ValidationData['catalogs_id']= $catalog->id;
        $ValidationData['budgets_id']= $budget->id;
        $ValidationData['type_budgets_id']= $typeBudget->id;
        /* Declaramos las clases a utilizar */
        $balanceBudget = new BalanceBudget;
        /* Validamos los datos para guardar tabla menu */
        if ($balanceBudget->isValid($ValidationData)):
            $balanceBudget->fill($ValidationData);
            $balanceBudget->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idBalanceBudget = $balanceBudget->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($balanceBudgets->statusBalanceBudget == true):
                BalanceBudget::withTrashed()->find($idBalanceBudget->id)->restore();
            else:
                BalanceBudget::destroy($idBalanceBudget->id);
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
        $balanceBudget= BalanceBudget::Toke($token);
        $budgets = Budget::all();
        $catalogs = Catalog::all();
        $typeBudgets = TypeBudget::all();
        return view('balanceBudgets.create', compact('balanceBudget','budgets', 'catalogs', 'typeBudgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
       /* Capturamos los datos enviados por ajax */
        $balanceBudgets = $this->convertionObjeto();
        
        $catalog= Catalog::Token($balanceBudgets->catalogBalanceBudget);
        $budget= Budgets::Token($balanceBudgets->budgetBalanceBudget);
        $typeBudget= TypeBudget::Token($balanceBudgets->typeBudgetBalanceBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($balanceBudgets, 'BalanceBudget');
        $ValidationData['catalogs_id']= $catalog->id;
        $ValidationData['budgets_id']= $budget->id;
        $ValidationData['type_budgets_id']= $typeBudget->id;
        /* Declaramos las clases a utilizar */
        $balanceBudget = BalanceBudget::Token($balanceBudgets->token);
        /* Validamos los datos para guardar tabla menu */
        if ($balanceBudget->isValid($ValidationData)):
            $balanceBudget->fill($ValidationData);
            $balanceBudget->save();
             /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($balanceBudgets->statusBalanceBudget == true):
                BalanceBudget::Token($balanceBudgets->token)->restore();
            else:
                BalanceBudget::Token($balanceBudgets->token)->delete();
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($balanceBudget->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
     public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = BalanceBudget::Token($token)->delete();
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
        $data = BalanceBudget::Token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
