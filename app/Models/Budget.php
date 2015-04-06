<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;
class Budget extends Model {

    use SoftDeletes;

   
    // Don't forget to fill this array
    protected $fillable = ['name', 'source', 'description', 'year', 'type', 'global','status','schools_id','token'];

    public function schools() {

        return $this->belongsTo('Mep\Models\School');
    }

    public function LastId() {
        return Budget::all()->last();
    }

    public static function Token($token) {
        $groups = Budget::withTrashed()->where('token', '=', $token)->get();
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
