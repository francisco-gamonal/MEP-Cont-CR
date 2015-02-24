<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model {

    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
     ];
    // Don't forget to fill this array
    protected $fillable = ['name'];

   // public function TasksMenus() {

       // return $this->belongsToMany('menus','tasks_has_menus','menus_id','tasks_id');
    //}
    public function UsersMenus() {
        
        return $this->belongsToMany('users','users_has_menus','tasks_id','users_id');
    }
    public function LastId()
    {
        return Task::all()->last();
    }
}
