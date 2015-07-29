<?php
namespace Mep\Repositories;

use Mep\Entities\Transfer;

/**
* 
*/
class TransfersRepository extends BaseRepository
{
		

	
	public function getModel()
	{
		return new Transfer();
	}
}