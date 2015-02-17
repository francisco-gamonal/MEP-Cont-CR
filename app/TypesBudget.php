<?php namespace Mep;

use Illuminate\Database\Eloquent\Model;

class TypesBudgets extends Model {

 use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name'];


}
