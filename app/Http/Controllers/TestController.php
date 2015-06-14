<?php

namespace Mep\Http\Controllers;


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
       
      
      
      echo $this->convertir_a_letras(999999999.99);
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
