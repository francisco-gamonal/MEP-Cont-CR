<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class Budgets extends Model {

    use SoftDeletingTrait;

   
    // Don't forget to fill this array
    protected $fillable = ['name', 'source', 'description', 'year', 'type', 'global','status','schools_id','token'];

    public function schools() {

        return $this->HasMany('Mep\Models\Schools', 'id', 'schools_id');
    }

    public function LastId() {
        return Budgets::all()->last();
    }

    public static function Token($token) {
        $groups = Budgets::withTrashed()->where('token', '=', $token)->get();
        if ($groups):
            foreach ($groups AS $group):
                return $group;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['type' => 'required',
        'name' => 'required',
        'source' => 'required',
        'description' => 'required',
        'year' => 'required',
        'global' => 'required',
        'status' => 'required',
        'schools_id' => 'required'];

        $validator = \Validator::make($data, $rules);
       
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
   
}
