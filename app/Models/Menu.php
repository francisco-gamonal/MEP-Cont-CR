<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Response;

class Menu extends Model {

    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
        'url' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['name', 'url'];

    public function Tasks() {
        return $this->belongsToMany('Mep\Models\Task');
    }

    public function Users() {

        return $this->belongsToMany('Mep\Models\User');
    }

    public function LastId() {
        return Menu::all()->last();
    }

    public static function insertData($datos, $arreglo) {

       
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:menus'];

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
