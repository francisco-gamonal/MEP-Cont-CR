<?php

namespace Mep;

use Illuminate\Database\Eloquent\Model;

class SchoolsHasUser extends Model {

  

    // Add your validation rules here
    public static $rules = [
        'users_id' => 'required',
        'schools_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['users_id', 'schools_id'];

    public function users() {

        return $this->HasMany('Users', 'id', 'users_id');
    }

    public function schools() {

        return $this->HasMany('Schools', 'id', 'schools_id');
    }

}
