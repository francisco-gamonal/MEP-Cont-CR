<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Check extends Model {

   use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'bill' => 'required',
        'concept' => 'required',
        'amount' => 'required',
        'retention' => 'required',
        'ckbill' => 'required',
        'ckretention' => 'required',
        'record' => 'required',
        'date' => 'required',
        'status' => 'required',
        'balance_budgets_id' => 'required',
        'spreadsheets_id' => 'required',
        'suppliers_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['bill', 'concept', 'amount', 'retention', 'ckbill', 'ckretention','record','date','status','vouchers_id','balance_budgets_id','spreadsheets_id','suppliers_id'];

    public function vouchers() {

        return $this->HasMany('Vouchers', 'id', 'vouchers_id');
    }

    public function balanceBudgets() {

        return $this->HasMany('balance_budgets', 'id', 'balance_budgets_id');
    }

    public function spreadsheets() {

        return $this->HasMany('Spreadsheets', 'id', 'spreadsheets_id');
    }
    public function suppliers() {

        return $this->HasMany('Suppliers', 'id', 'suppliers_id');
    }
}
