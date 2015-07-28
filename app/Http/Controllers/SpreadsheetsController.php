<?php

namespace Mep\Http\Controllers;


use Mep\Models\Balance;
use Mep\Models\Budget;
use Mep\Models\Check;
use Mep\Models\Spreadsheet;
use Mep\Models\TypeBudget;

use Mep\Repositories\SpreadsheetRepository;
use Mep\Repositories\BudgetRepository;

class SpreadsheetsController extends Controller
{
    private $spreadsheetRepository;

    private $budgetRepository;
    /**
     * Create a new controller instance.
     */
    public function __construct(
        SpreadsheetRepository $spreadsheetRepository,
        BudgetRepository $budgetRepository
        )
    {
        set_time_limit(0);
        $this->middleware('auth');
        $this->spreadsheetRepository = $spreadsheetRepository;
        $this->budgetRepository = $budgetRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $listBudget   = $this->budgetRepository->lists('id');
        $spreadsheets = $this->spreadsheetRepository->newQuery()->whereIn('budget_id', $listBudget)->get();
        return view('spreadsheets.index', compact('spreadsheets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $budgets     = $this->budgetRepository->whereId('school_id', userSchool()->id, 'id');
        $typeBudgets = TypeBudget::all();

        if($budgets->isEmpty()){
            $error = "Necesitas registrar presupuestos para registrar planillas.";
            return view('spreadsheets.create', compact('error'));
        }

        return view('spreadsheets.create', compact('budgets','typeBudgets'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Capturamos los datos enviados por ajax */
        $spreadsheets = $this->convertionObjeto();
        /* Consulta por token de school */
        $budget = $this->budgetRepository->token($spreadsheets->budgetSpreadsheets);
        $typeBudget = TypeBudget::Token($spreadsheets->typeBudgetSpreadsheets);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($spreadsheets, 'Spreadsheets');
        /* Asignacion de id de school */
        $ValidationData['budget_id'] = $budget->id;
        $ValidationData['type_budget_id'] = $typeBudget->id;
        $ValidationData['simulation'] = 'false';
        /* Declaramos las clases a utilizar */
        $spreadsheet = $this->spreadsheetRepository->getModel();
        /* Validamos los datos para guardar tabla menu */
        if ($spreadsheet->isValid($ValidationData)):
            $spreadsheet->fill($ValidationData);
        $spreadsheet->save();
            /* Traemos el id del tipo de usuario que se acaba de */
            $idSpreadsheet = $spreadsheet->LastId();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($spreadsheets->statusSpreadsheets == true):
                $this->spreadsheetRepository->find($idSpreadsheet->id)->restore();
            else:
                $this->spreadsheetRepository->destroy($idSpreadsheet->id);
        endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($spreadsheet->errors);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($token)
    {
        $spreadsheet = $this->spreadsheetRepository->token($token);
        $budgets = $this->budgetRepository->all();
        $typeBudgets= TypeBudget::all();
        
        return view('spreadsheets.edit', compact('budgets', 'spreadsheet','typeBudgets'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function update()
    {
        /* Capturamos los datos enviados por ajax */
        $spreadsheets = $this->convertionObjeto();

        $budget = $this->budgetRepository->token($spreadsheets->budgetSpreadsheets);
        $typeBudget = TypeBudget::Token($spreadsheets->typeBudgetSpreadsheets);
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($spreadsheets, 'Spreadsheets');
        /* Asignacion de id de school */
        $ValidationData['budget_id'] = $budget->id;
        $ValidationData['type_budget_id'] = $typeBudget->id;
        $ValidationData['simulation'] = 'false';
        /* Declaramos las clases a utilizar */
        $spreadsheet = $this->spreadsheetRepository->token($spreadsheets->token);
        /* Validamos los datos para guardar tabla menu */
        if ($spreadsheet->isValid($ValidationData)):
            $spreadsheet->fill($ValidationData);
        $spreadsheet->save();
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($spreadsheets->statusSpreadsheets == true):
                $this->spreadsheetRepository->token($spreadsheets->token)->restore(); else:
                $this->spreadsheetRepository->token($spreadsheets->token)->delete();
        endif;
            /* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        endif;
        /* Enviamos el mensaje de error */
        return $this->errores($spreadsheet->errors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($token)
    {
        /* les damos eliminacion pasavida */
        $data = $this->spreadsheetRepository->token($token)->delete();
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
    public function active($token)
    {
        /* les quitamos la eliminacion pasavida */
        $data = $this->spreadsheetRepository->token($token)->restore();
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

    public function report($token)
    {
        $spreadsheet = $this->spreadsheetRepository->token($token);

        if(count($spreadsheet->transfers)>0):
            $lastTransfer = $spreadsheet->transfers[count($spreadsheet->transfers)-1]->code;
        else: 
            $lastTransfer = "";
        endif;

        $checks         = Check::where('spreadsheet_id', $spreadsheet->id)->orderBy('balance_budget_id', 'asc')->get();
        $balanceTotal   = 0;
        $totalAmount    = 0;
        $totalCancelar  = 0;
        $totalRetention = 0;
        $count          = 0;

        foreach ($checks as $index => $check):
            $balance = Balance::BalanceInicialTotal($check->balanceBudgets->id, $check->id, $spreadsheet, null, $lastTransfer,'spreadsheet');
            $id = $check->balanceBudgets->id;
            if ($count == 0) {
                $idT            = $check->balanceBudgets->id;
                $balanceInicial = $balance;
                $balanceTotal   = $balanceInicial - $check->amount;
                $count++;
            } else {
                if ($idT != $id):
                    $balanceInicial = $balance;
                    $balanceTotal   = $balanceInicial - $check->amount;
                    $idT            = $check->balanceBudgets->id;
                    $count++;
                else:
                    $balanceInicial = $balanceTotal;
                    $balanceTotal   = $balanceInicial - $check->amount;
                    $count++;
                endif;
            }
            
            $content[] = array(
                            $check->balanceBudgets->catalogs->codeCuenta(),
                            number_format($balanceInicial, 2),
                            $check->bill,
                            $check->supplier->name. ' '.$check->supplier->charter,
                            $check->concept,
                            number_format($check->amount, 2),
                            number_format($check->retention, 2),
                            number_format($check->cancelarAmount(), 2),
                            $check->ckbill,
                            $check->ckretention,
                            $check->record,
                            number_format($balanceTotal, 2)
                        );

            $totalAmount    += $check->amount;
            $totalRetention += $check->retention;
            $totalCancelar  += $check->cancelarAmount();
        endforeach;

        $pdf = \PDF::loadView('reports.spreadsheet.content', compact('content', 'spreadsheet' ,'totalAmount', 'totalCancelar', 'totalRetention'))->setOrientation('landscape');

        return $pdf->stream('Reporte.pdf');
    }
}
