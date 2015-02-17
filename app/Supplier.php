<?php namespace Mep;

use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model {

	    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'charter' => 'required',
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['charter', 'name', 'phone', 'email'];

    

}
