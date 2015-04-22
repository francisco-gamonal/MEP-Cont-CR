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
                self::Desactivar('balance_budgets_id', $id);
            else:
                self::active('balance_budgets_id', $id);
            endif;
        endif;
    }

    public static function saveBalanceTransfers($amount, $type, $simulation,  $id, $balanceBudget) {

        $ValidationData = array('type' => $type, 'amount' => $amount, 'simulation' => $simulation,
            'transfers_balance_budgets_id' => $balanceBudget,
            'transfers_code' => $id);

        $balance = new Balance;
        /* Validamos los datos para guardar tabla menu */
        if ($balance->isValid($ValidationData)):
            $balance->fill($ValidationData);
            $balance->save();
        endif;
    }

    public static function updateBalanceTransfers($amount, $type, $simulation, $id, $balanceBudget) {

        $ValidationData = array('type' => $type, 'amount' => $amount, 'simulation' => $simulation,
            'transfers_balance_budgets_id' => $balanceBudget,
            'transfers_code' => $id);
        $balanceId = Balance::where('transfers_balance_budgets_id', $balanceBudget)->where('transfers_code', $id)->get();
        $balance = Balance::find($balanceId[0]->id);
        /* Validamos los datos para guardar tabla menu */
        if ($balance->isValid($ValidationData)):
             
            $balance->fill($ValidationData);
            $balance->save();
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public static function desactivar($campo, $id) {
        /* les damos eliminacion pasavida */
        Balance::where($campo, '=', $id)->delete();
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public static function active($campo, $id) {
        /* les quitamos la eliminacion pasavida */
        Balance::where($campo, '=', $id)->restore();
    }

}
