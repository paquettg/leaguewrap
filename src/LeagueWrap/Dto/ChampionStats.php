<?php
namespace LeagueWrap\Dto;

class ChampionStats extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['stats']))
		{
			$info['stats'] = new AggregateStats($info['stats']);
		}
		parent::__construct($info);
	}
}
