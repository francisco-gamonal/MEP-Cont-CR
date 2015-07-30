<?php

namespace Mep\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mep\Entities\User;

class TypeUser extends Model
{
    /*
     * The database table used by the model.
     *
     * @var string
     */

    use SoftDeletes;

    public $timestamps = true;

    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function users()
    {
        return $this->belongsTo('User');
    }
    public function LastId()
    {
        return self::all()->last();
    }

    public function isValid($data)
    {
        $rules = ['name' => 'required|unique:type_users'];

        if ($this->exists) {
            $rules['name'] .= ',name,'.$this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
