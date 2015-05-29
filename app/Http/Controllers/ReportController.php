<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Mep\Models\Budget;
use Mep\Models\BalanceBudget;
use Mep\Models\Catalog;

class ReportController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $budget = Budget::find(1);
        $balanceBudgets = BalanceBudget::where('budget_id', $budget->id)->get();

        $catalogsBudget = $this->catalogsBudget($budget, $balanceBudgets);
        return view('reports.budget.content', compact('budget', 'balanceBudgets', 'catalogsBudget'));
    }

}
