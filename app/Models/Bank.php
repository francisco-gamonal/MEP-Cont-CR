<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class Banks extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'date' => 'required',
        'name' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['date', 'name'];

 

}
