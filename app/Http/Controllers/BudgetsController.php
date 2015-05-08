<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Budget;
use Illuminate\Http\Request;
use Mep\Models\School;
use Mep\Models\BalanceBudget;
use Mep\Models\Catalog;
use Mep\Models\Group;
use Maatwebsite\Excel\Facades\Excel;

class BudgetsController extends Controller {

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
        $school= School::Token($budgets->schoolBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        /* Asignacion de id de school */
        $ValidationData['schools_id']=$school->id;
        /* Declaramos las clases a utilizar */
        $budget = new Budget;
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
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
     * @param  int  $id
     * @return Response
     */
    public function update() {
        /* Capturamos los datos enviados por ajax */
        $budgets = $this->convertionObjeto();
        
        $school= School::Token($budgets->schoolBudget);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($budgets, 'Budget');
        
        $ValidationData['schools_id']=$school->id;
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
     * @param  int  $id
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
     * @param  int  $id
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

    /**
     * [globalReport description]
     * @param  [type] $token  [description]
     * @param  [type] $global [description]
     * @param  [type] $year   [description]
     * @return [type]         [description]
     */
    public function globalReport($token, $global, $year) {
        $school   = School::Token($token);
        $catalogs = Catalog::all();
        foreach ($catalogs as $catalog) {
            $amount = Budget::join('balance_budgets', 'budgets.id', '=', 'balance_budgets.budgets_id')
                    ->where('schools_id', $school->id)
                    ->where('global', $global)
                    ->where('catalogs_id', $catalog->id)
                    ->where('year', $year)
                    ->sum('amount');
            if($amount>0){
                $groups[$catalog->groups_id] = Group::find($catalog->groups_id);
                $catalog->amount  = $amount;
                $catalogsBudget[] = $catalog;
            }
        }
        foreach ($groups as $group) {
            $totGroup = 0;
            foreach($catalogsBudget as $catalog){
                if($group->id == $catalog->groups_id){
                    $totGroup += $catalog->amount;
                }
            }
            $group->total = $totGroup;
        }
        //echo view('reports.global.content', compact('catalogsBudget', 'groups', 'school', 'global', 'year'));die;
        $pdf = \PDF::loadView('reports.global.content', compact('catalogsBudget', 'groups', 'school', 'global', 'year'));
        return $pdf->stream('Reporte.pdf');
    }

    /**
     * [report description]
     * @param  [string] $token
     * @return [type]   view
     */
    public function report($token) {
        $budget         = Budget::Token($token);
        $balanceBudgets = BalanceBudget::where('budgets_id', $budget->id)->get();
        $catalogsBudget = $this->catalogsBudget($budget, $balanceBudgets, null);
        $pdf = \PDF::loadView('reports.budget.content', compact('budget', 'catalogsBudget'))
               ->setOrientation('landscape');
        return $pdf->stream('Reporte.pdf');
    }

    /**
     * [catalogsBudget description]
     * @param  [type] $budget         [description]
     * @param  [type] $balanceBudgets [description]
     * @return [type]                 [description]
     */
    private function catalogsBudget($budget, $balanceBudgets){
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
                'groups_id' => $catalog->catalogs->groups_id,
                'typeBudget' => $this->amountTypeBudget($budget, $catalog, null));
        }
        return $typeBudget;
    }

    /**
     * [amountTypeBudget description]
     * @param  [type] $budget  [description]
     * @param  [type] $catalog [description]
     * @return [type]          [description]
     */
    private function amountTypeBudget($budget, $catalog){
        $total = 0;
        foreach($budget->typeBudgets as $typeBudget){
            $total += $this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id);
            $dataTypeBudget[$typeBudget->id] = number_format($this->balanceTypeBudget($budget->id, $catalog->catalogs->id, $typeBudget->id));
        }
        $dataTypeBudget['subtotal'] = number_format($total);
        return $dataTypeBudget;
    }

    /**
     * [balanceTypeBudget description]
     * @param  [type] $budget  [description]
     * @param  [type] $catalog [description]
     * @param  [type] $type    [description]
     * @return [type]          [description]
     */
    private function balanceTypeBudget($budget, $catalog, $type) {
        $amountBalanceBudget = BalanceBudget::where('balance_budgets.budgets_id', $budget)
                        ->where('balance_budgets.catalogs_id', $catalog)
                        ->where('balance_budgets.types_budgets_id', $type)->sum('amount');
        return $amountBalanceBudget;
    }

}
