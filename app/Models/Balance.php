<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'type' => 'required',
        'amount' => 'required',
        'status' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'status', 'balance_budgets_id', 'checks_id', 'transfers_id'];

    public function checks() {

        return $this->HasMany('Check', 'id', 'checks_id');
    }

    public function balanceBudgets() {

        return $this->HasMany('BalanceBudgets', 'id', 'balance_budgets_id');
    }
    public function transfers() {

        return $this->HasMany('transfers', 'id', 'transfers_id');
    }
}
