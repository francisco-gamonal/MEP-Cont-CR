<?php
/**
 * Created by PhpStorm.
 * User: Amwar
 * Date: 05/04/2017
 * Time: 09:31 AM
 */

namespace Mep\Entities;

class TemporaryCheck extends Entity
{


    // Don't forget to fill this array
    protected $fillable = ['bill', 'concept', 'amount', 'retention', 'ckbill', 'ckretention',
        'record', 'date', 'simulation', 'token', 'voucher_id', 'balance_budget_id', 'spreadsheet_id', 'supplier_id'];
    public function isValid($data)
    {
        $rules = ['ckbill'=>'required'];

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

    public function spreadsheet()
    {
        return $this->belongsTo(Spreadsheet::getClass());
    }
}