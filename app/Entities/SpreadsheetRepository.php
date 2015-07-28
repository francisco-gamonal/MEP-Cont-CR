<?php
namespace Mep\Repositories;

use Mep\Entities\Spreadsheet;
/**
* 
*/
class SpreadsheetRepository extends BaseRepository
{
	
	public function getModel()
	{
		return new Spreadsheet();
	}
}