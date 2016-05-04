<?php namespace Mep\Http\Controllers;

use Mep\Http\Requests;
use Mep\Http\Controllers\Controller;

use Mep\Repositories\DepositRepository;
use Mep\Repositories\BankAccountRepository;

use Illuminate\Http\Request;

class DepositsController extends Controller 
{
	private $depositRepository;
	private $bankAccountRepository;

	/**
     * Create a new controller instance.
     */
    public function __construct(
    		BankAccountRepository $bankAccountRepository,
    		DepositRepository $depositRepository
    	)
    {
        $this->middleware('auth');
        $this->bankAccountRepository = $bankAccountRepository;
        $this->depositRepository = $depositRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bankAccounts = $this->bankAccountRepository->lists('id');
		$deposits = $this->depositRepository->whereOnlyOneIn('bank_account_id', $bankAccounts, 'id', 'asc');
		
        return view('deposits.index', compact('deposits'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$bankAccounts = $this->bankAccountRepository->allSchool();
		return view('deposits.create', compact('bankAccounts'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(Request $request)
	{
		/* Capturamos los datos enviados por ajax */
        $deposits = $request->all();
        
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($deposits, 'Deposit', 'number');

        $bank_account_id = $this->bankAccountRepository->token($ValidationData['bankAccount'])->id;
        $ValidationData['bank_account_id'] = $bank_account_id;

        /* Mejorar la validación */
        $deposit = $this->depositRepository->getModel()
                   ->where('bank_account_id', $bank_account_id)
                   ->where('date', $ValidationData['date'])
                   ->where('number', $ValidationData['number'])
                   ->first();

        if($deposit){
        	return $this->errores('Ya ha ingresado un deposito con el mismo número de cuenta, fecha y monto.');
        }

        /* Declaramos las clases a utilizar */
        $deposit = $this->depositRepository->getModel();
        
        /* Validamos los datos para guardar tabla menu */
        if( $deposit->isValid($ValidationData) )
        {
            $deposit->fill($ValidationData);
        	$deposit->save();

        	if($request->hasFile('file')){
				$target_Path = public_path()."/storage/deposits";
				$file_name   = $deposit->token.".".$request->file('file')->guessExtension();
		        $request->file('file')->move($target_Path, $file_name);
		        $deposit->img_url = "/storage/deposits/".$file_name;
		        $deposit->update();
			}

        	/* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        }
        /* Enviamos el mensaje de error */
        return $this->errores($deposit->errors);		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($token)
	{
		$bankAccounts = $this->bankAccountRepository->allSchool();
		$deposit = $this->depositRepository->token($token);
        return view('deposits.edit', compact('bankAccounts', 'deposit'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update(Request $request)
	{
		/* Capturamos los datos enviados por ajax */
        $deposits = $request->all();
        
        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($deposits, 'Deposit');

        $bank_account_id = $this->bankAccountRepository->token($ValidationData['bankAccount'])->id;
        $ValidationData['bank_account_id'] = $bank_account_id;

        /* Declaramos las clases a utilizar */
        $deposit = $this->depositRepository->token($ValidationData['token']);

        /* Mejorar la validación */
        $deposit_validate = $this->depositRepository->getModel()
                   ->where('bank_account_id', $bank_account_id)
                   ->where('date', $ValidationData['date'])
                   ->where('number', $ValidationData['number'])
                   ->where('id', '<>', $deposit->id)
                   ->first();

        if($deposit_validate){
        	return $this->errores('Ya ha ingresado un deposito con el mismo número de cuenta, fecha y monto.');
        }
        
        /* Validamos los datos para guardar tabla menu */
        if( $deposit->isValid($ValidationData) )
        {
            $deposit->fill($ValidationData);
        	$deposit->save();

        	if($request->hasFile('file')){
				$target_Path = public_path()."/storage/deposits";
				$file_name   = $deposit->token.".".$request->file('file')->guessExtension();
		        $request->file('file')->move($target_Path, $file_name);
		        $deposit->img_url = "/storage/deposits/".$file_name;
		        $deposit->update();
			}

        	/* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        }
        /* Enviamos el mensaje de error */
        return $this->errores($deposit->errors);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($token)
	{
		// Delete row
        $deposit = $this->depositRepository->token($token);
        
        if ($deposit):
        	if(strlen($deposit->img_url) > 0){
        		\Log::info(public_path().$deposit->img_url);
        		\File::delete(public_path().$deposit->img_url);
        	}
        	$deposit->delete();
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se eliminó con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($deposit->errors);
	}

}
