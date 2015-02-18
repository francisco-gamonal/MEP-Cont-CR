<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class Transfers extends Model {

    use SoftDeletingTrait;

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
    protected $fillable = ['amount', 'type', 'date', 'status', 'balance_budgets_id', 'spreadsheets_id'];

    public function spreadsheets() {

        return $this->HasMany('Spreadsheets', 'id', 'spreadsheets_id');
    }

    public function balanceBudgets() {

        return $this->HasMany('BalanceBudgets', 'id', 'balance_budgets_id');
    }

}
