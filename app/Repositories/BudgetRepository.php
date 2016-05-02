<?php
namespace Mep\Repositories;

use Carbon\Carbon;
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

	public function budgetSchoolOrderBy($data, $type) {
		$date = new Carbon();
		$date->daysInMonth;

		if($date->format('m') <= '02'):
			return $this->newQuery()->withTrashed()->where('school_id', userSchool()->id)->whereBetween('year',[($date->format('Y')-1),$date->format('Y')])->with('schools')->orderBy($data, $type)->get();
		else:
			return $this->newQuery()->withTrashed()->where('school_id', userSchool()->id)->where('year',$date->format('Y'))->with('schools')->orderBy($data, $type)->get();
		endif;
	}
}