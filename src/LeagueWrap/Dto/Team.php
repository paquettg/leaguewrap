<?php
namespace LeagueWrap\Dto;

class Team extends AbstractListDto {

	protected $listKey = 'matchHistory';

	public function __construct(array $info)
	{
		if (isset($info['roster']))
		{
			$info['roster'] = new Team\Roster($info['roster']);
		}
		if (isset($info['matchHistory']))
		{
			$matches = [];
			foreach ($info['matchHistory'] as $id => $match)
			{
				$match        = new Team\Match($match);
				$matches[$id] = $match;
			}
			$info['matchHistory'] = $matches;
		}
		if (isset($info['teamStatDetails']))
		{
			$details = [];
			foreach ($info['teamStatDetails'] as $key => $detail)
			{
				$details[] = new Stats($detail);
			}
			$info['teamStatDetails'] = $details;
		}

		parent::__construct($info);
	}
}
