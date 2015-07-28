<?php

namespace Mep\Entities


use Illuminate\Database\Eloquent\SoftDeletes;

class Check extends Entity
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['bill', 'concept', 'amount', 'retention', 'ckbill', 'ckretention', 'record', 'date', 'simulation', 'token', 'voucher_id', 'balance_budget_id', 'spreadsheet_id', 'supplier_id'];

    public function voucher()
    {
        return $this->HasOne('Mep\Models\Vouchers');
    }

    public function balanceBudgets()
    {
        return $this->belongsTo(BalanceBudget::getClass(), 'balance_budget_id', 'id');
    }

    public function spreadsheets()
    {
        return $this->belongsTo(Spreadsheet::getClass(), 'spreadsheet_id', 'id');
    }

    public function supplier()
    {
        return $this->HasOne(Supplier::getClass(), 'id', 'supplier_id');
    }

    public function LastId()
    {
        return self::all()->last();
    }
    public function cancelarAmount()
    {
        return $this->amount - $this->retention;
    }
    /**
     * @param type $token
     *
     * @return bool
     */
    public static function Spreadsheet($id)
    {
        $checks = self::withTrashed()->where('spreadsheet_id', $id)->get();
        if ($checks):
            foreach ($checks as $check):
                return $check;
        endforeach;
        endif;

        return false;
    }
    public static function Token($token)
    {
        $budgets = self::withTrashed()->where('token', '=', $token)->get();
        if ($budgets):
            foreach ($budgets as $budget):
                return $budget;
        endforeach;
        endif;

        return false;
    }

    public function isValid($data)
    {
        $rules = [
            'bill' => 'required',
            'concept' => 'required',
            'amount' => 'required',
            'ckbill' => 'required',
            'record' => 'required',
            'simulation' => 'required',
            'balance_budget_id' => 'required',
            'spreadsheet_id' => 'required',
            'supplier_id' => 'required', ];

        $validator = \Validator::make($data, $rules);

        if ($validator->passes()) {
            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }
    public function BalanceChecks($id, $date, $style)
    {
    }

    public function getDateAttribute($value)
    {
        // si definiste la columna en la base de datos como date
        return date('d/m/Y', strtotime($value));
    }

    public function codeCuentaCatalog()
    {
        return $this->balanceBudgets->catalogs->p.'-'.$this->balanceBudgets->catalogs->g.'-'.$this->balanceBudgets->catalogs->sp;
    }

    public function numberSpreadsheet()
    {
        return $this->spreadsheets->number.'-'.$this->spreadsheets->year;
    }
}
