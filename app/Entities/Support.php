<?php

namespace Mep\Entities;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
        use SoftDeletingTrait;

    // Add your validation rules here
    public static $rules = [
        'title' => 'required',
        'message' => 'required',
        'status' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['title', 'message', 'users_id'];

    public function users()
    {
        return $this->HasMany('Users', 'id', 'users_id');
    }
}
