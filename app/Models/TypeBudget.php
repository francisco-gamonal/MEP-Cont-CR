<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class TypeBudget extends Model {

 use SoftDeletingTrait;
 protected $table ='types_budgets';

    // Don't forget to fill this array
    protected $fillable = ['name'];

use SoftDeletes;

    public $timestamps = true;

    public function LastId() {
        return TypeBudget::all()->last();
    }

    public static function Token($token) {
        $groups = TypeBudget::withTrashed()->where('token', '=', $token)->get();
        if ($groups):
            foreach ($groups AS $group):
                return $group;
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
