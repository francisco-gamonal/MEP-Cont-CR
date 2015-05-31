<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BalanceBudget extends Model
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['amount', 'policies', 'strategic', 'operational', 'goals', 'budget_id', 'catalog_id', 'token', 'simulation', 'type_budget_id'];

    public function checks()
    {
        return $this->HasMany('Mep\Models\Check', 'check_id', 'id');
    }

    public function catalogs()
    {
        return $this->belongsTo('Mep\Models\Catalog', 'catalog_id', 'id');
    }

    public function budgets()
    {
        return $this->belongsTo('Mep\Models\Budget', 'budget_id', 'id');
    }
    public function balances()
    {
        return $this->hasMany('Mep\Models\Balance', 'balance_budget_id', 'id');
    }

    public function typeBudgets()
    {
        return $this->belongsTo('Mep\Models\TypeBudget', 'type_budget_id', 'id');
    }

    public function transfers()
    {
        return $this->HasMany('Mep\Models\transfers', 'transfer_id', 'id');
    }
    public static function balanceInitial($id)
    {
        $balance = self::find($id);

        return $balance;
    }
    public function LastId()
    {
        return self::all()->last();
    }

    public static function Token($token)
    {
        $balanceBudgets = self::withTrashed()->where('token', '=', $token)->get();
        if ($balanceBudgets):
            foreach ($balanceBudgets as $balanceBudget):
                return $balanceBudget;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = ['amount' => 'required',
            'policies' => 'required',
            'strategic' => 'required',
            'operational' => 'required',
            'goals' => 'required',
            'budget_id' => 'required',
            'catalog_id' => 'required',
             'simulation' => 'required',
            'type_budget_id' => 'required', ];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
