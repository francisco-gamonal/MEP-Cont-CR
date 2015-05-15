<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model {

    use SoftDeletes;
    // Don't forget to fill this array
    protected $fillable = ['name', 'url'];

    public function Tasks() {
        return $this->belongsToMany('Mep\Models\Task')->withPivot('status');
    }

    public function tasksActive(){
        return $this->belongsToMany('Mep\Models\Task', 'task_user')->wherePivot('status', 1);
    }
    
    public function LastId() {
        return Menu::all()->last();
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:menus',
            'url' => 'required|unique:menus'];

        if ($this->exists) {
            $rules['name'] .= ',name,' . $this->id;
            $rules['url'] .= ',url,' . $this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
