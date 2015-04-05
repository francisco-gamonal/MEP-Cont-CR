<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class TypeBudgets extends Model {

 use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name'];


}
