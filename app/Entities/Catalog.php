<?php

namespace Mep\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Entity
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['c', 'sc', 'g', 'sg', 'p', 'sp', 'r', 'sr', 'f', 'name', 'type','group_id','token'];

    public function groups()
    {
        return $this->belongsTo('Mep\Entities\Group', 'group_id', 'id');
    }
    public function blanceBudgets()
    {
        return $this->hasMany('Mep\Entities\BalanceBudget', 'catalog_id', 'id');
    }
    public function LastId()
    {
        return self::all()->last();
    }

    public static function Token($token)
    {
        $groups = self::withTrashed()->where('token', '=', $token)->get();
        if ($groups):
            foreach ($groups as $group):
                return $group;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = ['name' => 'required',
            'type' => 'required',
            'group_id' => 'required', ];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
    public function codeCuenta()
    {
        return $this->p.'-'.$this->g.'-'.$this->sp;
    }
}
