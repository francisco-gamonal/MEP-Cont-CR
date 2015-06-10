<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['name', 'source', 'ffinancing' ,'year', 'type', 'global','school_id','token'];

    public function schools()
    {
        return $this->belongsTo('Mep\Models\School', 'school_id', 'id');
    }
    public function balanceBudgets()
    {
        return $this->hasMany('Mep\Models\BalanceBudget', 'budget_id', 'id');
    }
    public function groups()
    {
        return $this->belongsToMany('Mep\Models\Group');
    }
    public function typeBudgets()
    {
        return $this->belongsToMany('Mep\Models\TypeBudget')->orderBy('id', 'asc');
    }
    public function LastId()
    {
        return self::all()->last();
    }

    public static function Token($token)
    {
        $budgets = self::withTrashed()->where('token', '=', $token)->get();
        if ($budgets):
            foreach ($budgets as $budget):
                return $budget;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = ['type' => 'required',
        'name' => 'required',
        'source' => 'required',
        'ffinancing' => 'required',
         'year' => 'required',
        'global' => 'required',
        'token' => 'required',
        'school_id' => 'required', ];

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
