<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mep\models\User;

class TypeUser extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'type_users';

    use SoftDeletes;

    public $timestamps = true;
    

    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function users(){
        
        return $this->belongsToMany('Users');
    }
    public function LastId() {
        return TypeUser::all()->last();
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:type_users'];

        if ($this->exists) {
            $rules['name'] .= ',name,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
