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
        $transfers = Transfer::withTrashed()->where('type', '=', 'entrada')->get();
        foreach ($transfers AS $transfer):
            $balanceBudget[] = $this->arregloSelectCuenta('id', $transfer->balance_budgets_id);
        endforeach;
        $balanceBudgets = $balanceBudget;
        return view('transfers.index', compact('transfers', 'balanceBudgets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create() {
        $spreadsheets = Spreadsheet::orderBy('number', 'ASC')->orderBy('year', 'ASC')->get();
        $balanceBudgets = $this->arregloSelectCuenta('budgets_id', $spreadsheets[0]->budgets_id);
        return view('transfers.create', compact('spreadsheets', 'balanceBudgets'));
    }

    /**
     * Display the specified resource.
     * Con este metodo creamos un arreglo para enviarlo a la vista asi formar el select
     * via ajax o directo a la vista
     * @param  int  $budgetsId
     * @return string
     */
    private function ArregloSelectCuenta($campo, $budgetsId) {

        $balancebudgets = BalanceBudget::where($campo, '=', $budgetsId)->get();
        foreach ($balancebudgets AS $balanceBudgets):
            $balanceBudget[] = array('idBalanceBudgets' => $balanceBudgets->id, 'id' => $balanceBudgets->token,
                'value' => $balanceBudgets->catalogs->p . '-' . $balanceBudgets->catalogs->g . '-' . $balanceBudgets->catalogs->sp . ' || ' . $balanceBudgets->catalogs->name . ' || ' . $balanceBudgets->typeBudgets->name);
        endforeach;
        return $balanceBudget;
    }

    /**
     * Display the specified resource.
     * Con este metodo creamos un arreglo para enviarlo a la vista asi formar el select
     * via ajax o directo a la vista
     * @param  int  $budgetsId
     * @return string
     */
    private function ArregloViewCuenta($campo, $budgetsId) {

        $balancebudgets = BalanceBudget::where($campo, '=', $budgetsId)->get();
        foreach ($balancebudgets AS $balanceBudgets):
            $balanceBudget[] = array('id' => $balanceBudgets->id, 'token' => $balanceBudgets->token,
                'code' => $balanceBudgets->catalogs->p . '-' . $balanceBudgets->catalogs->g . '-' . $balanceBudgets->catalogs->sp, 'name' => $balanceBudgets->catalogs->name);
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
        /* obtenemos dos datos del supplier mediante token recuperamos el id */
        $spreadsheet = Spreadsheet::Token($transfers->spreadsheetTransfer);
        $transfers->codeTransfer = 'v';
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($transfers, 'Transfer');
        $ValidationData['spreadsheets_id'] = $spreadsheet->id;
        /* Declaramos las clases a utilizar */
        $ValidationData['simulation'] = 'FALSE';
        if ($transfers->simulationTransfer == 'v'):
            $ValidationData['simulation'] = 'TRUE';
        endif;
        $transfer = new Transfer;
        $ValidationData['code'] =1;
        if(($transfer->lastCode())):
            $ValidationData['code'] = $transfer->lastCode() + 1;
        endif;
        
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

                $outTransfer = new Transfer;
                $outTransfer->fill($ValidationData);
                $outTransfer->save();
                /* Actualizacion de la table balance */
                BalanceController::saveBalanceTransfers($ValidationData['amount'],
                        'salida', 'false', ['transfers_code'=>'transfers_code','transfers_balance_budgets_id'=>'transfers_balance_budgets_id'],
                        ['transfers_code'=>$ValidationData['code'],'transfers_balance_budgets_id'=>$ValidationData['balance_budgets_id']],'false');
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
        return $this->errores($transfer->errors);
    }

    /**
     * Display the specified resource.
     * @param  int  $id
     * @return Response
     */
    public function view($token) {

        $transfers = Transfer::where('token', '=', $token)->get();
        foreach ($transfers AS $transfer):
            $balanceBudget[] = $this->ArregloViewCuenta('id', $transfer['balance_budgets_id']);
            $spreadsheets = Spreadsheet::find($transfer['spreadsheets_id']);
        endforeach;
        $spreadsheet = ['code' => $spreadsheets->number . '-' . $spreadsheets->year . ' ' . $spreadsheets->budgets->name];
        $balanceBudgets = $balanceBudget;
        return view('transfers.view', compact('transfers', 'spreadsheet', 'balanceBudgets'));
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
    public function destroy($token) {
        /* les damos eliminacion pasavida */
        $data = Transfer::Token($token);
        BalanceController::desactivar('transfers_id', $data->id);
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
        $data = Transfer::Token($token);
        BalanceController::active('transfers_id', $data->id);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

}
