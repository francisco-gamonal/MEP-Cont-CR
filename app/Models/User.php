<?php

namespace Mep\Models;

//use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
//use Illuminate\Auth\Passwords\CanResetPassword;
//use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
//implements AuthenticatableContract, CanResetPasswordContract
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
    protected $fillable = ['name','last','email', 'password', 'type_users_id', 'suppliers_id', 'token'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /* Relacion con la tabla Tipo de usuarios*/
    public function typeUsers() {
        return $this->belongsTo('Mep\Models\TypeUser');
    }

    /* Relacion con la tabla Supplier */
    public function suppliers() {

        return $this->hasOne('Mep\Models\Supplier', 'id', 'suppliers_id');
    }

    /* Relacion con la tabla schools */ 
    public function schools() {
        return $this->belongsToMany('Mep\Models\School');
    }

    /* Generar el nombre completo del usuario */
    public function nameComplete() {

        return $this->name.' '.$this->last;
    }

    /* creacion de string del id de schools */
    public  function idSchools($schools) {
        if ($schools):
            $id ='';
            foreach ($schools AS $school):
                $id .=$school->id.',';
            
            endforeach;
            $id = substr($id,0,-1);
            return $id;
        endif;

        return false;
    }

    /* creacion de string del name de schools */
    public  function nameSchools($schools) {
        if ($schools):
            $name ='';
            foreach ($schools AS $school):
                $name .=$school->name.',';
            
            endforeach;
            $name = substr($name,0,-1);
            return $name;
        endif;

        return false;
    }

    /* obtencion del id del ultimo usuario agregado */
    public function LastId() {
        return User::all()->last();
    }

    /* Busqueda de usuario por medio del token */
    public static function Token($token) {
        $user = User::withTrashed()->where('token', '=', $token)->get();
        if ($user):
            foreach ($user AS $users):
                return $users;
            endforeach;
        endif;

        return false;
    }
    /* validacion de los campos del usuario */
    public function isValid($data) {
        $rules = ['email' => 'required|unique:users',
            'name' => 'required',
            'last' => 'required',
            'password' => 'required|min:8|alpha_dash',
            'type_users_id' => 'required'];

        if ($this->exists) {
            $rules['email'] .= ',email,' . $this->id;
            $rules['password'] .= ',password,' . $this->id;
       }
  
        $validator = \Validator::make($data, $rules);
        if ($validator->fails()) {

            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

    public function  setPasswordAttribute($value){

        if(!empty($value)):
            $this->attributes['password']= \Hash::make($value);
            endif;
    }
}
