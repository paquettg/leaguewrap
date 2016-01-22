<?php


namespace LeagueWrap\Dto;


class Service extends AbstractDto
{

	public function __construct(array $info)
	{
		foreach($info['incidents'] as &$incident) {
			$incident = new Incident($incident);
		}

		parent::__construct($info);
	}
}