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
			foreach ($info['data'] as $id => $mastery)
			{
				$masteryDto = new Mastery($mastery);
				$data[$id]  = $masteryDto;
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
	 * Quick shortcut to get mastery information by $id
	 *
	 * @param int $id
	 * @return Mastery|null
	 */
	public function getMastery($id)
	{
		if (isset($this->info['data'][$id]))
		{
			return $this->info['data'][$id];
		}

		return null;
	}
}
