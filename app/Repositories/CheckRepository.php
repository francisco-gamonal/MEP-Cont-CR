<?php
namespace Mep\Repositories;

use Mep\Entities\Check;
/**
* 
*/
class CheckRepository extends BaseRepository
{
	
	public function getModel()
	{
		return new Check();
	}

	
	
}