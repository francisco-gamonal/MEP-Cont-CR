<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeBudget extends Model {

    // Don't forget to fill this array
    protected $fillable = ['name','token'];

    use SoftDeletes;

    public $timestamps = true;

    public function LastId() {
        return TypeBudget::all()->last();
    }

    public function budgets() {

        return $this->belongsToMany('Mep\Models\Budget');
    }

    public static function Token($token) {
        $typeBudget = TypeBudget::withTrashed()->where('token', '=', $token)->get();
        if ($typeBudget):
            foreach ($typeBudget AS $typeBudgets):
                return $typeBudgets;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:type_budgets'];

        if ($this->exists) {
            $rules['name'] .= ',name,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
