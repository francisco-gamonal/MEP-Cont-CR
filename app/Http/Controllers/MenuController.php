<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Menu;
use Mep\Models\Task;
use Illuminate\Http\Request;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;

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
        $tasks = Task::all();
        return view('menu.index', compact($lista,$tasks));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $tasks = Task::all();
        return view('menu.create')->with('tasks', $tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     * 
     */
    public function store() {
        $json = Input::get('data');
        $menus = json_decode($json);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $menus->nameMenu, 'url' => $menus->urlMenu);
               /* Declaramos las clases a utilizar */
        $menu = new Menu;
        /* Validamos los datos para guardar tabla menu */
        if ($menu->isValid((array) $ValidationData)):
            $menu->name = ($ValidationData['name']);
            $menu->url = ($ValidationData['url']);
            $menu->save();
            /* Traemos el id del ultimo registro guardado */
            $ultimoInsert = $menu->LastId();
            $stateTasks = $menus->stateTasks;
            /* corremos las variables boleanas para Insertar a la tabla de relación */
            for ($i = 0; $i < count($stateTasks); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                
                    $Relacion = Menu::find($ultimoInsert['id']);
                    $Relacion->Tasks()->attach($menus->idTasks[$i],array('status'=>$stateTasks[$i]));
            
            endfor;
            /* Enviamos el mensaje de guardado correctamente */
            return     Response::json([
                        'success' => TRUE,
                        'message' => 'Los datos se guardaron con exito!!!'
            ]);
        endif;
       /* Enviamos el mensaje de error */
        return Response::json([
                    'success' => false,
                    'errors' => $menu->errors
        ]);
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
        return view('menu.edit', compact($json));
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
