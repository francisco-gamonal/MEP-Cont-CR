<?php

namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;
use Mep\Models\Transfer;
use Mep\Models\Spreadsheet;
use Mep\Models\BalanceBudget;
use Illuminate\Http\Request;

class TransfersController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index() {
        $transfers = Transfer::withTrashed()->get();
        return view('transfers.index', compact('transfers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $spreadsheets = Spreadsheet::orderBy('number', 'ASC')->orderBy('year', 'ASC')->get();
        $balanceBudgets = $this->arregloSelectCuenta($spreadsheets[0]->budgets_id);
        return view('transfers.create', compact('spreadsheets', 'balanceBudgets'));
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
            $balanceBudget[] = array('idBalanceBudgets' => $balanceBudgets->id, 'id' => $balanceBudgets->token,
                'value' => $balanceBudgets->catalogs->p . '-' . $balanceBudgets->catalogs->g . '-' . $balanceBudgets->catalogs->sp . ' || ' . $balanceBudgets->catalogs->name . ' || ' . $balanceBudgets->typeBudgets->name);
        endforeach;
        return $balanceBudget;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store() {
        /* Capturamos los datos enviados por ajax */
        $transfers = $this->convertionObjeto();
        $transfers->codeTransfer = 1;

        /* obtenemos dos datos del supplier mediante token recuperamos el id */
        $spreadsheet = Spreadsheet::Token($transfers->spreadsheetTransfer);

        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($transfers, 'Transfer');
        $ValidationData['spreadsheets_id'] = $spreadsheet->id;


        /* Declaramos las clases a utilizar */
        if ($ValidationData['simulation'] == 'v'):
            $ValidationData['simulation'] = 'TRUE';
        endif;
        $ValidationData['simulation'] = 'FALSE';
        $transfer = new Transfer;
        /* Validamos los datos para guardar tabla menu */
        if ($transfer->isValid($ValidationData)):



            /* Traemos el id del ultimo registro guardado */


            $outBalanceBudget = $transfers->outBalanceBudgetTransfer;
            $amount = 0;
            for ($i = 0; $i < count($outBalanceBudget); $i++):
                /* Comprobamos cuales estan habialitadas y esas las guardamos */
                $balanceBudget = BalanceBudget::Token($transfers->outBalanceBudgetTransfer[$i]);
                $ValidationData['amount'] = $transfers->amountBalanceBudgetTransfer[$i];
                $ValidationData['balance_budgets_id'] = $balanceBudget->id;
                $ValidationData['type'] = 'salida';
                $transfer = new Transfer;
                $transfer->fill($ValidationData);
                $transfer->save();
                $amount += $ValidationData['amount'];
            endfor;
            $balanceBudget = BalanceBudget::Token($transfers->inBalanceBudgetTransfer);
            $ValidationData['balance_budgets_id'] = $balanceBudget->id;
            $ValidationData['amount'] = $amount;
            $ValidationData['type'] = 'entrada';
       
            $transfer->fill($ValidationData);
            $transfer->save();

            /* Comprobamos si viene activado o no para guardarlo de esa manera */
//            if ($transfers->statusTransfer == true):
//                Transfer::Token($tokenTransfer)->restore();
//            else:
//                Transfer::Token($tokenTransfer)->delete();
//            endif;

            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($user->errors);
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
    public function edit($id) {
        //
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
    public function destroy($id) {
        //
    }

}
