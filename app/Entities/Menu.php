<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use SoftDeletes;
    // Don't forget to fill this array
    protected $fillable = ['name', 'url', 'icon_font'];

    public function Tasks()
    {
        return $this->belongsToMany('Mep\Models\Task')->withPivot('status');
    }

    public function LastId()
    {
        return self::all()->last();
    }

    public function tasksActive($user)
    {
        return $this->belongsToMany('Mep\Models\Task', 'task_user')->wherePivot('status', 1)->wherePivot('user_id', $user);
    }

    public function isValid($data)
    {
        $rules = ['name' => 'required|unique:menus',
            'url' => 'required|unique:menus', ];

        if ($this->exists) {
            $rules['name'] .= ',name,'.$this->id;
            $rules['url'] .= ',url,'.$this->id;
        }

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
