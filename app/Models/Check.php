<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Check extends Model {

   use SoftDeletes;

  
    // Don't forget to fill this array
    protected $fillable = ['bill', 'concept', 'amount', 'retention', 'ckbill', 'ckretention','record','date','simulation', 'token','vouchers_id','balance_budgets_id','spreadsheets_id','suppliers_id'];

    public function vouchers() {

        return $this->HasOne('Mep\Models\Vouchers');
    }

    public function balanceBudgets() {

        return $this->belongsTo('Mep\Models\balance_budgets');
    }

    public function spreadsheets() {

        return $this->belongsTo('Mep\Models\Spreadsheets');
    }
    public function suppliers() {

        return $this->HasOne('Mep\Models\Supplier');
    }
      public function LastId() {
        return Check::all()->last();
    }

    public static function Token($token) {
        $budgets = Check::withTrashed()->where('token', '=', $token)->get();
        if ($budgets):
            foreach ($budgets AS $budget):
                return $budget;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = [
        'bill' => 'required',
        'concept' => 'required',
        'amount' => 'required',
        'ckbill' => 'required',
        'record' => 'required',
        'date' => 'required',
        'simulation' => 'required',
        'balance_budgets_id' => 'required',
        'spreadsheets_id' => 'required',
        'suppliers_id' => 'required'];

        $validator = \Validator::make($data, $rules);
       
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
