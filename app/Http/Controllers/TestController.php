<?php

namespace Mep\Http\Controllers;


use Mep\Models\User;
use Mep\Models\BalanceBudget;
use Mep\Models\Transfer;
use Mep\Models\Spreadsheet;
use Illuminate\Contracts\Auth\Guard;
use DOMPDF;

// disable DOMPDF's internal autoloader if you are using Composer
define('DOMPDF_ENABLE_AUTOLOAD', false);

// include DOMPDF's default configuration
require_once '../vendor/dompdf/dompdf/dompdf_config.inc.php';

class TestController extends Controller
{
    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $menus = \Html::menu();
        foreach ($menus as $key => $value) {
            foreach ($value['tasks'] as $task) {
                 echo $task['name'];
             }
        }die;
        $temp     = null;
        $tempKey  = array();
        $tempData = array();
        foreach (\Auth::user()->menus as $menu) {
            //echo json_encode($menu->pivot);die;
            //$a[] = $menu->tasksActive;
            //echo json_encode($menu->tasksActive);
            if($temp != $menu->id){
                //echo $menu->name.'<br>';
                $temp = $menu->id;
                /*if($menu->id == 1){
                    echo json_encode($menu->tasksActive);die;
                }*/
                if(count($menu->tasksActive($menu->pivot->user_id)->select('name')->get()) > 0)
                    $tempKey[$menu->name] = $menu->tasksActive($menu->pivot->user_id)->select('name')->get();
                //echo json_encode($tempKey);die;
            }
            /*if($menu->pivot->status == 1){
                $task = Task::find($menu->pivot->task_id);
                $tempData[] = $task->name;
                //echo $task->name.'<br>';
            }*/
        }
        foreach ($tempKey as $key => $task) {
            echo $key;
            foreach ($task as $value) {
                echo '<br>'.$value->name;
            }
            echo '<br>';
        }
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
}
