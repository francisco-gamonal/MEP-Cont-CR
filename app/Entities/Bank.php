<?php

namespace Mep\Entities;

use Illuminate\Database\Eloquent\Model;

class Bank extends Entity
{
    use SoftDeletingTrait;

    // Don't forget to fill this array
    protected $fillable = ['date', 'name'];

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
        $rules = ['date' => 'required',
        'name' => 'required',
            'token' => 'required|unique:banks', ];

        if ($this->exists) {
            $rules['email'] .= ',email,'.$this->id;
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
