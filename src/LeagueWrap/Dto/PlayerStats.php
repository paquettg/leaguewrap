<?php
namespace LeagueWrap\Dto;

class PlayerStats extends AbstractDto {

	public function __construct(array $info)
	{
		$aggregatedStats = $info['aggregatedStats'];
		$info['aggregatedStats'] = new Stats($aggregatedStats);

		$this->info = $info;
	}
}
