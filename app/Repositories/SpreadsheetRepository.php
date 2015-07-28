<?php
namespace Mep\Repositories;

use Mep\Entities\Spreadsheet;
use Mep\Repositories\BudgetRepository;
/**
* 
*/
class SpreadsheetRepository extends BaseRepository
{
	private  $budgetRepository;

	public function __construct(BudgetRepository $budgetRepository){
		$this->budgetRepository = $budgetRepository;
        
	}
	
	public function getModel()
	{
		return new Spreadsheet();
	}


	public function spreadsheetSchool()
	{
		
      	return $this->newQuery()->whereIn('budget_id', $this->budgetRepository->lists('id'))->orderBy('year', 'DESC')->orderBy('number', 'ASC')->get();
    }	
    
    public function spreadsheetListsSchool($keyList)
	{
      	return $this->newQuery()->whereIn('budget_id', $this->budgetRepository->lists('id'))->orderBy('year', 'DESC')->orderBy('number', 'ASC')->lists($keyList);
    }
}