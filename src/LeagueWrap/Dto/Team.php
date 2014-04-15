<?php
namespace LeagueWrap\Dto;

class Team extends AbstractDto {

	public function __construct(array $info)
	{
		$info['teamStatSummary'] = new Team\Stats($info['teamStatSummary']);
		$info['roster']          = new Team\Roster($info['roster']);
		$matchHistory = $info['matchHistory'];
		$matches      = [];
		foreach ($matchHistory as $id => $match)
		{
			$match        = new Team\Match($match);
			$matches[$id] = $match;
		}
		$info['matchHistory'] = $matches;

		$this->info = $info;
	}
}
