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
        $menus = Menu::withTrashed()->get();
        $tasks = Task::all();
        return view('menu.index', compact('menus', 'tasks'));
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
        /* Capturamos los datos enviados por ajax */
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
                $Relacion->Tasks()->attach($menus->idTasks[$i], array('status' => $stateTasks[$i]));
            endfor;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($menu->errors);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id) {
        $menu = Menu::withTrashed()->find($id);
        return view('menu.edit', compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        /* Capturamos los datos enviados por ajax */
        $json = Input::get('data');
        $menus = json_decode($json);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $menus->nameMenu, 'url' => $menus->urlMenu);
        /* Declaramos las clases a utilizar */
        $menu = Menu::withTrashed()->find($menus->idMenu);
        $menu->Tasks()->detach();
        /* Validamos los datos para guardar tabla menu */
        if ($menu->isValid((array) $ValidationData)):
            $menu->name = ($ValidationData['name']);
            $menu->url = ($ValidationData['url']);
            $menu->save();
            /* Traemos el id del ultimo registro guardado */
            $stateTasks = $menus->stateTasks;
            /* corremos las variables boleanas para Insertar a la tabla de relación */
            for ($i = 0; $i < count($stateTasks); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                $Relacion = Menu::withTrashed()->find($menus->idMenu);
                $Relacion->Tasks()->attach($menus->idTasks[$i], array('status' => $stateTasks[$i]));
            endfor;
            /* Comprobamos si el usuario esta cambiando el estado del menu en editar */
            if (($menus->statusMenu) == false):
                Menu::destroy($menus->idMenu);
                /* Enviamos el mensaje de guardado correctamente */
                return $this->exito('Los datos se Actualizaron con exito!!!');
            endif;
            /* Activamos el menu segun la peticion del usuario */
            $menu->restore();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se Actualizaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($menu->errors);
    }

    /**
     * Remove the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $json = Input::get('data');
        $menus = json_decode($json);
        /* les damos eliminacion pasavida */
        $data = Menu::destroy($menus->idMenu);
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se desactivo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
       return $this->errores($data->errors);
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function active() {
        /* Capturamos los datos enviados por ajax */
        $json = Input::get('data');
        $menus = json_decode($json);
        /* les quitamos la eliminacion pasavida */
        $data = Menu::onlyTrashed()->find($menus->idMenu);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
       return $this->errores($data->errors);
    }

}
