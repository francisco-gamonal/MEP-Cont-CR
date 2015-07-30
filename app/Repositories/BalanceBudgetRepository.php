<?php
namespace Mep\Repositories;

use Mep\Entities\BalanceBudget;
use Mep\Repositories\BudgetRepository;
/**
* 
*/
class BalanceBudgetRepository extends BaseRepository
{
		private  $budgetRepository;

	public function __construct(BudgetRepository $budgetRepository){
		$this->budgetRepository = $budgetRepository;
        
	}
	
	public function getModel()
	{
		return new BalanceBudget();
	}

	public function balanceBudgetListsSchool($data){
	return $this->getModel()->newQuery()->whereIn('budget_id', $this->budgetRepository->lists('id'))->lists($data);
	}
		public function balanceBudgetSchool(){
	return $this->newQuery->whereIn('budget_id', $this->budgetRepository->lists('id'))->get();
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
    public function accountBlanceBudget($spreadSheet)
    {
        $balancebudgets = $this->getModel()->newQuery()->where('budget_id',  $spreadSheet->budget_id)
        ->where('type_budget_id',  $spreadSheet->type_budget_id)
        ->get();
        
        if(count($balancebudgets)>0){
            foreach ($balancebudgets as $balanceBudgets):
            $balanceBudget[] = array('idBalanceBudgets' => $balanceBudgets->id, 'id' => $balanceBudgets->token,
                'value' => $balanceBudgets->catalogs->p.'-'.$balanceBudgets->catalogs->g.'-'.$balanceBudgets->catalogs->sp.' || '.$balanceBudgets->catalogs->name.' || '.$balanceBudgets->typeBudgets->name, );
        endforeach;
        return $balanceBudget;
        }
     
 return false;
       

        
    }
}