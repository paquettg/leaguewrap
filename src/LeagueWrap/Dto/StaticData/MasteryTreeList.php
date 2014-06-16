<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractListDto;

class MasteryTreeList extends AbstractListDto {

	protected $listKey = 'masteryTreeItems';

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


