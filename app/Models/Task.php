<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model {

    use SoftDeletes;

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
