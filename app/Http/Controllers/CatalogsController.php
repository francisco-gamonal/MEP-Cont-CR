<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Catalog;
use Illuminate\Http\Request;
use Mep\Models\Group;
use Crypt;
class CatalogsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
            $catalogs = Catalog::withTrashed()->get();
            return view('catalogs.index', compact('catalogs'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
            $groups = Group::all();
            return view('catalogs.create',  compact('groups'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
	/* Capturamos los datos enviados por ajax */
        $catalogs = $this->convertionObjeto();
        
        $group=  Group::Token($catalogs->groupCatalog);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($catalogs, 'Catalog');
        $ValidationData['groups_id']= $group->id;
        /* Declaramos las clases a utilizar */
        $catalog = new Catalog;
        /* Validamos los datos para guardar tabla menu */
        if ($catalog->isValid((array) $ValidationData)):
            $catalog->fill($ValidationData);
            $catalog->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idCatalogs = $catalog->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($catalogs->statusCatalog == true):
                Catalog::withTrashed()->find($idCatalogs->id)->restore();
            else:
                Catalog::destroy($idCatalogs->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($catalog->errors);
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
	public function edit($token)
	{
		$group = Group::all();
                 $catalog = Catalog::Token($token);
            return view('catalogs.edit',  compact('group','catalog'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
            /* Capturamos los datos enviados por ajax */
        $catalogs = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($catalogs, 'Catalog');
        /* Declaramos las clases a utilizar */
        $catalog = Catalog::Token( $catalogs->token);
        /* Validamos los datos para guardar tabla menu */
        if ($catalog->isValid((array)$ValidationData)):
            $catalog->fill($ValidationData);
            $catalog->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($catalogs->statusCatalog == true):
                Catalog::withTrashed()->where('token', '=', $catalogs->token)->restore();
            else:
                Catalog::destroy()->where('token', '=', $catalogs->token);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($catalog->errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	 public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Catalog::Token($token)->delete();
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
    public function active($token) {
         /* les quitamos la eliminacion pasavida */
        $data = Catalog::Token($token)->restore();
        if ($data):
          /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
       /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }
}
