<?php namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;
use Illuminate\Database\Eloquent\SoftDeletes;

class BalanceBudget extends Model {

    use SoftDeletes;

 
    // Don't forget to fill this array
    protected $fillable = ['amount', 'policies', 'strategic', 'operational', 'goals', 'budgets_id', 'catalogs_id','token', 'types_budgets_id'];

    public function checks() {

        return $this->HasMany('Mep\Models\Check', 'checks_id', 'id');
    }

    public function budgets() {

        return $this->belongsTo('Mep\Models\Budget');
    }

    public function transfers() {

        return $this->HasMany('Mep\Models\transfers', 'transfers_id', 'id');
    }
 public function LastId() {
        return BalanceBudget::all()->last();
    }

    public static function Token($token) {
        $balanceBudgets = BalanceBudget::withTrashed()->where('token', '=', $token)->get();
        if ($balanceBudgets):
            foreach ($balanceBudgets AS $balanceBudget):
                return $balanceBudget;
            endforeach;
        endif;

        return false;
    }

    public function isValid($data) {
        $rules = ['amount' => 'required',
        'policies' => 'required',
        'strategic' => 'required',
        'operational' => 'required',
        'goals' => 'required',
        'budgets_id' => 'required',
        'catalogs_id' => 'required',
        'types_budgets_id' => 'required'];

        $validator = \Validator::make($data, $rules);
        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
}
