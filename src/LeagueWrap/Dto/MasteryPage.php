<?php
namespace LeagueWrap\Dto;

class MasteryPage extends AbstractListDto {

	protected $listKey = 'masteries';

	/**
	 * Attempts to get a mastery by its id.
	 *
	 * @param int $id
	 * @return Mastery|null
	 */
	public function mastery($id)
	{
		if ( ! isset($this->info['masteries']))
		{
			// no masteries
			return null;
		}
		$masteries = $this->info['masteries'];
		if (isset($masteries[$id]))
		{
			return $masteries[$id];
		}
		return null;
		
	}
}
