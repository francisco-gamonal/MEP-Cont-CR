<?php

namespace Mep\Entities;



class Voucher extends Entity
{
    //    use SoftDeletingTrait;
    // Add your validation rules here
    public static $rules = [
        'imagen' => 'required',
        'supplier_id' => 'required',
    ];
    // Don't forget to fill this array
    protected $fillable = ['imagen', 'supplier_id'];

    public function suppliers()
    {
        return $this->HasMany('Suppliers', 'id', 'supplier_id');
    }
}
