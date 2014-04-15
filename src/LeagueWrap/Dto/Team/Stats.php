<?php
namespace LeagueWrap\Dto\Team;

use LeagueWrap\Dto;
use LeagueWrap\Dto\AbstractDto;

class Stats extends AbstractDto {

	public function __construct(array $info)
	{
		$teamStatDetails = $info['teamStatDetails'];
		$details         = [];
		foreach ($teamStatDetails as $key => $detail)
		{
			$details[] = new Dto\Stats($detail);
		}
		$info['teamStatDetails'] = $details;

		$this->info = $info;
	}
}
