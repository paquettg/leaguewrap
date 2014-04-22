<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractDto;

class ChampionList extends AbstractDto {

	/**
	 * Set up the information about the ChampionList Dto.
	 *
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		if (isset($info['data']))
		{
			$data = [];
			foreach ($info['data'] as $id => $champion)
			{
				$championDto = new Champion($champion);
				$data[$id]   = $championDto;
			}
			$info['data'] = $data;
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get a champions information by $id
	 *
	 * @param int $id
	 * @return Champion|null
	 */
	public function getChampion($id)
	{
		if (isset($this->info['data'][$id]))
		{
			return $this->info['data'][$id];
		}

		return null;
	}
}
