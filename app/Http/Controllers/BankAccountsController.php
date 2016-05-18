<?php namespace Mep\Http\Controllers;

use Mep\Http\Controllers\Controller;
use Mep\Repositories\BankAccountRepository;

use Illuminate\Http\Request;

class BankAccountsController extends Controller 
{
	private $bankAccountRepository;

	/**
     * Create a new controller instance.
     */
    public function __construct(
    		BankAccountRepository $bankAccountRepository
    	)
    {
        $this->middleware('auth');
        $this->bankAccountRepository = $bankAccountRepository;
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$bankAccounts = $this->bankAccountRepository->allSchool();

        return view('bankAccounts.index', compact('bankAccounts'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('bankAccounts.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		/* Capturamos los datos enviados por ajax */
        $bankAccounts = $this->convertionObjeto();

        /* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($bankAccounts, 'BankAccount', 'name');
        
		$ValidationData['school_id'] = userSchool()->id;
		$ValidationData['balance']   = 0;
		echo json_encode($ValidationData);
		die;
        /* Declaramos las clases a utilizar */
        $bankAccount = $this->bankAccountRepository->getModel();
        
        /* Validamos los datos para guardar tabla menu */
        if( $bankAccount->isValid($ValidationData) )
        {
            $bankAccount->fill($ValidationData);
        	$bankAccount->save();
        	/* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        }
        /* Enviamos el mensaje de error */
        return $this->errores($bankAccount->errors);
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
		$bankAccount = $this->bankAccountRepository->token($token);
        return view('bankAccounts.edit', compact('bankAccount'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update()
	{
		$bankAccounts = $this->convertionObjeto();
		
		/* Creamos un array para cambiar nombres de parametros */
        $ValidationData = $this->CreacionArray($bankAccounts, 'BankAccount');
        $ValidationData['school_id'] = userSchool()->id;
        
        $bankAccount = $this->bankAccountRepository->token($ValidationData['token']);

        /* Validamos los datos para guardar tabla menu */
        if( $bankAccount->isValid($ValidationData) )
        {
            $bankAccount->fill($ValidationData);
        	$bankAccount->save();
        	/* Enviamos el mensaje de guardado correctamente */
            return $this->exito('Los datos se guardaron con exito!!!');
        }
        /* Enviamos el mensaje de error */
        return $this->errores($bankAccount->errors);
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
        $data = $this->bankAccountRepository->token($token)->delete();
        
        if ($data):
            /* si todo sale bien enviamos el mensaje de exito */
            return $this->exito('Se eliminó con exito!!!');
        endif;
        /* si hay algun error  los enviamos de regreso */
        return $this->errores($data->errors);
	}

}
