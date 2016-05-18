<?php

namespace Mep\Entities;

class BankAccount extends Entity
{
    protected $fillable = ['number', 'name', 'balance', 'school_id', 'token'];

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
            'number' => 'required|unique:bank_accounts',
            'name' => 'required',
            'school_id' => 'required',
            'token' => 'required|unique:bank_accounts'
        ];

        if ($this->exists) {
            $rules['number'] .= ',number,'.$this->id;
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
