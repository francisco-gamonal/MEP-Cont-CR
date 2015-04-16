<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'simulation', 'balance_budgets_id', 'checks_id', 'transfers_id'];

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
        if ($this->type == 'entrada') {
            return $this->amount + $amount;
        }
        return $this->$amount - $amount;
    }

    public function balanceTransfer($campo, $id) {
        $balances = Balance::where($campo, '=', $id)->where('transfers_id', '=', $transfer)->get();
        foreach ($balances AS $balance):

        endforeach;
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
