<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class MasteryTree extends AbstractDto {

	/**
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		foreach($info as $treeName => $rawTree)
		{
			$tree = [];
			foreach($rawTree as $id => $masteryTreeList)
			{
				$masteryTreeListDto = new MasteryTreeList($masteryTreeList);
				$tree[$id] = $masteryTreeListDto;
			}
			$info[$treeName] = $tree;

		}

		parent::__construct($info);
	}
}

