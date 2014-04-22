<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class Item extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['gold']))
		{
			$info['gold'] = new Gold($info['gold']);
		}
		if (isset($info['image']))
		{
			$info['image'] = new Image($info['image']);
		}
		if (isset($info['rune']))
		{
			$info['rune'] = new MetaData($info['rune']);
		}
		if (isset($info['stats']))
		{
			$info['stats'] = new BasicDataStats($info['stats']);
		}

		parent::__construct($info);
	}
}
