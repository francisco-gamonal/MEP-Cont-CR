<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeBudget extends Model
{
    // Don't forget to fill this array
    protected $fillable = ['name','token'];

    use SoftDeletes;

    public $timestamps = true;

    public function LastId()
    {
        return self::all()->last();
    }

    public function budgets()
    {
        return $this->belongsToMany('Mep\Models\Budget');
    }

    public static function Token($token)
    {
        $typeBudget = self::withTrashed()->where('token', '=', $token)->get();
        if ($typeBudget):
            foreach ($typeBudget as $typeBudgets):
                return $typeBudgets;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = ['name' => 'required|unique:type_budgets'];

        if ($this->exists) {
            $rules['name'] .= ',name,'.$this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto.
     *
     * @param type $budget
     * @param type $group
     *
     * @return type
     */
    public function balanceForTypeBudget($budget, $typeBudget, $type)
    {
        $balanceTypeBudget = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalog_id')
                        ->where('balance_budgets.budget_id', $budget->id)
                        ->where('catalogs.type', $type)
                        ->where('balance_budgets.type_budget_id', $typeBudget)->sum('amount');

        return $balanceTypeBudget;
    }
}
