<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Menu;
use Illuminate\Http\Request;
use \Mep\Models\Tasks;
class MenuController extends Controller {

	
        /**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		//$this->middleware('auth');
	}
        /**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
                $json = Menu::all();
		return view('menu/index',  json_encode($json));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
                $json = Tasks::all();
		return view('menu/create',  json_encode($json));
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
		$json = Menu::find($id);
		return view('menu/edit',  json_encode($json));
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
