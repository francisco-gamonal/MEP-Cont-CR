<?php

namespace Mep\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Entity
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['name', 'charter', 'circuit', 'code',  'president', 'director', 'counter', 'secretary','token', 'titleOne', 'titleTwo'];

    public function users()
    {
        return $this->belongsToMany(User::getClass());
    }
    public function budgets()
    {
        return $this->hasMany(Budget::getClass(), 'school_id', 'id');
    }
    public function LastId()
    {
        return self::all()->last();
    }

    public static function Token($token)
    {
        $user = self::withTrashed()->where('token', '=', $token)->get();
        if ($user):
            foreach ($user as $users):
                return $users;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = [
            'name' => 'required',
            'charter' => 'required|unique:schools',
            'circuit' => 'required',
            'code' => 'required',
            'president' => 'required',
            'director' => 'required',
            'counter' => 'required',
            'secretary' => 'required',
            'token' => 'required|unique:schools',
            'titleOne' => 'required',
            'titleTwo' => 'required', ];

        if ($this->exists) {
            $rules['charter'] .= ',charter,'.$this->id;
            $rules['token'] .= ',token,'.$this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}