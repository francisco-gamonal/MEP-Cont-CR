<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class Balance extends Model {

    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['type', 'amount', 'simulation', 'balance_budgets_id', 'checks_id', 'transfers_code','transfers_balance_budgets_id'];

    public function checks() {

        return $this->belongsTo('Mep\Models\Check');
    }

    public function balanceBudgets() {

        return $this->belongsTo('Mep\Models\BalanceBudget');
    }

    public function transfers() {

        return $this->belongsTo('Mep\Models\Transfer');
    }

    public function balanceLast($type, $amount) {
        if ($this->type == $type) {
            return $this->amount + $amount;
        }
        return $this->$amount - $amount;
    }

    public function balanceTransfer($campo, $id) {
        $balances = Balance::where($campo, '=', $id)->where('transfers_id', '=', $transfer)->get();
        foreach ($balances AS $balance):

        endforeach;
    }
    public static function BalanceInicialTotal($id,$check,$spreadsheet,$checkTransfer){
         
         $balanceBudget = Balance::where('balance_budgets_id',$id)->sum('amount');
        
        /**/
        
       $transfersEntrada = Transfer::where('transfers.spreadsheets_id','<=',$spreadsheet->id)
               ->where('transfers.balance_budgets_id',$id)->where('transfers.type','entrada')->sum('transfers.amount');
      
       /**/
       $transfersSalida = Transfer::where('transfers.spreadsheets_id','<=',$spreadsheet->id)
               ->where('transfers.balance_budgets_id',$id)->where('transfers.type','salida')->sum('transfers.amount');
       /**/
        /**/
         if(!empty($check)):
        $checks = Balance::join('checks','checks.id','=','balances.checks_id')->where('checks_id','<',$check)
                ->where('balances.balance_budgets_id',$id)->where('date',$spreadsheet->date)->sum('balances.amount');
         endif;
      
         if(!empty($checkTransfer)):
        $checks = Balance::join('checks','checks.id','=','balances.checks_id')->where('checks_id','<',$check)
                ->where('balances.balance_budgets_id',$id)->where('date',$spreadsheet->date)->sum('balances.amount');
         endif;
        $balance=($balanceBudget+$transfersEntrada)-($checks+$transfersSalida);
      
        return $balance;
    
    }

    public function isValid($data) {
        $rules = ['type' => 'required',
            'amount' => 'required',
            'simulation' => 'required'];


        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

}
