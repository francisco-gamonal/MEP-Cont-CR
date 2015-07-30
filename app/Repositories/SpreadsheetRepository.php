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
		
      	$spreadsheet = $this->newQuery()->whereIn('budget_id', $this->budgetRepository->lists('id'))
      	->orderBy('year', 'DESC')
      	->orderBy('budget_id', 'ASC')
      	->orderBy('type_budget_id', 'ASC')
      	->orderBy('number', 'ASC')->get();
      	if(count($spreadsheet)>0):
      		return $spreadsheet;
      	endif;

      		return false;
    }	
    
    public function spreadsheetListsSchool($keyList)
	{
      	return $this->newQuery()->whereIn('budget_id', $this->budgetRepository->lists('id'))->orderBy('year', 'DESC')->orderBy('number', 'ASC')->lists($keyList);
    }
}