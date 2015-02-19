<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class Spreadsheets extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'number' => 'required',
        'year' => 'required',
        'date' => 'required',
        'status' => 'required',
        'budgets_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['number', 'year', 'date', 'status', 'budgets_id'];

    public function budgets() {

        return $this->HasMany('Budgets', 'id', 'budgets_id');
    }

}
