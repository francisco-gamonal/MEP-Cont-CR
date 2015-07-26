<?php
namespace Mep\Repositories;

use Mep\Entities\BalanceBudget;
/**
* 
*/
class BalanceBudgetRepository extends BaseRepository
{
	
	public function getModel()
	{
		return new BalanceBudget();
	}
}