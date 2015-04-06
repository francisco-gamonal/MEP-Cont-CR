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
        $catalog= Budgets::Token($balanceBudgets->budgetBalanceBudget);
        $catalog= Catalog::Token($balanceBudgets->catalogBalanceBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($balanceBudgets, 'BalanceBudget');
        $ValidationData['groups_id']= $group->id;
        /* Declaramos las clases a utilizar */
        $catalog = new Catalog;
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
