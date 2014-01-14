<?php
namespace LeagueWrap\Response;

class PlayerStats extends Dto {

	public function __construct(array $info)
	{
		$aggregatedStats = $info['aggregatedStats'];
		$info['aggregatedStats'] = new Stats($aggregatedStats);

		$this->info = $info;
	}
}
