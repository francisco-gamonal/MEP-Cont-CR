<?php

namespace Mep\Entities;

class Deposit extends Entity
{
    protected $fillable = ['number', 'date', 'amount', 'depositor', 'img_url', 'token', 'bank_account_id'];

    public function LastId()
    {
        return self::all()->last();
    }

    public function bankAccount(){
        return $this->belongsTo(BankAccount::getClass(), 'bank_account_id', 'id');
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
            'number' => 'required',
            'date' => 'required|date',
            'amount' => 'required|numeric',
            'depositor' => 'required',
            'token' => 'required|unique:deposits',
            'bank_account_id' => 'required'
        ];

        if ($this->exists) {
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
