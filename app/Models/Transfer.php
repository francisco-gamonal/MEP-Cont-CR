<?php

namespace Mep\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use DateTime;

class Transfer extends Model
{
    use SoftDeletes;

    // Don't forget to fill this array
    protected $fillable = ['amount', 'type', 'date', 'simulation', 'token', 'code', 'balance_budget_id', 'spreadsheet_id'];

    public function spreadsheets()
    {
        return $this->belongsTo('Mep\Models\Spreadsheet');
    }

    public function balanceBudgets()
    {
        return $this->belongsTo('Mep\Models\BalanceBudget');
    }

    public function balances()
    {
        return $this->belongsTo('Mep\Models\Balance');
    }

    /* obtencion del id del ultimo usuario agregado */

    public function lastCode()
    {
        return DB::table('transfers')->max('code');
    }

    /* Busqueda de usuario por medio del token */

    public static function Token($token)
    {
        $user = self::withTrashed()->where('token', '=', $token)->get();
        if ($user):
            foreach ($user as $users):
                return $users;
        endforeach;
        endif;

        return false;
    }

    /* validacion de los campos del usuario */

    public function isValid($data)
    {
        $rules = ['amount' => 'required',
            'type' => 'required',
            'date' => 'required',
            'code' => 'required',
            'simulation' => 'required',
            'balance_budget_id' => 'required',
            'spreadsheet_id' => 'required', ];

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            $this->errors = $validator->errors();

            return false;
        }

        return true;
    }
//    public function setDateAttribute($date) {
//        return  DateTime::createFromFormat('Y-m-d', $date); //date('Y-m-d', strtotime($date));
//    }
    public function getDateAttribute($date)
    {
        return date('d/m/Y', strtotime($date));
    }
}
