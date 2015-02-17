<?php namespace Mep;

use Illuminate\Database\Eloquent\Model;

class Tasks extends Model {

    use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'roles_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'roles_id'];

    public function roles() {

        return $this->HasMany('Roles', 'id', 'roles_id');
    }

}
