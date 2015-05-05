<?php

namespace Mep\Models;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Mep\Models\Catalog;

/**
 * Description of Group
 *
 * @author Anwar Sarmiento
 */
class Group extends Model {

    //put your code here
    use SoftDeletes;

    public $timestamps = true;

     // Don't forget to fill this array
    protected $fillable = ['code', 'name','token'];
    
    public function LastId() {
        return Group::all()->last();
    }

    public static function Token($token) {
        $groups = Group::withTrashed()->where('token', '=', $token)->get();
        if ($groups):
            foreach ($groups AS $group):
                return $group;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['name' => 'required|unique:groups',
            'code' => 'required'];

        if ($this->exists) {
            $rules['name'] .= ',name,' . $this->id;
        }
        
        $validator = \Validator::make($data, $rules);
       
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

    public function catalogsIn($groupId){
        return Catalog::where('groups_id', $groupId)->where('type', 'ingresos')->get();
    }
    /**
     * Obtenemos el total del monto por grupo de cuentas para el Presupuesto
     * @param type $budget
     * @param type $group
     * @return type
     */
    public function balanceForGroup($budget, $group, $type) {
        $balanceGroup = BalanceBudget::join('catalogs', 'catalogs.id', '=', 'balance_budgets.catalogs_id')
                        ->where('balance_budgets.budgets_id', $budget->id)
                        ->where('catalogs.groups_id', $group->id)
                        ->where('catalogs.type', $type)->sum('amount');
        return $balanceGroup;
    }
}
