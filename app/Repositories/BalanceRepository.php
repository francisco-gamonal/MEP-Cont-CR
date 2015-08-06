<?php
namespace Mep\Repositories;

use Mep\Entities\Balance;
/**
* 
*/
class BalanceRepository extends BaseRepository
{
	
	public function getModel()
	{
		return new Balance();
	}

	
}