<?php namespace Mep\Http\Controllers;

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
use Crypt;
class TestController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
    
	public function index()
	{
            
            $test = Spreadsheet::orderBy('number','ASC')->orderBy('year','ASC')->get();
            $spreadsheets = Spreadsheet::orderBy('number','ASC')->orderBy('year','ASC')->get();
        $test = BalanceBudget::where('budgets_id','=',$spreadsheets[0]->budgets_id)->get();
            echo json_encode($test);
//		$menus = Menu::all();
//		$user = User::find(2);
//
//		if($user->Tasks->isEmpty()) {
//			echo "OK";die;
//		}
//		echo "False";
//		die;
//
//		foreach($menus as $menu):
//			echo "{".$menu->id;
//			foreach($menu->Tasks as $taskMenu):
//				if($taskMenu->pivot->status == 1){
//					foreach ($user->Tasks as $taskUser) {
//						if($menu->id == $taskUser->pivot->menu_id && $taskMenu->id == $taskUser->pivot->task_id && $taskUser->pivot->status == 1){
//							echo "$taskMenu->id";
//						}
//					}
//					//echo '//id:'.$taskMenu->id.', name:'.$taskMenu->name;
//				}
//			endforeach;
//			echo "}";
//        endforeach;
                
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
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
