<?php
namespace Mep\Repositories;

use Mep\Entities\Budget;
/**
* 
*/
class BudgetRepository extends BaseRepository
{
	
	public function getModel()
	{
		return new Budget();
	}
}