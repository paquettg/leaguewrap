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
			foreach ($info['masteryTreeItems'] as $treeId => $masteryTreeItem)
			{
				// fix for null positions in the tree by insertion of dummy items
				if (is_array($masteryTreeItem)) 
				{
			       	$masteryTreeItemDto = new MasteryTreeItem($masteryTreeItem);
			    } 
			    else 
			    {
			        $masteryTreeItemDto = new MasteryTreeItem(["prereq" => "0", "masteryId" => 0]);
			    }
				$masteryTreeItems[$treeId] = $masteryTreeItemDto;
			}
			$info['masteryTreeItems'] = $masteryTreeItems;
		}

		parent::__construct($info);
	}
}


