<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['name', 'charter', 'circuit', 'code', 'ffinancing', 'president', 'secretary', 'account', 'titleOne', 'titleTwo'];

    public function users() {
        return $this->belongsToMany('Mep\Models\User');
    }
    public function budgets() {
        return $this->hasMany('Mep\Models\Budget','schools_id','id');
    }
    public function LastId() {
        return School::all()->last();
    }

    
    public static function Token($token) {
        $user = School::withTrashed()->where('token', '=', $token)->get();
        if ($user):
            foreach ($user AS $users):
                return $users;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = [
            'name'       => 'required',
            'charter'    => 'required|unique:schools',
            'circuit'    => 'required',
            'code'       => 'required',
            'ffinancing' => 'required',
            'president'  => 'required',
            'secretary'  => 'required',
            'account'    => 'required',
            'titleOne'    => 'required',
            'titleTwo'    => 'required'];

        if ($this->exists) {
            $rules['charter'] .= ',charter,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
