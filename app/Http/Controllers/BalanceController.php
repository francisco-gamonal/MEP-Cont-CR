<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Balance;
use Illuminate\Http\Request;

class BalanceController extends Controller {

    public static function saveBalance($amount, $type, $simulation, $table, $id, $status) {

        $ValidationData = array('type' => $type, 'amount' => $amount, 'simulation' => $simulation, $table => $id);

        $balance = new Balance;
        /* Validamos los datos para guardar tabla menu */
        if ($balance->isValid($ValidationData)):
            $balance->fill($ValidationData);
            $balance->save();
            if ($status == true): 
                Balance::withTrashed()->find($id)->restore();
            else:
                Balance::destroy($id);
            endif;
        endif;
    }

    public static function editBalance($amount, $type, $simulation, $id, $status) {

        $ValidationData = array('type' => $type, 'amount' => $amount, 'simulation' => $simulation);


        $balance = Balance::withTrashed()->find($id);
        /* Validamos los datos para guardar tabla menu */
        if ($balance->isValid($ValidationData)):
            $balance->fill($ValidationData);
            $balance->save();
            if ($status == true): 
                Balance::withTrashed()->find($id)->restore();
            else:
                Balance::destroy($id);
            endif;
        endif;
    }

}
