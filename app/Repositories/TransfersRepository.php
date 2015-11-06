<?php
namespace Mep\Repositories;

use Mep\Entities\Transfer;
use Mep\Repositories\BalanceBudgetRepository;
/**
* 
*/
class TransfersRepository extends BaseRepository
{
		
    private $balanceBudgetRepository;
    

    /**
     * Create a new controller instance.
     */
    public function __construct(
        BalanceBudgetRepository $balanceBudgetRepository
        )
    {
       
        $this->balanceBudgetRepository = $balanceBudgetRepository;
       
    }
	
	public function getModel()
	{
		return new Transfer();
	}

	public function listTransferIndex($campo, $budgetsId){
		return $this->newQuery()->where($campo, $budgetsId)->whereIn('balance_budget_id',$this->balanceBudgetRepository->balanceBudgetListsSchool('id'))->get();
	}
}