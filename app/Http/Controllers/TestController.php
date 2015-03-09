<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\School;
use Mep\Models\TypeUser;
use Mep\Models\User;
use Mep\Models\SchoolsHasUser;
use Illuminate\Http\Request;
use Mep\Models\Menu;
use Mep\Models\Task;
use Mep\Models\TasksHasMenu;

class TestController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{   
                 $json =  User::find(2);
                //$json =SchoolsHasUser::all();
                //$json = User::all();
		 //$json = TypeUser::all();
		//$json = School::all();
            echo json_encode($json->typeUsers); die;
//         dd($json->Tasks()); die;
//                foreach ($json->TasksMenus() AS $test):
//                      echo $test.'\n';
//                endforeach;
//                .das
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
