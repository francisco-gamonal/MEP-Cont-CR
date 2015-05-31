<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'simulation', 'balance_budget_id', 'check_id', 'transfer_code','transfer_balance_budget_id'];

    public function checks()
    {
        return $this->belongsTo('Mep\Models\Check', 'check_id', 'id');
    }

    public function balanceBudgets()
    {
        return $this->belongsTo('Mep\Models\BalanceBudget', 'balance_budget_id', 'id');
    }

    public function transfers()
    {
        return $this->belongsTo('Mep\Models\Transfer');
    }

    public function balanceLast($type, $amount)
    {
        if ($this->type == $type) {
            return $this->amount + $amount;
        }

        return $this->$amount - $amount;
    }

    public function balanceTransfer($campo, $id)
    {
        $balances = self::where($campo, '=', $id)->where('transfer_id', '=', $transfer)->get();
        foreach ($balances as $balance):

        endforeach;
    }
    public static function BalanceInicialTotal($id, $check, $spreadsheet, $checkTransfer)
    {
        $balanceBudget = self::where('balance_budget_id', $id)->sum('amount');

        /**/

       $transfersEntrada = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
               ->where('transfers.balance_budget_id', $id)->where('transfers.type', 'entrada')->sum('transfers.amount');

       /**/
       $transfersSalida = Transfer::where('transfers.spreadsheet_id', '<=', $spreadsheet->id)
               ->where('transfers.balance_budget_id', $id)->where('transfers.type', 'salida')->sum('transfers.amount');
       /**/
        /**/
         if (!empty($check)):
        $checks = self::join('checks', 'checks.id', '=', 'balances.check_id')->where('check_id', '<', $check)
                ->where('balances.balance_budget_id', $id)->where('date', $spreadsheet->date)->sum('balances.amount'); else:
        $checks = self::join('checks', 'checks.id', '=', 'balances.check_id')->where('spreadsheet_id', '<', $checkTransfer)
                ->where('balances.balance_budget_id', $id)->where('date', $spreadsheet->date)->sum('balances.amount');
        endif;
        $balance = ($balanceBudget + $transfersEntrada) - ($checks + $transfersSalida);

        return $balance;
    }

    public function isValid($data)
    {
        $rules = ['type' => 'required',
            'amount' => 'required',
            'simulation' => 'required', ];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
