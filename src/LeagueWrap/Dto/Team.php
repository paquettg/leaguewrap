<?php
namespace LeagueWrap\Dto;

class Team extends AbstractDto {

	public function __construct(array $info)
	{
		$info['roster']          = new Team\Roster($info['roster']);
		$matchHistory = $info['matchHistory'];
		$matches      = [];
		foreach ($matchHistory as $id => $match)
		{
			$match        = new Team\Match($match);
			$matches[$id] = $match;
		}
		$info['matchHistory'] = $matches;

		$teamStatDetails = $info['teamStatDetails'];
		$details         = [];
		foreach ($teamStatDetails as $key => $detail)
		{
			$details[] = new Stats($detail);
		}
		$info['teamStatDetails'] = $details;


		$this->info = $info;
	}
}
