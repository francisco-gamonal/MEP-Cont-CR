<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\BalanceBudgets;
use Illuminate\Http\Request;
use Mep\Models\Catalog;
use Mep\Models\TypeBudget;

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
