<?php

namespace Mep\Models;

//use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
//implements AuthenticatableContract, CanResetPasswordContract
use Mep\SchoolsHasUser;
use Mep\Models\Supplier;
use Mep\Models\TypeUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model {

//    use Authenticatable,
//        CanResetPassword;
    use SoftDeletes;

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
    protected $fillable = ['name', 'email', 'password', 'type_users_id', 'suppliers_id', 'token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function typeUsers() {

        return $this->belongsTo('Mep\Models\TypeUser');
    }

    public function suppliers() {

        return $this->HasMany('Suppliers', 'id', 'suppliers_id');
    }

    public function schools() {
        return $this->belongsToMany('School', 'schools_has_users', 'users_id', 'schools_id');
    }

    public function LastId() {
        return User::all()->last();
    }

    public static function Token($token) {
        $user = User::withTrashed()->where('token', '=', $token)->get();
        if ($user):
            foreach ($user AS $users):
                return $users;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['email' => 'required|unique:users',
            'name' => 'required',
            'last' => 'required',
            'password' => 'required|min:8|alpha_dash',
            'type_users_id' => 'required',
            'token' => 'required|unique:users'];

        if ($this->exists) {
            $rules['email'] .= ',email,' . $this->id;
            $rules['token'] .= ',token,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
