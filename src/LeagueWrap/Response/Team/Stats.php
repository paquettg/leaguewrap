<?php
namespace LeagueWrap\Response\Team;

use LeagueWrap\Response;
use LeagueWrap\Response\Dto;

class Stats extends Dto {

	public function __construct(array $info)
	{
		$teamStatDetails = $info['teamStatDetails'];
		$details         = [];
		foreach ($teamStatDetails as $key => $detail)
		{
			$details[] = new Response\Stats($detail);
		}
		$info['teamStatDetails'] = $details;

		$this->info = $info;
	}
}
