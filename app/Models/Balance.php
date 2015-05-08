<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'simulation', 'balance_budgets_id', 'checks_id', 'transfers_code','transfers_balance_budgets_id'];

    public function checks() {

        return $this->belongsTo('Mep\Models\Check');
    }

    public function balanceBudgets() {

        return $this->belongsTo('Mep\Models\BalanceBudget');
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
        $balances = Balance::where($campo, '=', $id)->where('transfers_id', '=', $transfer)->get();
        foreach ($balances AS $balance):

        endforeach;
    }
    public static function BalanceInicialTotal($id,$check){
         $balanceBudget = Balance::where('balance_budgets_id',$id)->sum('amount');
        $checks = Balance::where('checks_id','<',$check)->where('balance_budgets_id',$id)->sum('amount');
       
        $balance=$balanceBudget-$checks;
        return $balance;
    
    }

    public function isValid($data) {
        $rules = ['type' => 'required',
            'amount' => 'required',
            'simulation' => 'required'];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
