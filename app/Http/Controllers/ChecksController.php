<?php namespace Mep\Http\Controllers;

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
	public function create()
	{
                $voucher = Voucher::all();
                $suppliers= Supplier::all();
                $spreadsheets= Spreadsheet::all();
                $balancebudgets= BalanceBudget::all();
		return view('checks.create', compact('voucher','suppliers','spreadsheets','balancebudgets'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
                $check = Check::Token($token);
		$voucher = Voucher::all();
                $suppliers= Supplier::all();
                $spreadsheets= Spreadsheet::all();
                $balancebudgets= BalanceBudget::all();
		return view('checks.edit', compact('check','voucher','suppliers','spreadsheets','balancebudgets'));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
