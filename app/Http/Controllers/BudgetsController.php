<?php

namespace Mep\Http\Controllers;

use Carbon\Carbon;
use Mep\Entities\Balance;
use Mep\Entities\Budget;
use Mep\Entities\School;
use Mep\Entities\BalanceBudget;
use Mep\Entities\Catalog;
use Mep\Entities\Group;

use Mep\Repositories\BudgetRepository;
use Mep\Repositories\BalanceBudgetRepository;
use Mep\Repositories\BalanceRepository;

class BudgetsController extends validatorController {

private $budgetRepository;

private $balanceBudgetRepository;
private $balanceRepository;
    /**
     * Create a new controller instance.
     */
    public function __construct(
        BudgetRepository $budgetRepository,
        BalanceBudgetRepository $balanceBudgetRepository,
        BalanceRepository $balanceRepository
        ) {
        set_time_limit(0);
        $this->middleware('auth');
        $this->budgetRepository = $budgetRepository;
        $this->balanceBudgetRepository = $balanceBudgetRepository;
        $this->balanceRepository = $balanceRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {

        $budgets = $this->budgetRepository->budgetSchoolOrderBy('name','ASC');
        return view('budgets.index', compact('budgets'));
    }

    public function before() {

        $budgets = $this->budgetRepository->getModel()->where('school_id',userSchool()->id)->get();
        return view('budgets.index', compact('budgets'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
       
        return view('budgets.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $budgets = $this->convertionObjeto();
        
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        /* Asignacion de id de school */
        $ValidationData['school_id'] = userSchool()->id;
        /* Declaramos las clases a utilizar */
        $budget = $this->budgetRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($budget->isValid($ValidationData)):
            $budget->fill($ValidationData);
            $budget->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idBudget = $budget->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($budgets->statusBudget == true):
                $this->budgetRepository->find($idBudget->id)->restore();
            else:
                $this->budgetRepository->destroy($idBudget->id);
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
        $budget = $this->budgetRepository->token($token);
        return view('budgets.edit', compact('budget'));
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

        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        $ValidationData['school_id'] = userSchool()->id;
        
        /* Declaramos las clases a utilizar */
        $budget = $this->budgetRepository->token($budgets->token);

        if($budget->school_id):
            $ValidationData['school_id'] = $budget->school_id;
         endif;

        /* Validamos los datos para guardar tabla menu */
        if ($budget->isValid($ValidationData)):
            $budget->fill($ValidationData);
            $budget->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($budgets->statusBudget == true):
                $this->budgetRepository->token($budgets->token)->restore();
            else:
                $this->budgetRepository->token($budgets->token)->delete();
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
        $data = $this->budgetRepository->token($token);
         $balanceBudget = $this->balanceBudgetRepository->getModel()->where('budget_id', $data->id)->get();
        if(!$balanceBudget->isEmpty()){
            return $this->errores('El presupuesto ya tiene saldos en cuentas registrados, no puede pasarlo a Inactivo.');
        }
          $data->delete();
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
        $data = $this->budgetRepository->token($token, true)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    public function poaReport($token) {
        $budget = $this->budgetRepository->token($token);
        $balanceBudgets = $this->balanceBudgetRepository->getModel()->where('budget_id', $budget->id)->get();
        $totalBalanceBudgets = $this->balanceBudgetRepository->getModel()->where('budget_id', $budget->id)->sum('amount');
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
            $amount = $this->budgetRepository->getModel()->join('balance_budgets', 'budgets.id', '=', 'balance_budgets.budget_id')
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
        $budget = $this->budgetRepository->token($token);
        $balanceBudgets = $this->balanceBudgetRepository->getModel()->where('budget_id', $budget->id)->get();
        $catalogsBudget = $this->catalogsBudget($budget, $balanceBudgets, null);
        $balance = $this->convertLetters($this->balanceBudgetRepository->getModel()->balanceForType($budget, 'ingresos'));
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
     * [balanceTypeBudget description].
     *
     * @param [type] $budget  [description]
     * @param [type] $catalog [description]
     * @param [type] $type    [description]
     *
     * @return [type] [description]
     */
    private function balanceTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = $this->balanceBudgetRepository->getModel()->where('balance_budgets.budget_id', $budget)
                        ->where('balance_budgets.catalog_id', $catalog)
                        ->where('balance_budgets.type_budget_id', $type)->sum('amount');

        return $amountBalanceBudget;
    }

    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-00-00
    |@Date Update: 2015-11-04
    |---------------------------------------------------------------------
    |@Description: Generamos l
    |
    | @param [type] $budget  [description]
    | @param [type] $catalog [description]
    | @param [type] $type    [description]
    |----------------------------------------------------------------------
    | @return [type] [description]
    |----------------------------------------------------------------------
    */
    private function balanceActualTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = $this->balanceRepository->getModel()->join('balance_budgets','balance_budgets.id','=','balances.balance_budget_id')
            ->where('balances.budget_id', $budget)
            ->where('balance_budgets.catalog_id', $catalog)
            ->where('balance_budgets.type_budget_id', $type)->sum('balances.amount');
        $check = $this->CheckActualTypeBudget($budget, $catalog, $type);

        return $amountBalanceBudget-$check;
    }


     public function reportActual($token){
        $budget = $this->budgetRepository->token($token);
        $balanceBudgets = $this->balanceBudgetRepository->getModel()->where('budget_id', $budget->id)->get();
        $catalogsBudget = $this->catalogsActualBudget($budget, $balanceBudgets, null);

        $balance = $this->convertLetters($this->balanceBudgetRepository->getModel()->balanceForType($budget, 'ingresos'));
        $pdf = \PDF::loadView('reports.budgetActual.content', compact('budget', 'catalogsBudget','balance'))
            ->setOrientation('landscape');
        return $pdf->stream('ReporteActual.pdf');
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
    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 2015-00-00
    |@Date Update: 2015-11-03
    |---------------------------------------------------------------------
    |@Description: Con esta accion generamos el monto de cada cuenta y
    |   y el subtotal tambien
    |
    |----------------------------------------------------------------------
    | @return mixed
    |----------------------------------------------------------------------
    */
    private function amountActualTypeBudget($budget, $catalog) {
        $total = 0;
        foreach ($budget->typeBudgets as $typeBudget) {
            $balanceBudget= $this->balanceBudgetRepository->getModel()->where('budget_id',$budget->id)
                ->where('catalog_id',$catalog->catalogs->id)
                ->where('type_budget_id',$typeBudget->id)
                ->get();
            //$total=0;
            if(!$balanceBudget->isEmpty()):
                $total += Balance::balanceActualAccount($balanceBudget[0]->id,$balanceBudget[0]->amount);
                $dataTypeBudget[$typeBudget->id] = number_format(Balance::balanceActualAccount($balanceBudget[0]->id,$balanceBudget[0]->amount), 2);
            else:
                $total;
                $dataTypeBudget[$typeBudget->id] = number_format(0, 2);
            endif;
        }
        $dataTypeBudget['subtotal'] = number_format($total, 2);

        return $dataTypeBudget;
    }

    private function CheckActualTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = $this->balanceRepository->getModel()->join('checks','checks.id','=','balances.check_id')
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
        return $this->balanceBudgetRepository->getModel()->where('budget_id', $id);
    }

    public function valitation($token) {

        return $this->valitationReport($token);
    }

    public function tableValidation($token) {
        return $this->budgetRepository->token($token);
    }

}
