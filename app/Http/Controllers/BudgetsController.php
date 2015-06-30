<?php

namespace Mep\Http\Controllers;

use Mep\Models\Balance;
use Mep\Models\Budget;
use Mep\Models\School;
use Mep\Models\BalanceBudget;
use Mep\Models\Catalog;
use Mep\Models\Group;

class BudgetsController extends validatorController {

    /**
     * Create a new controller instance.
     */
    public function __construct() {
        set_time_limit(0);
        $this->middleware('auth');
        //   $this->middleware('admin',['only'=>'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $budgets = Budget::withTrashed()->get();

        return view('budgets.index', compact('budgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $schools = School::all();

        return view('budgets.create', compact('schools'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $budgets = $this->convertionObjeto();
        /* Consulta por token de school */
        $school = School::Token($budgets->schoolBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        /* Asignacion de id de school */
        $ValidationData['school_id'] = $school->id;
        /* Declaramos las clases a utilizar */
        $budget = new Budget();
        /* Validamos los datos para guardar tabla menu */
        if ($budget->isValid($ValidationData)):
            $budget->fill($ValidationData);
            $budget->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idBudget = $budget->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($budgets->statusBudget == true):
                Budget::withTrashed()->find($idBudget->id)->restore();
            else:
                Budget::destroy($idBudget->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($budget->errors);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($token) {
        $budget = Budget::Token($token);
        $schools = School::all();

        return view('budgets.edit', compact('schools', 'budget'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update() {
        /* Capturamos los datos enviados por ajax */
        $budgets = $this->convertionObjeto();

        $school = School::Token($budgets->schoolBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');

        $ValidationData['school_id'] = $school->id;
        /* Declaramos las clases a utilizar */
        $budget = Budget::Token($budgets->token);
        /* Validamos los datos para guardar tabla menu */
        if ($budget->isValid($ValidationData)):
            $budget->fill($ValidationData);
            $budget->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($budgets->statusBudget == true):
                Budget::Token($budgets->token)->restore();
            else:
                Budget::Token($budgets->token)->delete();
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($budget->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Budget::Token($token)->delete();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se desactivo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    /**
     * Restore the specified typeuser from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function active($token) {
        /* les quitamos la eliminacion pasavida */
        $data = Budget::Token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    public function poaReport($token) {
        $budget = Budget::Token($token);
        $balanceBudgets = BalanceBudget::where('budget_id', $budget->id)->get();
        $totalBalanceBudgets = BalanceBudget::where('budget_id', $budget->id)->sum('amount');
        $pdf = \PDF::loadView('reports.budget.poa.content', compact('balanceBudgets', 'totalBalanceBudgets'))->setOrientation('landscape');

        return $pdf->stream('Poa.pdf');
    }

    /**
     * [globalReport description].
     *
     * @param [type] $token  [description]
     * @param [type] $global [description]
     * @param [type] $year   [description]
     *
     * @return [type] [description]
     */
    public function globalReport($token, $global, $year) {
        $school = School::Token($token);
        $catalogs = Catalog::all();
        foreach ($catalogs as $catalog) {
            $amount = Budget::join('balance_budgets', 'budgets.id', '=', 'balance_budgets.budget_id')
                    ->where('school_id', $school->id)
                    ->where('global', $global)
                    ->where('catalog_id', $catalog->id)
                    ->where('year', $year)
                    ->where('balance_budgets.deleted_at', NULL)
                    ->sum('amount');
            if ($amount > 0) {
                $groups[$catalog->group_id] = Group::find($catalog->group_id);
                $catalog->amount = $amount;
                $catalogsBudget[] = $catalog;
            }
        }
       
       
        foreach ($groups as $group) {
            $totGroup = 0;
             $total=0;
            foreach ($catalogsBudget as $catalog) {
                if ($group->id == $catalog->group_id) {
                    $totGroup += $catalog->amount;
                }
              
                if($catalog->type =='ingresos'):
                    $total +=$catalog->amount;
                endif;
            }
            $group->total = $totGroup;
            
           
        }
        
        $count = count($catalogsBudget) + count($groups) + 6;
        if ($count >= 18):
            $top = 125;
        endif;
        $balance = $this->convertLetters($total);
        
        $pdf = \PDF::loadView('reports.global.content', compact('catalogsBudget', 'groups','balance' , 'school', 'global', 'year', 'top'));

        return $pdf->stream('Reporte.pdf');
    }

    /**
     * [report description].
     *
     * @param [string] $token
     *
     * @return [type] view
     */
    public function report($token) {
        $budget = Budget::Token($token);
        $balanceBudgets = BalanceBudget::where('budget_id', $budget->id)->get();
        $catalogsBudget = $this->catalogsBudget($budget, $balanceBudgets, null);
        $balance = $this->convertLetters(BalanceBudget::balanceForType($budget, 'ingresos'));
        $pdf = \PDF::loadView('reports.budget.content', compact('budget', 'catalogsBudget','balance'))
                ->setOrientation('landscape');

        return $pdf->stream('Reporte.pdf');
    }

    public function reportActual($token){
        $budget = Budget::Token($token);
        $balanceBudgets = BalanceBudget::where('budget_id', $budget->id)->get();
        $catalogsBudget = $this->catalogsActualBudget($budget, $balanceBudgets, null);
        $balance = $this->convertLetters(BalanceBudget::balanceForType($budget, 'ingresos'));
        $pdf = \PDF::loadView('reports.budget.content', compact('budget', 'catalogsBudget','balance'))
            ->setOrientation('landscape');

        return $pdf->stream('Reporte.pdf');
    }
    /**
     * [catalogsBudget description].
     *
     * @param [type] $budget         [description]
     * @param [type] $balanceBudgets [description]
     *
     * @return [type] [description]
     */
    private function catalogsBudget($budget, $balanceBudgets) {
        foreach ($balanceBudgets as $catalog) {
            $typeBudget[$catalog->catalogs->id] = array('c' => $catalog->catalogs->c,
                'sc' => $catalog->catalogs->sc,
                'g' => $catalog->catalogs->g,
                'sg' => $catalog->catalogs->sg,
                'p' => $catalog->catalogs->p,
                'sp' => $catalog->catalogs->sp,
                'r' => $catalog->catalogs->r,
                'sr' => $catalog->catalogs->sr,
                'f' => $catalog->catalogs->f,
                'name' => $catalog->catalogs->name,
                'type' => $catalog->catalogs->type,
                'group_id' => $catalog->catalogs->group_id,
                'typeBudget' => $this->amountTypeBudget($budget, $catalog, null),);
        }

        return $typeBudget;
    }
    /**
     * [catalogsBudget description].
     *
     * @param [type] $budget         [description]
     * @param [type] $balanceBudgets [description]
     *
     * @return [type] [description]
     */
    private function catalogsActualBudget($budget, $balanceBudgets) {
        foreach ($balanceBudgets as $catalog) {
            $typeBudget[$catalog->catalogs->id] = array('c' => $catalog->catalogs->c,
                'sc' => $catalog->catalogs->sc,
                'g' => $catalog->catalogs->g,
                'sg' => $catalog->catalogs->sg,
                'p' => $catalog->catalogs->p,
                'sp' => $catalog->catalogs->sp,
                'r' => $catalog->catalogs->r,
                'sr' => $catalog->catalogs->sr,
                'f' => $catalog->catalogs->f,
                'name' => $catalog->catalogs->name,
                'type' => $catalog->catalogs->type,
                'group_id' => $catalog->catalogs->group_id,
                'typeBudget' => $this->amountActualTypeBudget($budget, $catalog, null),);
        }

        return $typeBudget;
    }
    /**
     * [amountTypeBudget description].
     *
     * @param [type] $budget  [description]
     * @param [type] $catalog [description]
     *
     * @return [type] [description]
     */
    private function amountTypeBudget($budget, $catalog) {
        $total = 0;
        foreach ($budget->typeBudgets as $typeBudget) {
            $total += $this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id);
            $dataTypeBudget[$typeBudget->id] = number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id), 2);
        }
        $dataTypeBudget['subtotal'] = number_format($total, 2);

        return $dataTypeBudget;
    }
    /**
     * [amountTypeBudget description].
     *
     * @param [type] $budget  [description]
     * @param [type] $catalog [description]
     *
     * @return [type] [description]
     */
    private function amountActualTypeBudget($budget, $catalog) {
        $total = 0;
        foreach ($budget->typeBudgets as $typeBudget) {
            $total += $this->balanceActualTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id);
            $dataTypeBudget[$typeBudget->id] = number_format($this->balanceActualTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id), 2);
        }
        $dataTypeBudget['subtotal'] = number_format($total, 2);

        return $dataTypeBudget;
    }
    /**
     * [balanceTypeBudget description].
     *
     * @param [type] $budget  [description]
     * @param [type] $catalog [description]
     * @param [type] $type    [description]
     *
     * @return [type] [description]
     */
    private function balanceTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = BalanceBudget::where('balance_budgets.budget_id', $budget)
                        ->where('balance_budgets.catalog_id', $catalog)
                        ->where('balance_budgets.type_budget_id', $type)->sum('amount');

        return $amountBalanceBudget;
    }

    /**
     * [balanceTypeBudget description].
     *
     * @param [type] $budget  [description]
     * @param [type] $catalog [description]
     * @param [type] $type    [description]
     *
     * @return [type] [description]
     */
    private function balanceActualTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = Balance::join('balance_budgets','balance_budgets.id','=','balances.balance_budget_id')
            ->where('balances.budget_id', $budget)
            ->where('balance_budgets.catalog_id', $catalog)
            ->where('balance_budgets.type_budget_id', $type)->sum('balances.amount');
        $check = $this->CheckActualTypeBudget($budget, $catalog, $type);
        return $amountBalanceBudget-$check;
    }
    private function CheckActualTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = Balance::join('checks','checks.id','=','balances.check_id')
            ->join('balance_budgets','balance_budgets.id','=','checks.balance_budget_id')
            ->where('balances.budget_id', $budget)
            ->where('balance_budgets.catalog_id', $catalog)
            ->where('balance_budgets.type_budget_id', $type)->sum('balances.amount');

        return $amountBalanceBudget;
    }
    public function convertLetters($number) {
        return $this->convertir_a_letras($number);
    }

    public function reportValidation($id) {
        return BalanceBudget::where('budget_id', $id);
    }

    public function valitation($token) {

        return $this->valitationReport($token);
    }

    public function tableValidation($token) {
        return Budget::Token($token);
    }

}
