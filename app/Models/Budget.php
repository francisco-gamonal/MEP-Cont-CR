<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;

class Budgets extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'type' => 'required',
        'name' => 'required',
        'source' => 'required',
        'description' => 'required',
        'year' => 'required',
        'global' => 'required',
        'status' => 'required',
        'schools_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'source', 'description', 'year', 'type', 'global','status','schools_id'];

    public function schools() {

        return $this->HasMany('Schools', 'id', 'schools_id');
    }

   
}
