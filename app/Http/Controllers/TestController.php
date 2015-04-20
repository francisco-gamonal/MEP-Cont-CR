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

class TestController extends Controller {

   protected $auth;
    
   public function __construct(Guard $auth)
	{
		$this->auth = $auth;
	}
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        
    $test = Check::find(1);
        
        echo json_encode($test->BalanceTotal(8,'2015-04-30','<='));
//        
//        $a = array();
//        $ac = 1;
//        try {
//            DB::beginTransaction();
//            Transfer::all();
//            $a[0] = 1 + $ac;
//            DB::commit();
//            /*DB::transaction(function() use ($ac){
//                Transfer::all();
//                $a[0] = 1 + $ac;
//            });*/
//        } catch (Exception $e) {
//            $e;
//            DB::rollback();
//        }
//        echo json_encode($a);die;
//       $transfers = Transfer::max('code');
//        
//       echo json_encode($transfers); die;
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
