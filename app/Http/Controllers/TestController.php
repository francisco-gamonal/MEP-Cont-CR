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

class TestController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
    
    
	public function index()
<<<<<<< HEAD
	{ 
            
//            $user =  User::find(3)->schools;
//  echo json_encode($user); 
	
	$user = School::find(1)->users;
	foreach ($user as  $value) {
			echo json_encode($value);
	}
//$schools = new UsersController;//
//$schools->fileJsonUpdate();

//$school = School::select('id','name')->get();
//foreach ($school AS $schools): 
//    $dataJson[]=$schools;
//endforeach;
//
// 
//$fh = fopen("json/schools.json", 'w')
//      or die("Error al abrir fichero de salida");
//fwrite($fh, json_encode($dataJson,JSON_UNESCAPED_UNICODE));
//fclose($fh);
=======
	{ 	
		$user = User::find(1);
>>>>>>> origin/master

		echo $user->nameSchools($user->schools);
		

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
