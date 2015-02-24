<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


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
    
//    public function TasksMenus() {
//
//        return $this->hasMany('Mep\Models\Task','task_id','id');
//    }
    
    public function UsersMenus() {
        
        return $this->belongsToMany('users','users_has_menus','menus_id','users_id');
    }
    
    public function asd(){return 1;}
    public function LastId()
    {
        return Menu::all()->last();
    }

    public function isValid($data)
    {  
        $rules = ['name'=> 'required|unique:menus'];
       
        if ($this->exists)
        {
            $rules['name'] .= ',name,' . $this->id;
        }
       
         $validator = \Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        
        $this->errors = $validator->errors();
        
        return false;
    }
}
