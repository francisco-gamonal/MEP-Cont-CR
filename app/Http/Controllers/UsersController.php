<?php

namespace Mep\Http\Controllers;

use Mep\Models\User;
use Mep\Models\Supplier;
use Mep\Models\TypeUser;
use Mep\Models\School;
use Mep\Models\Menu;
use Illuminate\Support\Facades\Response;
use \DB;
use Crypt;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        set_time_limit(0);
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $users = User::withTrashed()->orderBy('name', 'ASC')->get();

        return View('users.index', compact('users'));
    }

    public function indexRole()
    {
        $users = User::orderBy('name', 'ASC')->get();

        return View('roles.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $typeUsers = TypeUser::orderBy('name', 'ASC')->get();
        $schools = School::orderBy('name', 'ASC')->get();
        $menus = Menu::orderBy('name', 'ASC')->get();

        return View('users.create', compact('typeUsers', 'suppliers', 'schools', 'menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();

        /* obtenemos dos datos del supplier mediante token recuperamos el id */
        $supplier = Supplier::Token($users->tokenSupplier);
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = $this->createArray($users, $supplier);
        /* Declaramos las clases a utilizar */
        $user = new User();
        /* Validamos los datos para guardar tabla menu */
        if ($user->isValid((array) $Validation)):
            $user->name = strtoupper($Validation['name']);
        $user->last = strtoupper($Validation['last']);
        $user->email = strtoupper($Validation['email']);
        $user->password = Hash::make($Validation['password']);
        $user->type_user_id = ($Validation['type_user_id']);
        $user->supplier_id = ($Validation['supplier_id']);
        $user->token = ($Validation['token']);
        $user->save();

            /* Traemos el id del ultimo registro guardado */
            $ultimoIdUser = $user->LastId();
        $schoolsUser = $users->schoolsUser;
        for ($i = 0; $i < count($schoolsUser); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                $Relacion = user::find($ultimoIdUser['id']);
        $Relacion->schools()->attach($users->schoolsUser[$i]);
        endfor;

            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($users->statusUser == true):
                User::withTrashed()->find($ultimoIdUser->id)->restore(); else:
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
        $user = User::withTrashed()->findOrFail($id);
        $suppliers = Supplier::orderBy('name', 'ASC')->get();
        $typeUsers = TypeUser::orderBy('name', 'ASC')->get();
        $schools = School::orderBy('name', 'ASC')->get();
        $menus = Menu::orderBy('name', 'ASC')->get();

        return view('users.edit', compact('user', 'typeUsers', 'suppliers', 'schools', 'menus'));
    }

    public function editRole($id)
    {
        $user = User::find($id);
        $menus = Menu::orderBy('name', 'ASC')->get();

        return view('roles.edit', compact('user', 'menus'));
    }

    public function updateRole()
    {
        $roles = $this->convertionObjeto();
        $Menus = $roles->roles;
        $menu = user::withTrashed()->find($roles->idUser);
        $menu->Tasks()->detach();
        //echo json_encode($Menus);die;
        foreach ($Menus as $idMenu => $value):
            if(!empty($value)){
                if ($idMenu > 0):
                $statusTask = $value->statusTasks;
                for ($e = 0; $e < count($statusTask); $e++):
                       /* Comprobamos cuales estan habialitadas y esas las guardamos */
                        $Relacion = user::find($roles->idUser);
                    $Relacion->tasks()->attach($value->idTasks[$e], array('menu_id' => $idMenu, 'status' => $value->statusTasks[$e]));       
                endfor;
            endif;
            }
        endforeach;

        return $this->exito('Los datos se guardaron con exito!!!');
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
        $users = $this->convertionObjeto();
        /* obtenemos dos datos del supplier mediante token recuperamos el id */
        $supplier = Supplier::Token($users->tokenSupplier);
        /* Creamos un array para cambiar nombres de parametros */
        $Validation = array('id' => $users->idUser,
            'name' => $users->nameUser,
            'last' => $users->lastNameUser,
            'email' => $users->emailUser,
            'password' => $users->passwordUser,
            'type_user_id' => $users->idTypeUser,
            'supplier_id' => $supplier['id'], );

        $user = User::withTrashed()->findOrFail($id);
        /* Validamos los datos para guardar tabla menu */
        if ($user->isValid((array) $Validation)):

            $user->update($Validation);

        $schoolsUser = $users->schoolsUser;
        $Relacion = user::find($id);
        if (!$Relacion->schools->isEmpty()):
                 $Relacion->schools()->detach();
        endif;

        for ($i = 0; $i < count($schoolsUser); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */

                $Relacion->schools()->attach($users->schoolsUser[$i]);
        endfor;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($user->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy()
    {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /* les damos eliminacion pasavida */
        $data = User::find($users->idUser)->delete();
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
     * @param int $id
     *
     * @return Response
     */
    public function active()
    {
        /* Capturamos los datos enviados por ajax */
        $users = $this->convertionObjeto();
        /* les quitamos la eliminacion pasavida */
        $data = User::withTrashed()->find($users->idUser)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
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
    private function createArray($user, $supplier)
    {
        if ($supplier['id']):
            $users = array('name' => $user->nameUser,
                'last' => $user->lastNameUser,
                'email' => $user->emailUser,
                'password' => ($user->passwordUser),
                'type_user_id' => $user->idTypeUser,
                'supplier_id' => $supplier['id'],
                'token' => Crypt::encrypt($user->emailUser), );

        return $users;
        endif;

        $users = array('name' => $user->nameUser,
            'last' => $user->lastNameUser,
            'email' => $user->emailUser,
            'password' => ($user->passwordUser),
            'type_user_id' => $user->idTypeUser,
            'supplier_id' => null,
            'token' => Crypt::encrypt($user->emailUser), );

        return $users;
    }

    private function cargarValoresDB($Datos)
    {
        /* Declaramos las clases a utilizar */
        $suppliers = new Supplier();
        /* Validamos los datos para guardar tabla menu */
        if ($suppliers->isValid((array) $Datos)):
            $suppliers->name = strtoupper($Datos['charter']);
        $suppliers->last = strtoupper($Datos['name']);
        $suppliers->email = strtoupper($Datos['email']);
        $suppliers->password = Crypt::encrypt($Datos['password']);
        $suppliers->type_user_id = ($Datos['type_user_id']);
        $suppliers->supplier_id = ($Datos['supplier_id']);
        $suppliers->token = ($Datos['token']);
        $suppliers->save();

        return $suppliers;
        endif;

        return $suppliers->errors;
    }
}
