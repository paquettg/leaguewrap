<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class MasteryTreeList extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['masteryTreeItems']))
		{
			$masteryTreeItems = [];
			foreach ($info['masteryTreeItems'] as $id => $masteryTreeItem)
			{
				$masteryTreeItemDto    = new MasteryTreeItem($masteryTreeItem);
				$masteryTreeItems[$id] = $masteryTreeItemDto;
			}
			$info['masteryTreeItems'] = $masteryTreeItems;
		}

		parent::__construct($info);
	}
}


