<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class School extends Model {

    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'charter' => 'required',
        'circuit' => 'required',
        'code' => 'required',
        'ffinancing' => 'required',
        'president' => 'required',
        'secretary' => 'required',
        'account' => 'required',
        'title_1' => 'required',
        'title_2' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'charter', 'circuit', 'code', 'ffinancing', 'president', 'secretary', 'account', 'title_1', 'title_2'];

}