<?php
namespace Mep\Repositories;

use Mep\Entities\BankAccount;

/**
* 
*/
class BankAccountRepository extends BaseRepository
{
	public function getModel()
	{
		return new BankAccount();
	}
}