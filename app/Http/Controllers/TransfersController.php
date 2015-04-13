<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Transfer;
use Illuminate\Http\Request;

class TransfersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $transfers = Transfer::withTrashed()->get();
        return view('transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $spreadsheets = Spreadsheet::orderBy('number', 'ASC')->orderBy('year', 'ASC')->get();
        $balanceBudgets = $this->arregloSelectCuenta($spreadsheets[0]->budgets_id);
        return view('transfers.create', compact('spreadsheets', 'balanceBudgets'));
    }

    /**
     * Display the specified resource.
     * Con este metodo creamos un arreglo para enviarlo a la vista asi formar el select
     * via ajax o directo a la vista
     * @param  int  $budgetsId
     * @return string
     */
    private function ArregloSelectCuenta($budgetsId) {
        $balancebudgets = BalanceBudget::where('budgets_id', '=', $budgetsId)->get();
        foreach ($balancebudgets AS $balanceBudgets):
            $balanceBudget[] = array('id' => $balanceBudgets->token,
                'value' => $balanceBudgets->catalogs->p . '-' . $balanceBudgets->catalogs->g . '-' . $balanceBudgets->catalogs->sp . ' || ' . $balanceBudgets->catalogs->name . ' || ' . $balanceBudgets->typeBudgets->name);
        endforeach;
        return $balanceBudget;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        //
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
        //
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
