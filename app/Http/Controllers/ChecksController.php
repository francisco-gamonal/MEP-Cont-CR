<?php

namespace Mep\Http\Controllers;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use Mep\Entities\Check;
use Mep\Entities\TemporaryCheck;
use Mep\Entities\Voucher;
use Mep\Entities\Supplier;
use Mep\Entities\BalanceBudget;
use Mep\Entities\Spreadsheet;
use Mep\Entities\Balance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Mep\Repositories\CheckRepository;
use Mep\Repositories\SpreadsheetRepository;
use Mep\Repositories\BudgetRepository;
use Mep\Repositories\TemporaryCheckRepository;

class ChecksController extends Controller
{
    private $checkRepository;
    private $budgetRepository;
    private $spreadsheetRepository;

    /**
     * @var TemporaryCheckRepository
     */
    private $temporaryCheckRepository;


    /**
     * ChecksController constructor.
     *
     * @param CheckRepository          $checkRepository
     * @param BudgetRepository         $budgetRepository
     * @param SpreadsheetRepository    $spreadsheetRepository
     * @param TemporaryCheckRepository $temporaryCheckRepository
     */
    public function __construct(
        CheckRepository $checkRepository,
        BudgetRepository $budgetRepository,
        SpreadsheetRepository $spreadsheetRepository,
        TemporaryCheckRepository $temporaryCheckRepository
        )
    {
        set_time_limit(0);
        $this->middleware('auth');
        $this->checkRepository = $checkRepository;
        $this->budgetRepository = $budgetRepository;
        $this->spreadsheetRepository = $spreadsheetRepository;
        $this->temporaryCheckRepository = $temporaryCheckRepository;
    }

    public function budget($token)
    {
        $spreadsheets = $this->spreadsheetRepository->token($token);
        $balanceBudget = $this->arregloSelectCuenta($spreadsheets);
        $budget = view('checks.budget', compact('balanceBudget'));

        return $budget;
    }


    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 05/04/2017 08:49 AM
    |@Date Update: 0000-00-00
    |---------------------------------------------------------------------
    | @Description: Modificamos este methodo para solo mostrar
    |
    |
    |@Pasos:
    |
    |
    |----------------------------------------------------------------------
    | @return
    |----------------------------------------------------------------------
    */
    public function index()
    {
        $searchs="";
        return view('checks.index',compact('searchs'));
    }


    /*
    |---------------------------------------------------------------------
    |@Author: Anwar Sarmiento <asarmiento@sistemasamigables.com
    |@Date Create: 05/04/2017 08:47 AM
    |@Date Update: 0000-00-00
    |---------------------------------------------------------------------
    | @Description: Con este metodo buscamos el numero de cheque y lo
    | enviamos a la vista para que vean el detalle
    |
    |@Pasos:
    |
    |
    |----------------------------------------------------------------------
    | @return \Illuminate\View\View
    |----------------------------------------------------------------------
    */
    public function search()
    {
        $checks = $this->checkRepository->getModel()->where('ckbill',Input::get('ckNumber'))
            ->orWhere('ckretention',Input::get('ckNumber'));
        $searchs = $checks->count();
        return view('checks.index',compact('searchs','checks'));
    }


    /**
     * ---------------------------------------------------------------------
     * @Author     : Anwar Sarmiento "asarmiento@sistemasamigables.com"
     * @Date       Create: 2017-04-05
     * @Time       Create: 9:18 AM
     * @Date       Update: 0000-00-00
     * ---------------------------------------------------------------------
     * @Description:
     * @Pasos      :
     * @param $token
     * ----------------------------------------------------------------------
     *
     * @return \Illuminate\View\View
     * ----------------------------------------------------------------------
     */
    public function create($token)
    {
        $spreadsheet = $this->spreadsheetRepository->token($token);
        return view('checks.create', compact( 'spreadsheet'));
    }

    public function detail()
    {
        $checks = $this->convertionObjeto();

        $check = new TemporaryCheck();
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($checks, 'Check');
        \Log::info(json_encode($ValidationData));
        /* Validamos los datos para guardar tabla menu */
        if ($check->isValid($ValidationData)):
            $check->ckbill=$ValidationData['ckbill'];
            $check->ckretention=$ValidationData['ckretention'];
            $check->date=$ValidationData['date'];
            $check->simulation=false;
            $check->spreadsheet_id=$this->spreadsheetRepository->token($ValidationData['spreadsheet'])->id;
            $check->record=$ValidationData['record'];
            $check->token=$ValidationData['token'];
            $check->save();
            return $this->exito($check->token);
         endif;
        /* Enviamos el mensaje de error */
        return $this->errores($check->errors);
    }


    /**
     * ---------------------------------------------------------------------
     * @Author     : Anwar Sarmiento "asarmiento@sistemasamigables.com"
     * @Date       Create: 2017-04-05
     * @Time       Create: ${TIME}
     * @Date       Update: 0000-00-00
     * ---------------------------------------------------------------------
     * @Description:
     * @Pasos      :
     * @param $token
     * ----------------------------------------------------------------------
     *
     * @return \Illuminate\View\View
     * ----------------------------------------------------------------------
     */
    public function invoices($token)
    {
        $temporaryChecks = $this->temporaryCheckRepository->token($token);
        $voucher = Voucher::all();
        $suppliers = Supplier::all();
        $balanceBudgets = $this->arregloSelectCuenta($temporaryChecks->spreadsheet);
        $checks = $this->checkRepository->getModel()->where('ckbill',$temporaryChecks->ckbill);
        return view('checks.detail', compact( 'temporaryChecks','voucher','suppliers','balanceBudgets','checks'));
    }


    public function individual()
    {
        $voucher = Voucher::all();
        $suppliers = Supplier::all();
        $spreadsheets = $this->spreadsheetRepository->spreadsheetSchool();

        if($spreadsheets == false):
            $balanceBudgets = [['value'=>'No hay Planillas creadas','id'=>'']];
        else:
            $balanceBudgets = $this->arregloSelectCuenta($spreadsheets[0]);
        endif;


        return view('checks.invoices', compact('voucher', 'suppliers', 'spreadsheets', 'balanceBudgets'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        /* Capturamos los datos enviados por ajax */
        $checks = $this->convertionObjeto();

        try {

            /* Consulta por token de school */
            // $voucher = Voucher::Token($checks->voucherCheck);
            $supplier = Supplier::Token($checks->supplierCheck);
            if($supplier==false):
                return $this->errores(['supplier'=>'No se encontro el Proveedor']);
            endif;
            $spreadsheet = Spreadsheet::Token($checks->spreadsheetCheck);
            if($spreadsheet==false):
                return $this->errores(['spreadsheet'=>'No se encontro la Planilla']);
            endif;
            $balanceBudget = BalanceBudget::Token($checks->balanceBudgetCheck);
            if($balanceBudget==false):
                return $this->errores(['balanceBudget'=>'No se encontro la Cuenta de catalogo']);
            endif;

            /* Creamos un array para cambiar nombres de parametros */
            $ValidationData = $this->CreacionArray($checks, 'Check');
            $ValidationData['token'] = Crypt::encrypt($checks->ckbillCheck.$checks->billCheck);

            /* Asignacion de id de school */
            //   $ValidationData['vouchers_id'] = $voucher->id;
            $ValidationData['supplier_id'] = $supplier->id;
            $ValidationData['spreadsheet_id'] = $spreadsheet->id;
            $ValidationData['balance_budget_id'] = $balanceBudget->id;
            $ValidationData['simulation'] = 'false';

          //  $ValidationData['date'] = 'false';
            /* Declaramos las clases a utilizar */
            DB::beginTransaction();
            $check = new Check();

            /* Validamos los datos para guardar tabla menu */
            if ($check->isValid($ValidationData)):
                $check->fill($ValidationData);
                $check->save();
                /* Traemos el id del tipo de usuario que se acaba de */
                $idCheck = $check->LastId();
                /* Actualizacion de la table balance */
                BalanceController::saveBalance($checks->amountCheck, 'salida', 'false', 'check_id', $idCheck->id, $checks->statusCheck, $balanceBudget->budgets->id);
                /* Comprobamos si viene activado o no para guardarlo de esa manera */
                if ($checks->statusCheck == true):
                    Check::withTrashed()->find($idCheck->id)->restore();
                else:
                    Check::destroy($idCheck->id);
                endif;
                DB::commit();
                /* Enviamos el mensaje de guardado correctamente */
                return $this->exito('Los datos se guardaron con exito!!!');
            endif;
            DB::rollback();
            /* Enviamos el mensaje de error */
            return $this->errores($check->errors);
        }catch (Exception $e) {
            \Log::error($e);
            return $this->errores(array('checks' => 'Verificar la información del cheque, si no contactarse con soporte de la applicación'));
        }
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
        $check = $this->checkRepository->token($token);
        $voucher = Voucher::all();
        $suppliers = Supplier::all();
        $spreadsheets = $this->spreadsheetRepository->spreadsheetSchool(); 
        $balanceBudgets = $this->arregloSelectCuenta($spreadsheets[0]);
      
        return view('checks.edit', compact('check', 'voucher', 'suppliers', 'spreadsheets', 'balanceBudgets'));
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
        $ValidationData['supplier_id'] = $supplier->id;
        $ValidationData['spreadsheet_id'] = $spreadsheet->id;
        $ValidationData['balance_budget_id'] = $balanceBudget->id;
        $ValidationData['simulation'] = 'false';
        /* Declaramos las clases a utilizar */
        $check = Check::Token($checks->token);
        /* Validamos los datos para guardar tabla menu */
        if ($check->isValid($ValidationData)):
            $check->fill($ValidationData);
        $check->save();
            /* Actualizacion de la table balance */
            $searchBalance = Balance::withTrashed()->where('check_id', '=', $check->id)->get();
        BalanceController::editBalance($checks->amountCheck, 'salida', 'false', $searchBalance[0]->id, $checks->statusCheck,$balanceBudget->budgets->id);
            /* Comprobamos si viene activado o no para guardarlo de esa manera */
            if ($checks->statusCheck == true):
                Check::Token($checks->token)->restore(); else:
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
     * @param int $id
     *
     * @return Response
     */
    public function destroy($token)
    {
        /* les damos eliminacion pasavida */
        $data = Check::Token($token);
        BalanceController::desactivar('check_id', $data->id);
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
     * @param int $id
     *
     * @return Response
     */
    public function active($token)
    {
        /* les quitamos la eliminacion pasavida */
        $data = Check::Token($token);
        BalanceController::active('check_id', $data->id);
        if ($data):
            $data->restore();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se Activo con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
    }

        /**
     * Display the specified resource.
     * Con este metodo creamos un arreglo para enviarlo a la vista asi formar el select
     * via ajax o directo a la vista.
     *
     * @param int $budgetsId
     *
     * @return string
     */
    private function ArregloSelectCuenta($spreadsheet)
    {

        $BalanceBudgets = BalanceBudget::where('budget_id', '=', $spreadsheet->budget_id)->where('type_budget_id',$spreadsheet->type_budget_id)->get();
        if(count($BalanceBudgets)>0):
        foreach ($BalanceBudgets as $Budgets):
            $Balance[] = array('idBalanceBudgets' => $Budgets->id,'id' => $Budgets->token,
                'value' => $Budgets->catalogs->p.'-'.$Budgets->catalogs->g.'-'.$Budgets->catalogs->sp.' || '.$Budgets->catalogs->name.' || '.$Budgets->typeBudgets->name, );
        endforeach;
         
        return $Balance;
        endif;
        
        return [['idBalanceBudgets' => '','id' => '',
                        'value' => 'No existen cuentas en el presupuesto']];
    }
}
