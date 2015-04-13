<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transfer extends Model {

    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'amount' => 'required',
        'type' => 'required',
        'date' => 'required',
        'status' => 'required',
        'balance_budgets_id' => 'required',
        'spreadsheets_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['amount', 'type', 'date', 'simulacion','token', 'balance_budgets_id', 'spreadsheets_id'];

    public function spreadsheets() {

        return $this->belongsTo('Spreadsheets', 'id', 'spreadsheets_id');
    }

    public function balanceBudgets() {

        return $this->belongsTo('BalanceBudgets', 'id', 'balance_budgets_id');
    }

}
