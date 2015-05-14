<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\School;
use Mep\Models\TypeUser;
use Mep\Models\User;
use Illuminate\Http\Request;
use Mep\Models\Menu;
use Mep\Models\Task;
use Mep\Models\TasksHasMenu;
use Mep\Models\Supplier;
use Mep\Models\Catalog;
use Mep\Models\Group;
use Mep\Models\Budget;
use Mep\Models\BalanceBudget;
use Mep\Models\Spreadsheet;
use Mep\Models\Check;
use Mep\Models\Transfer;
use Illuminate\Contracts\Auth\Guard;
use Crypt;
use Illuminate\Support\Facades\DB;
use Mep\Models\Balance;
use DOMPDF;
use Maatwebsite\Excel\Excel;

// disable DOMPDF's internal autoloader if you are using Composer
define('DOMPDF_ENABLE_AUTOLOAD', false);

// include DOMPDF's default configuration
require_once '../vendor/dompdf/dompdf/dompdf_config.inc.php';

class TestController extends Controller {

    protected $auth;

    public function __construct(Guard $auth) {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        $typeBudgetQ = BalanceBudget::balanceInitial(15);
        
//        $budget = Budget::find(1);
//        $balanceBudgets = BalanceBudget::where('budgets_id', $budget->id)->get();
//        foreach ($balanceBudgets AS $catalog):
//            $typeBudgetQ[$catalog->catalogs->id] =array('c' => $catalog->catalogs->c, 'sc' => $catalog->catalogs->sc, 'g' => $catalog->catalogs->g, 'sg' => $catalog->catalogs->sg,
//                'p' => $catalog->catalogs->p, 'sp' => $catalog->catalogs->sp, 'r' => $catalog->catalogs->r, 'sr' => $catalog->catalogs->sr, 'f' => $catalog->catalogs->f,
//                'name' => $catalog->catalogs->name,
//                'type' => $catalog->catalogs->type,
//                'typeBudget' => $this->amountTypeBudget($budget, $catalog));
//                       //$typeBudget[0] => number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget[0]), 0),
//                        //$typeBudget[1] => number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget[1]), 0),
//                       // $typeBudget[2] => number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget[2]), 0));
//         
//        endforeach;
            //$var = array_unique($typeBudgetQ, SORT_REGULAR);       
            echo json_encode($typeBudgetQ->balances->amount);
            
//        foreach ($budget->groups AS $group):
//            $balance =  BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
//                        ->where('balance_budgets.budgets_id', $budget->id)
//                        ->where('catalogs.groups_id', $group->id)
//                        ->where('catalogs.type', 'ingresos')->get();
//            //  echo   json_encode($budget->groups[0]);
//            foreach ($balance AS $balances):
//
//
//                echo json_encode($balances);
//
//            endforeach;
//        endforeach;
    }
    
    private function amountTypeBudget($budget, $catalog){
        foreach($budget->typeBudgets as $typeBudget){
            $a[$typeBudget->id] = number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id));
        }
        return $a;
    }

    private function balanceTypeBudget($budget, $catalog, $type) {
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
    public function create() {
        //
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
