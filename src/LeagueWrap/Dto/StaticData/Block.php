<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class Block extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['items']))
		{
			$items = [];
			foreach ($info['items'] as $key => $item)
			{
				$items[$key] = new BlockItem($item);
			}
			$info['items'] = $items;
		}
		parent::__construct($info);
	}
}

