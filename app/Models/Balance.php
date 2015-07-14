<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'simulation', 'budget_id','balance_budget_id', 'check_id', 'transfer_code', 'transfer_balance_budget_id'];

    public function checks() {
        return $this->belongsTo('Mep\Models\Check', 'check_id', 'id');
    }

    public function balanceBudgets() {
        return $this->belongsTo('Mep\Models\BalanceBudget', 'balance_budget_id', 'id');
    }

    public function transfers() {
        return $this->belongsTo('Mep\Models\Transfer');
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
