<?php

namespace Mep\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Response;

abstract class Controller extends BaseController {

    use DispatchesCommands,
        ValidatesRequests;
    
    /* Con estos methodos enviamos los mensajes de exito en cualquier controlador */

    public function exito($data) {
        return Response::json([
                    'success' => TRUE,
                    'message' => $data
        ]);
    }

    /* Con estos methodos enviamos los mensajes de error en cualquier controlador */

    public function errores($data) {
        return Response::json([
                    'success' => FALSE,
                    'errors' => $data
        ]);
    }

}
