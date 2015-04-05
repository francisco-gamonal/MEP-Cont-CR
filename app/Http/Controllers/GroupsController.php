<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Group;
use Illuminate\Http\Request;

class GroupsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $groups = Group::all();
            return view('groups.index',  compact('groups'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
             return view('groups.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		 /* Capturamos los datos enviados por ajax */
        $Groups = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $Groups->nameGroup,'code' => $Groups->codeGroup);
        /* Declaramos las clases a utilizar */
        $group = new Group;
        /* Validamos los datos para guardar tabla menu */
        if ($group->isValid((array) $ValidationData)):
            $group->code = strtoupper($ValidationData['code']);
            $group->name = strtoupper($ValidationData['name']);
            $group->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idGroup = $group->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($Groups->statusGroup == true):
                Group::withTrashed()->find($idGroup->id)->restore();
            else:
                Group::destroy($idGroup->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($group->errors);
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
	 public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $group = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = Group::destroy($group->idGroup);
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
        $group = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = Group::onlyTrashed()->find($group->idGroup);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
       return $this->errores($data->errors);
    }

}
