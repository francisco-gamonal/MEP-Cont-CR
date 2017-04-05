<?php

namespace Mep\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Response;
use Input;
use Crypt;

abstract class Controller extends BaseController
{
    use DispatchesCommands,
        ValidatesRequests;

    public function __construct() {
         set_time_limit(0);
    }
    /* Con estos methodos enviamos los mensajes de exito en cualquier controlador */

    public function exito($data)
    {
        return Response::json([
                    'success' => true,
                    'message' => $data,
        ]);
    }

    /* Con estos methodos enviamos los mensajes de error en cualquier controlador */

    public function errores($data)
    {
        return Response::json([
                    'success' => false,
                    'errors' => $data,
        ]);
    }

    /**
     * @return type
     */
    public function convertionObjeto()
    {
        $datos = Input::get('data');
        $DatosController = json_decode($datos);

        return $DatosController;
    }

    public function CreacionArray($data, $delimiter, $attr_token = NULL)
    {
        foreach ($data as $key => $value):
            $newKey = explode($delimiter, $key);
            $keyNew = ($newKey[0]);
            $newArreglo[$keyNew] = $value;
        endforeach;

        if (empty($newArreglo['token'])):
            if($attr_token){
                $newArreglo['token'] = Crypt::encrypt($newArreglo[$attr_token]);
            }else{
                if (isset($newArreglo['name'])):
                    $newArreglo['token'] = Crypt::encrypt($newArreglo['name']);
                    return $newArreglo; 
                elseif (isset($newArreglo['amount'])):
                    $newArreglo['token'] = Crypt::encrypt($newArreglo['amount']);
                    return $newArreglo; 
                elseif (isset($newArreglo['code'])):
                    $newArreglo['token'] = Crypt::encrypt($newArreglo['code']);
                    return $newArreglo;
                endif;

                $newArreglo['token'] = Crypt::encrypt($newArreglo['date']);
                return $newArreglo;
            }
        endif;

        return $newArreglo;
    }
}
