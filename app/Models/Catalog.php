<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Catalog extends Model
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['c', 'sc', 'g', 'sg', 'p', 'sp', 'r', 'sr', 'f', 'name', 'type','group_id','token'];

    public function groups()
    {
        return $this->belongsTo('Mep\Models\Group', 'group_id', 'id');
    }
    public function blanceBudgets()
    {
        return $this->hasMany('Mep\Models\BalanceBudget', 'catalog_id', 'id');
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
