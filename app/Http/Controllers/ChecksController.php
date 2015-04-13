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


	public function budget($token){
		return $token;
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
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
        $spreadsheets = Spreadsheet::orderBy('number','ASC')->orderBy('year','ASC')->get();
        $balancebudgets = BalanceBudget::where('budgets_id','=',$spreadsheets[0]->budgets_id)->get();
        return view('checks.create', compact('voucher', 'suppliers', 'spreadsheets', 'balancebudgets'));
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
        $voucher= Voucher::Token($checks->voucherCheck);
        $supplier= Supplier::Token($checks->voucherCheck);
        $spreadsheet= Spreadsheet::Token($checks->voucherCheck);
        $balanceBudget= BalanceBudget::Token($checks->voucherCheck);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($checks, 'Check');
        /* Asignacion de id de school */
        $ValidationData['vouchers_id']=$voucher->id;
        $ValidationData['suppliers_id']=$supplier->id;
        $ValidationData['spreadsheets_id']=$spreadsheet->id;
        $ValidationData['balance_budgets_id']=$balanceBudget->id;
        /* Declaramos las clases a utilizar */
        $check = new Check;
        /* Validamos los datos para guardar tabla menu */
        if ($check->isValid($ValidationData)):
            $check->fill($ValidationData);
            $check->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idCheck = $check->LastId();
            /*Actualizacion de la table balance*/
            BalanceController::saveBalance($balanceBudgets->amountBalanceBudget,'entrada','false','balance_budgets_id',$idBalanceBudget->id,$balanceBudgets->statusBalanceBudget);
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
        $check = Check::Token($token);
        $voucher = Voucher::all();
        $suppliers = Supplier::all();
        $spreadsheets = Spreadsheet::all();
        $balancebudgets = BalanceBudget::all();
        return view('checks.edit', compact('check', 'voucher', 'suppliers', 'spreadsheets', 'balancebudgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Check::Token($token)->delete();
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
        $data = Check::Token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
