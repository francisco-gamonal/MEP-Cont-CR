<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\TypeUser;
use Illuminate\Http\Request;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;

class TypeUsersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$typeUser = TypeUser::withTrashed()->get();
		return view('typeUser.index',  compact('typeUser'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('typeUser.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/* Capturamos los datos enviados por ajax */
        $json = Input::get('data');
        $typeUser = json_decode($json);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = array('name' => $typeUser->name_type_user);
        
        /* Declaramos las clases a utilizar */
        $typeUsers = new TypeUser;
        /* Validamos los datos para guardar tabla menu */
        if ($typeUsers->isValid((array) $ValidationData)):
            $typeUsers->name = ($ValidationData['name']);
            $typeUsers->save();
            $newType = $typeUsers->LastId();
           
             /**/
        if ($typeUser->state_type_user == true):
            TypeUser::withTrashed()->find($newType->id)->restore();
        else:
            TypeUser::destroy($newType->id);
        endif;
           /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($typeUsers->errors);
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
