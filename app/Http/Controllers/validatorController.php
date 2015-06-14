<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Budget;
use Illuminate\Http\Request;

abstract class validatorController extends Controller {
    
abstract public function reportValidation($token);   
abstract public function valitation($token);
abstract public function tableValidation($token);

protected function valitationReport($token){
        $budget = $this->tokenBudget($token);
        $report = $this->reportValidation($budget->id);
        
        if(count($report->get())>0):
            return $this->exito('');
        endif;
        
        return $this->errores('Esta tabla no contiene información');
    }
    
    protected function tokenBudget($token){
        return $this->tableValidation($token);
    }
}
