<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spreadsheet extends Model
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['number', 'year', 'date', 'simulation', 'budget_id', 'token'];

    public function budgets()
    {
        return $this->belongsTo('Mep\Models\Budget', 'budget_id', 'id');
    }

    public function transfers(){
        return $this->hasMany('Mep\Models\Transfer', 'spreadsheet_id', 'id');
    }

    public function LastId()
    {
        return self::all()->last();
    }

    public static function Token($token)
    {
        $Spreadsheets = self::withTrashed()->where('token', '=', $token)->get();
        if ($Spreadsheets):
            foreach ($Spreadsheets as $Spreadsheet):
                return $Spreadsheet;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = ['number' => 'required|numeric',
            'year' => 'required',
            'date' => 'required',
            'simulation' => 'required',
            'token' => 'required',
            'budget_id' => 'required', ];

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
