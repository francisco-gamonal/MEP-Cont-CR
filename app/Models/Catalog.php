<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;
class Catalog extends Model {

    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'c' => 'required',
        'sc' => 'required',
        'g' => 'required',
        'sg' => 'required',
        'p' => 'required',
        'sp' => 'required',
        'r' => 'required',
        'sr' => 'required',
        'f' => 'required',
        'name' => 'required',
        'type' => 'required',
        'groups_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['c', 'sc', 'g', 'sg', 'p', 'sp', 'r', 'sr', 'f', 'name', 'type','groups_id','token'];

    public function groups() {

        return $this->belongsTo('Mep\Models\Group');
    }

    public function LastId() {
        return Catalog::all()->last();
    }

    public static function Token($token) {
        $groups = Catalog::withTrashed()->where('token', '=', $token)->get();
        if ($groups):
            foreach ($groups AS $group):
                return $group;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['name' => 'required',
            'type' => 'required',
            'groups_id' => 'required'];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
