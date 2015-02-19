<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Menu;
use Mep\Models\Task;
use Illuminate\Http\Request;

class MenuController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        //$this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $lista = Menu::all();
        return view('menu/index', json_encode($lista));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $tasks = Task::all();
        return view('menu/create', json_encode($tasks));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        $json = Input::get('data');
        $data = json_decode($json);
        $Menu = new Menu;
        $Relacion = new TaskHasMenu;
        
        if ($Menu->isValid((array) $menus)):
            $Menu->name = Str::upper($menus->name);
            $Menu->save();
            return 1;
        endif;
        
        if ($Relacion->isValid((array) $data)):
            $Relacion->name = Str::upper($data->name);
            $Relacion->save();
            return 1;
        endif;

        if (Request::ajax()):
            return Response::json([
                        'success' => false,
                        'errors' => $Menu->errors
            ]);
        else:
            return Redirect::back()->withErrors($Menu->errors)->withInput();
        endif;
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
        $json = Menu::find($id);
        return view('menu/edit', json_encode($json));
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
