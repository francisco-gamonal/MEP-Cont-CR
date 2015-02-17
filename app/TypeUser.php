<?php namespace Mep;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mep\User;

class TypeUser extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'type_users';

    use SoftDeletes;

    public $timestamps = true;
    
    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function users(){
        
        return $this->belongsToMany('Users');
    }
}
