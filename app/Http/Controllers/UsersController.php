<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\User;
use Mep\Models\Supplier;
use Mep\Models\TypeUser;
use Mep\Models\School;
use Illuminate\Http\Request;
use Input;
use Illuminate\Validation;
use Illuminate\Support\Facades\Response;
use Crypt;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $users = User::withTrashed()->orderBy('name', 'ASC')->get();
        return View('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $typeUsers = TypeUser::orderBy('name', 'ASC')->get();
        $schools = School::orderBy('name', 'ASC')->get();
        return View('users.create', compact('typeUsers', 'suppliers','schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        
        /*obtenemos dos datos del supplier mediante token recuperamos el id*/
        $supplier = Supplier::Token($users->tokenSupplier);
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->createArray($users, $supplier);
        /* Declaramos las clases a utilizar */
        $user = new User;
        /* Validamos los datos para guardar tabla menu */
        if ($user->isValid((array) $Validation)):
            $user->name = strtoupper($Validation['last']);
            $user->last = strtoupper($Validation['name']);
            $user->email = strtoupper($Validation['email']);
            $user->password = Hash::make($Validation['password']);
            $user->type_users_id = ($Validation['type_users_id']);
            $user->suppliers_id = ($Validation['suppliers_id']);
            $user->token = ($Validation['token']);
            $user->save();

           /* Traemos el id del ultimo registro guardado */
            $ultimoIdUser = $user->LastId();
            //
            $ultimoIdUser->Tasks()->attach($users->idTypeUser);
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($users->statusUser == true):
                User::withTrashed()->find($ultimoIdUser->id)->restore();
            else:
                User::destroy($ultimoIdUser->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($user->errors);
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
        $users = User::Token($id);
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $typeUsers = TypeUser::orderBy('name', 'ASC')->get();
        return view('suppliers.edit', compact('users', 'typeUsers', 'suppliers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /*obtenemos dos datos del supplier mediante token recuperamos el id*/
        $supplier = Supplier::Token($users->tokenSupplier);
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->createArray($users, $supplier);
        /* Declaramos las clases a utilizar */
        $user = new User;
        /* Validamos los datos para guardar tabla menu */
        if ($user->isValid((array) $Validation)):
            $user->name = strtoupper($Validation['last']);
            $user->last = strtoupper($Validation['name']);
            $user->email = strtoupper($Validation['email']);
            $user->password = Hash::make($Validation['password']);
            $user->type_users_id = ($Validation['type_users_id']);
            $user->suppliers_id = ($Validation['suppliers_id']);
            $user->token = ($Validation['token']);
            $user->save();
             /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($users->statusUser == true):
                User::token($users->tokenUser)->restore();
            else:
                User::token($users->tokenUser)->delete();
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($user->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy() {
        /* Capturamos los datos enviados por ajax */
        $users=$this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = User::token($users->tokenUser)->delete();
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
        $users = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = User::token($users->tokenUser)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    /**
     * Creamos el array para la validacion con los
     * nombre de los campos
     * @param type $user
     * @param type $supplier
     * @return type
     */
    private function createArray($user, $supplier) {
        if ($supplier['id']):
            $users = array('name' => $user->nameUser,
            'last' => $user->lastNameUser,
            'email' => $user->emailUser,
            'password' => ($user->passwordUser),
            'type_users_id' => $user->idTypeUser,
            'suppliers_id' => $supplier['id'],
            'token' => Crypt::encrypt($user->emailUser));
        return $users;
        endif;
        $users = array('name' => $user->nameUser,
            'last' => $user->lastNameUser,
            'email' => $user->emailUser,
            'password' => ($user->passwordUser),
            'type_users_id' => $user->idTypeUser,
            'suppliers_id' => null,
            'token' => Crypt::encrypt($user->emailUser));
        return $users;
    }


    private function cargarValoresDB($Datos) {
        /* Declaramos las clases a utilizar */
        $suppliers = new Supplier;
        /* Validamos los datos para guardar tabla menu */
        if ($suppliers->isValid((array) $Datos)):
            $suppliers->name = strtoupper($Datos['charter']);
            $suppliers->last = strtoupper($Datos['name']);
            $suppliers->email = strtoupper($Datos['email']);
            $suppliers->password = Crypt::encrypt($Datos['password']);
            $suppliers->type_users_id = ($Datos['type_users_id']);
            $suppliers->suppliers_id = ($Datos['suppliers_id']);
            $suppliers->token = ($Datos['token']);
            $suppliers->save();
            return $suppliers;
        endif;

        return $suppliers->errors;
    }

}
