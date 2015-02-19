<?php

namespace Mep\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Mep\SchoolsHasUser;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

    use Authenticatable,
        CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password', 'type_users_id', 'suppliers_id'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function typeUsers() {

        return $this->HasMany('TypeUsers', 'id', 'type_users_id');
    }

    public function suppliers() {

        return $this->HasMany('Suppliers', 'id', 'suppliers_id');
    }
    public function schools()
    {
        return $this->belongsToMany('School', 'schools_has_users','users_id','schools_id');
    }
}
