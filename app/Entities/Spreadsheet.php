<?php

namespace Mep\Entities;


use Illuminate\Database\Eloquent\SoftDeletes;

class Spreadsheet extends Entity
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['number', 'year', 'date', 'simulation', 'budget_id','type_budget_id', 'token'];

    public function budgets()
    {
        return $this->belongsTo('Mep\Entities\Budget', 'budget_id', 'id');
    }
    public function typebudgets()
    {
        return $this->belongsTo('Mep\Entities\TypeBudget', 'type_budget_id', 'id');
    }
    public function transfers(){
        return $this->hasMany('Mep\Entities\Transfer', 'spreadsheet_id', 'id');
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
            'type_budget_id' => 'required',
            'budget_id' => 'required', ];

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
