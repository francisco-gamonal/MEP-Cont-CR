<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Spreadsheet extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['number', 'year', 'date', 'simulation', 'budgets_id', 'token'];

    public function budgets() {

        return $this->belongsTo('Mep\Models\Budget');
    }

    public function LastId() {
        return Spreadsheet::all()->last();
    }

    public static function Token($token) {
        $Spreadsheets = Spreadsheet::withTrashed()->where('token', '=', $token)->get();
        if ($Spreadsheets):
            foreach ($Spreadsheets AS $Spreadsheet):
                return $Spreadsheet;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['number' => 'required|numeric',
            'year' => 'required',
            'date' => 'required',
            'simulation' => 'required',
            'budgets_id' => 'required'];

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
    
}
