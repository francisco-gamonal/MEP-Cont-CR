<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model {

	use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['charter', 'name', 'phone', 'email','token'];

    public function LastId() {
        return Supplier::all()->last();
    }
    public static function Token($token) {
        $suppliers = Supplier::withTrashed()->where('token', '=', $token)->get();
        if($suppliers):
            foreach ($suppliers AS $supplier):
                return $supplier;
            endforeach;
        endif;
        
        return false;
        
    }
    public function isValid($data) {
        $rules = ['charter' => 'required|unique:suppliers',
        'name' => 'required',
        'phone' => 'required',
        'email' => 'required',
        'token' => 'required|unique:suppliers'];

        if ($this->exists) {
            $rules['charter'] .= ',charter,' . $this->id;
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
