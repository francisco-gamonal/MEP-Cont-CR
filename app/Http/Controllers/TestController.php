<?php

namespace Mep\Http\Controllers;


use Mep\Models\Balance;
use Mep\Models\Budget;
use Mep\Models\User;
use Mep\Models\BalanceBudget;
use Mep\Models\Transfer;
use Mep\Models\Spreadsheet;
use Illuminate\Contracts\Auth\Guard;
use DOMPDF;
use Input;
use Illuminate\Support\Facades\Response;
use Mep\Http\Controllers\validatorController;

class TestController extends validatorController
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        set_time_limit(0);
        $this->middleware('auth');
    }

    public function validateReportBudget()
    {
        $data = Input::get('data');
        return Response::json([
            'success' => true,
            'message' => $data,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {



        echo $this->BudgetBalance();
    }
    private function BudgetBalance(){
        $budgets = Budget::all();
        foreach($budgets AS $budget):
            $balances=  Balance::withTrashed()->select('balances.id')
                ->join('checks','checks.id','=','balances.check_id')
                ->join('balance_budgets','balance_budgets.id','=','checks.balance_budget_id')->where('balance_budgets.budget_id',$budget->id)->get();
            foreach($balances AS $balance):
                Balance::withTrashed()->where('id',$balance->id)->update(['budget_id'=>$budget->id]);
            endforeach;
        endforeach;
    }
    private function amountTypeBudget($budget, $catalog)
    {
        foreach ($budget->typeBudgets as $typeBudget) {
            $a[$typeBudget->id] = number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id));
        }

        return $a;
    }

    private function balanceTypeBudget($budget, $catalog, $type)
    {
        $amountBalanceBudget = BalanceBudget::where('balance_budgets.budgets_id', $budget)
            ->where('balance_budgets.catalogs_id', $catalog)
            ->where('balance_budgets.types_budgets_id', $type)->sum('amount');

        return $amountBalanceBudget;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function reportValidation($token) {

    }

    public function tableValidation($token) {

    }

    public function valitation($token) {

    }

}
