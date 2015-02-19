<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Description of TaskHasMenu
 *
 * @author Anwar Sarmiento
 */
class TaskHasMenu extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['menus_id', 'tasks_id'];

    public function isValid($data) {
        $rules = ['menus_id' => 'required',
            'tasks_id' => 'required'];

        $validator = Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
