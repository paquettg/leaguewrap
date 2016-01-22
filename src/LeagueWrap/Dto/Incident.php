<?php


namespace LeagueWrap\Dto;


class Incident extends AbstractDto
{
	public function __construct(array $info)
	{
			foreach($info['updates'] as &$update) {
				$update = new Message($update);
			}
			parent::__construct($info);
	}
}