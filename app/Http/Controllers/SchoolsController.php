<?php

namespace Mep\Http\Controllers;

use Mep\Models\School;
use Illuminate\Support\Facades\Response;

class SchoolsController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $schools = School::withTrashed()->orderBy('name', 'ASC')->get();

        return View('schools.index', compact('schools'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return View('schools.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($schools, 'School');

        /* Declaramos las clases a utilizar */
        $saveSchools = new School();
        /* Validamos los datos para guardar tabla menu */
        if ($saveSchools->isValid($Validation)):
            $saveSchools->fill($Validation);
        $saveSchools->save();
            /* Traemos el id del ultimo registro guardado */
            $ultimoIdSchools = $saveSchools->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($schools->statusSchool == true):
                School::withTrashed()->find($ultimoIdSchools->id)->restore(); else:
                School::destroy($ultimoIdSchools->id);
        endif;
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($saveSchools->errors);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $school = School::withTrashed()->find($id);

        return View('schools.edit', compact('school'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update($id)
    {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->CreacionArray($schools, 'School');
        /* Declaramos las clases a utilizar */
        $saveSchools = School::withTrashed()->find($schools->idSchool);
        /* Validamos los datos para guardar tabla menu */
        if ($saveSchools->isValid($Validation)):
            $saveSchools->fill($Validation);
        $saveSchools->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($schools->statusSchool == true):
                School::withTrashed()->find($schools->idSchool)->restore(); else:
                School::destroy($schools->idSchool);
        endif;
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($saveSchools->errors);
    }

    /**
     * Creamos el array para la validacion con los
     * nombre de los campos.
     *
     * @param type $user
     * @param type $supplier
     *
     * @return type
     */
    private function createArray($schools)
    {
        $school = array('name' => $schools->nameSchool,
            'charter' => $schools->charterSchool,
            'circuit' => $schools->circuitSchool,
            'code' => ($schools->codeSchool),
            'ffinancing' => $schools->ffinancingSchool,
            'president' => $schools->presidentSchool,
            'secretary' => $schools->secretarySchool,
            'account' => $schools->accountSchool,
            'title_1' => $schools->titleOneSchool,
            'title_2' => ($schools->titleTwoSchool), );

        return $school;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = School::find($id);
        if ($data):
            $data->delete();
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se desactivo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function active($id)
    {
        /* Capturamos los datos enviados por ajax */
        $schools = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = School::withTrashed()->find($id)->restore();

        if ($data):
            /* Con este methodo creamos el archivo Json */
            $this->fileJsonUpdate();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    public function fileJsonUpdate()
    {
        /* Buscamos todos los datos de school y traemos solo el id y el name */
        $school = School::select('id', 'name')->get();
        $dataJson = '';
        foreach ($school as $schools):
            $dataJson[] = array('value' => $schools->id, 'text' => $schools->name);
        endforeach;

        $fh = fopen('json/schools.json', 'w')
                or die('Error al abrir fichero de salida');
        fwrite($fh, json_encode($dataJson, JSON_UNESCAPED_UNICODE));
        fclose($fh);
    }
}
