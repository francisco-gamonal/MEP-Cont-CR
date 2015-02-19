<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class BalanceBudgets extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'amount' => 'required',
        'policies' => 'required',
        'strategic' => 'required',
        'operational' => 'required',
        'goals' => 'required',
        'budgets_id' => 'required',
        'catalogs_id' => 'required',
        'type_budgets_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['amount', 'policies', 'strategic', 'operational', 'goals', 'budgets_id', 'catalogs_id', 'type_budgets_id'];

    public function checks() {

        return $this->HasMany('Check', 'id', 'checks_id');
    }

    public function balanceBudgets() {

        return $this->HasMany('balance_budgets', 'id', 'balance_budgets_id');
    }

    public function transfers() {

        return $this->HasMany('transfers', 'id', 'transfers_id');
    }

}
