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
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $budget = Budget::find(1);
        $balanceBudgets = BalanceBudget::where('budgets_id', $budget->id)->get();
        return view('reports.budget.content', compact('budget', 'balanceBudgets'));
    }

  
}