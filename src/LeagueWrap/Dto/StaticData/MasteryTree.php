<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class MasteryTree extends AbstractDto {

	public function __construct(array $info)
	{
		if (isset($info['Defense']))
		{
			$defense = [];
			foreach ($info['Defense'] as $id => $masteryTreeList)
			{
				$masteryTreeListDto = new MasteryTreeList($masteryTreeList);
				$defense[$id]       = $masteryTreeListDto;
			}
			$info['Defense'] = $defense;
		}
		if (isset($info['Offense']))
		{
			$offense = [];
			foreach ($info['Offense'] as $id => $masteryTreeList)
			{
				$masteryTreeListDto = new MasteryTreeList($masteryTreeList);
				$offense[$id]       = $masteryTreeListDto;
			}
			$info['Offense'] = $offense;
		}
		if (isset($info['Utility']))
		{
			$utility = [];
			foreach ($info['Utility'] as $id => $masteryTreeList)
			{
				$masteryTreeListDto = new MasteryTreeList($masteryTreeList);
				$utility[$id]       = $masteryTreeListDto;
			}
			$info['Utility'] = $utility;
		}

		parent::__construct($info);
	}
}

