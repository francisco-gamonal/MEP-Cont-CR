<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model {

    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'type_users_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'type_users_id'];

    public function typeUsers() {

        return $this->HasMany('TypeUsers', 'id', 'type_users_id');
    }

}
