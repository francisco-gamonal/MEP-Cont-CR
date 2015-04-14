<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Check;
use Illuminate\Http\Request;
use Mep\Models\Voucher;
use Mep\Models\Supplier;
use Mep\Models\BalanceBudget;
use Mep\Models\Spreadsheet;

class ChecksController extends Controller {

    public function __construct() {
        // $this->middleware('auth');
    }

    public function budget($token) {
        $spreadsheets = Spreadsheet::Token($token);
        $balanceBudget = $this->arregloSelectCuenta($spreadsheets->budgets_id);
        $budget = view('checks.budget', compact('balanceBudget'));
        return $budget;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $checks = Check::withTrashed()->get();
        return view('checks.index', compact('checks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $voucher = Voucher::all();
        $suppliers = Supplier::all();
        $spreadsheets = Spreadsheet::orderBy('number', 'ASC')->orderBy('year', 'ASC')->get();
        $balanceBudgets = $this->arregloSelectCuenta($spreadsheets[0]->budgets_id);
        return view('checks.create', compact('voucher', 'suppliers', 'spreadsheets', 'balanceBudgets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $checks = $this->convertionObjeto();
        /* Consulta por token de school */
        // $voucher = Voucher::Token($checks->voucherCheck);
        $supplier = Supplier::Token($checks->supplierCheck);
        $spreadsheet = Spreadsheet::Token($checks->spreadsheetCheck);
        $balanceBudget = BalanceBudget::Token($checks->balanceBudgetCheck);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($checks, 'Check');
        /* Asignacion de id de school */
        //   $ValidationData['vouchers_id'] = $voucher->id;
        $ValidationData['suppliers_id'] = $supplier->id;
        $ValidationData['spreadsheets_id'] = $spreadsheet->id;
        $ValidationData['balance_budgets_id'] = $balanceBudget->id;
        $ValidationData['simulation'] = 'false';
        /* Declaramos las clases a utilizar */
        $check = new Check;
        /* Validamos los datos para guardar tabla menu */
        if ($check->isValid($ValidationData)):
            $check->fill($ValidationData);
            $check->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idCheck = $check->LastId();
            /* Actualizacion de la table balance */
            BalanceController::saveBalance($checks->amountCheck, 'salida', 'false', 'checks_id', $idCheck->id, $checks->statusCheck);
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($checks->statusCheck == true):
                Check::withTrashed()->find($idCheck->id)->restore();
            else:
                Check::destroy($idCheck->id);
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($check->errors);
    }

    /**
     * Display the specified resource.
     * Con este metodo creamos un arreglo para enviarlo a la vista asi formar el select
     * via ajax o directo a la vista
     * @param  int  $budgetsId
     * @return string
     */
    private function ArregloSelectCuenta($budgetsId) {
        $balancebudgets = BalanceBudget::where('budgets_id', '=', $budgetsId)->get();
        foreach ($balancebudgets AS $balanceBudgets):
            $balanceBudget[] = array('id' => $balanceBudgets->token,
                'value' => $balanceBudgets->catalogs->p . '-' . $balanceBudgets->catalogs->g . '-' . $balanceBudgets->catalogs->sp . ' || ' . $balanceBudgets->catalogs->name . ' || ' . $balanceBudgets->typeBudgets->name);
        endforeach;
        return $balanceBudget;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($token) {
        $check = Check::Token($token);
        $voucher = Voucher::all();
        $suppliers = Supplier::all();
        $spreadsheets = Spreadsheet::orderBy('number', 'ASC')->orderBy('year', 'ASC')->get();
        $balanceBudgets = $this->arregloSelectCuenta($spreadsheets[0]->budgets_id);
        return view('checks.edit', compact('check', 'voucher', 'suppliers', 'spreadsheets', 'balancebudgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update() {
        /* Capturamos los datos enviados por ajax */
        $checks = $this->convertionObjeto();
        /* Consulta por token de school */
        // $voucher = Voucher::Token($checks->voucherCheck);
        $supplier = Supplier::Token($checks->supplierCheck);
        $spreadsheet = Spreadsheet::Token($checks->spreadsheetCheck);
        $balanceBudget = BalanceBudget::Token($checks->balanceBudgetCheck);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($checks, 'Check');
        /* Asignacion de id de school */
        //   $ValidationData['vouchers_id'] = $voucher->id;
        $ValidationData['suppliers_id'] = $supplier->id;
        $ValidationData['spreadsheets_id'] = $spreadsheet->id;
        $ValidationData['balance_budgets_id'] = $balanceBudget->id;
        $ValidationData['simulation'] = 'false';
        /* Declaramos las clases a utilizar */
        $check = Check::Token($checks->token);
        /* Validamos los datos para guardar tabla menu */
        if ($check->isValid($ValidationData)):
            $check->fill($ValidationData);
            $check->save();
            /* Actualizacion de la table balance */
            $searchBalance = Balance::withTrashed()->where('checks_id', '=', $check->id)->get();
            BalanceController::editBalance($checks->amountCheck, 'salida', 'false', $searchBalance[0]->id, $checks->statusCheck);
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($checks->statusCheck == true):
                Check::Token($checks->token)->restore();
            else:
                Check::Token($checks->token)->delete();
            endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($check->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Check::Token($token);
        BalanceController::desactivar('checks_id', $data->id);
        if ($data):

            $data->delete();
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
        $data = Check::Token($token);
        BalanceController::active('checks_id', $data->id);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
