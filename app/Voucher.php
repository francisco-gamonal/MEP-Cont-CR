<?php

namespace Mep;

use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model {

    //    use SoftDeletingTrait;
    // Add your validation rules here
    public static $rules = [
        'imagen' => 'required',
        'suppliers_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['imagen', 'suppliers_id'];

    public function suppliers() {

        return $this->HasMany('Suppliers', 'id', 'suppliers_id');
    }

}
