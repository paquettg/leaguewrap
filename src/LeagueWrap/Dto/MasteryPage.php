<?php
namespace LeagueWrap\Dto;

class MasteryPage extends AbstractListDto {

	protected $listKey = 'masteries';

	/**
	 * Attempts to get a mastery by its id.
	 *
	 * @param int $masteryId
	 * @return Mastery|null
	 */
	public function mastery($masteryId)
	{
		if ( ! isset($this->info['masteries']))
		{
			// no masteries
			return null;
		}
		$masteries = $this->info['masteries'];
		if (isset($masteries[$masteryId]))
		{
			return $masteries[$masteryId];
		}
		return null;
		
	}
}
