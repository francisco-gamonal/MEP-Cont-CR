<?php namespace Mep;

use Illuminate\Database\Eloquent\Model;

class Catalogs extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'c' => 'required',
        'sc' => 'required',
        'g' => 'required',
        'sg' => 'required',
        'p' => 'required',
        'sp' => 'required',
        'r' => 'required',
        'sr' => 'required',
        'f' => 'required',
        'name' => 'required',
        'type' => 'required',
        'groups_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['c', 'sc', 'g', 'sg', 'p', 'sp', 'r', 'sr', 'f', 'name', 'type','groups_id'];

    public function groups() {

        return $this->HasMany('Groups', 'id', 'groups_id');
    }

   
}
