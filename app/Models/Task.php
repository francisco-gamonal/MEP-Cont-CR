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

   public function Users() {
        
        return $this->belongsToMany('Mep\Models\User')->withPivot('status');
    }
    public function LastId()
    {
        return Task::all()->last();
    }
}
