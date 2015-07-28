<?php

namespace Mep\Entities;

use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Entity
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['charter', 'name', 'phone', 'email','token'];

    public function LastId()
    {
        return self::all()->last();
    }
    public static function Token($token)
    {
        $suppliers = self::withTrashed()->where('token', '=', $token)->get();
        if ($suppliers):
            foreach ($suppliers as $supplier):
                return $supplier;
        endforeach;
        endif;

        return false;
    }
    public function isValid($data)
    {
        $rules = ['charter' => 'required|unique:suppliers',
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'token' => 'required|unique:suppliers', ];

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
