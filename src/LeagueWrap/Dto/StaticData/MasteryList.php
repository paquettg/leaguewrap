<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractListDto;

class MasteryList extends AbstractListDto {

	protected $listKey = 'data';

	public function __construct(array $info)
	{
		if (isset($info['data']))
		{
			$data = [];
			foreach ($info['data'] as $masteryId => $mastery)
			{
				$masteryDto = new Mastery($mastery);
				$data[$masteryId]  = $masteryDto;
			}
			$info['data'] = $data;
		}
		if (isset($info['tree']))
		{
			$info['tree'] = new MasteryTree($info['tree']);
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get mastery information by $masteryId
	 *
	 * @param int $masteryId
	 * @return Mastery|null
	 */
	public function getMastery($masteryId)
	{
		if (isset($this->info['data'][$masteryId]))
		{
			return $this->info['data'][$masteryId];
		}

		return null;
	}
}
