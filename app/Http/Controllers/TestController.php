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
    
   public function __construct(Guard $auth)
	{
		//$this->auth = $auth;
	}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
        $budget = Budget::find(1);
        $balance = BalanceBudget::where('budgets_id',$budget->id)->get();
      //  echo   json_encode($budget->groups[0]);
    foreach($budget->groups AS $balances):
       
        if($balances->type=='ingresos'):
         echo   json_encode($balances->name);
        endif;
    endforeach;
      
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
