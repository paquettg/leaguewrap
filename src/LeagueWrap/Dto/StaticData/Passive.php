<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class Passive extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['image']))
		{
			$info['image'] = new Image($info['image']);
		}

		parent::__construct($info);
	}
}

