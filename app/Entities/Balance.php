<?php

namespace Mep\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Entity {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'simulation', 'budget_id','balance_budget_id', 'check_id', 'transfer_code', 'transfer_balance_budget_id'];

    public function checks() {
        return $this->belongsTo(Check::getClass(), 'check_id', 'id');
    }

    public function balanceBudgets() {
        return $this->belongsTo(BalanceBudget::getClass(), 'balance_budget_id', 'id');
    }

    public function transfers() {
        return $this->belongsTo(Transfer::getClass());
    }

    public function balanceLast($type, $amount) {
        if ($this->type == $type) {
            return $this->amount + $amount;
        }

        return $this->$amount - $amount;
    }

    public function balanceTransfer($campo, $id) {
        $balances = self::where($campo, '=', $id)->where('transfer_id', '=', $transfer)->get();
        foreach ($balances as $balance):

        endforeach;
    }
    public static function BalanceBudgetActual($id){
        $balanceBudget = BalanceBudget::where('id', $id)->sum('amount', 2);
        $transferSalida = Transfer::where('balance_budget_id',$id)->where('transfers.type', 'salida')->sum('amount', 2);
        $transferEntrada = Transfer::where('balance_budget_id',$id)->where('transfers.type', 'entrada')->sum('amount', 2);
        $check = Check::where('balance_budget_id',$id)->sum('amount', 2);
        
       // $balance = ($balanceBudget+$transferEntrada) - ($transferSalida+$check);
        return $check;
    }

    public static function BalanceInicialTotal($id, $check, $spreadsheet, $checkTransfer, $codeTransfers, $type) {

        $balanceBudget = BalanceBudget::where('id', $id)->sum('amount', 2);

        /**/
        if (!empty($codeTransfers)) {
            if ($type == 'transfers'):
                $transfersEntrada = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
                                ->where('transfers.balance_budget_id', $id)
                                ->where('transfers.code', '<', $codeTransfers)
                                ->where('transfers.type', 'entrada')->sum('transfers.amount', 2);


                /**/
                $transfersSalida = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
                                ->where('transfers.balance_budget_id', $id)
                                ->where('transfers.code', '<', $codeTransfers)
                                ->where('transfers.type', 'salida')->sum('transfers.amount', 2);
            elseif ($type == 'spreadsheet'):
                $transfersEntrada = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
                                ->where('transfers.balance_budget_id', $id)
                                ->where('transfers.code', '<=', $codeTransfers)
                                ->where('transfers.type', 'entrada')->sum('transfers.amount', 2);

                /**/
                $transfersSalida = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
                                ->where('transfers.balance_budget_id', $id)
                                ->where('transfers.code', '<=', $codeTransfers)
                                ->where('transfers.type', 'salida')->sum('transfers.amount', 2);
            endif;
        }else {
            $transfersEntrada = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
                            ->where('transfers.balance_budget_id', $id)
                            ->where('transfers.type', 'entrada')->sum('transfers.amount', 2);

            /**/
            $transfersSalida = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
                            ->where('transfers.balance_budget_id', $id)
                            ->where('transfers.type', 'salida')->sum('transfers.amount', 2);
        }

        /**/
        $checkIn = Check::where('spreadsheet_id', '<', $spreadsheet->id)
                        ->where('balance_budget_id', $id)->sum('amount', 2);
        /**/
        if (!empty($check)):
            $checks = self::join('checks', 'checks.id', '=', 'balances.check_id')->where('check_id', '<', $check)
                            ->where('balances.balance_budget_id', $id)->where('date', $spreadsheet->date)->sum('balances.amount', 2);
        else:
            $checks = self::join('checks', 'checks.id', '=', 'balances.check_id')->where('spreadsheet_id', '<', $checkTransfer)
                            ->where('balances.balance_budget_id', $id)->where('date', $spreadsheet->date)->sum('balances.amount', 2);
        endif;

        $balance = ($balanceBudget + $transfersEntrada) - ($checks + $transfersSalida + $checkIn);

        return $balance;
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-11-05
    |@Date Update: 2015-00-00
    |---------------------------------------------------------------------
    |@Description: con estas consulta verificamos el saldo actual de las
    |   cuenta de los presupuestos
    |
    |----------------------------------------------------------------------
    | @return decimal
    |----------------------------------------------------------------------
    */
    public static function balanceActualAccount($id)
    {

        $balanceBudget = BalanceBudget::where('id', $id)->sum('amount', 2);
        $transfersEntrada=0;
        $transfersSalida=0;
        if($id):
            $transfersEntrada = Transfer::where('balance_budget_id', $id)
                ->where('type', 'entrada')->sum('amount', 2);
            $transfersSalida = Transfer::where('balance_budget_id', $id)
                ->where('type', 'salida')->sum('amount', 2);
        endif;

        $checkIn = Check::where('balance_budget_id', $id)->sum('amount', 2);

        $balance = ($balanceBudget + $transfersEntrada) - ($transfersSalida + $checkIn);

        return $balance;
    }
    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-00-00
    |@Date Update: 2015-00-00
    |---------------------------------------------------------------------
    |@Description:
    |
    |
    |@Pasos:
    |
    |
    |
    |
    |
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    public function isValid($data) {
        $rules = ['type' => 'required',
            'amount' => 'required',
            'simulation' => 'required',];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
