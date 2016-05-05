<?php
namespace Mep\Repositories;

use Mep\Entities\Deposit;

/**
* 
*/
class DepositRepository extends BaseRepository
{
	public function getModel()
	{
		return new Deposit();
	}
}