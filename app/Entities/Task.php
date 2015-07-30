<?php

namespace Mep\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;

    // Add your validation rules here
    public static $rules = [
        'name' => 'required',
     ];
    // Don't forget to fill this array
    protected $fillable = ['name'];

    public function Users()
    {
        return $this->belongsToMany('Mep\Entities\User')->withPivot('status');
    }
    public function menus()
    {
        return $this->belongsToMany('Mep\Entities\Menu');
    }
    public static function urlMenu($id)
    {
        return self::find($id)->menus->url;
    }

    public function LastId()
    {
        return self::all()->last();
    }
}
