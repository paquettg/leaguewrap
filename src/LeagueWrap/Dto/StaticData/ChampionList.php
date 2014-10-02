<?php
namespace LeagueWrap\Dto\StaticData;

use LeagueWrap\Dto\AbstractListDto;

class ChampionList extends AbstractListDto {

	protected $listKey = 'data';

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
			foreach ($info['data'] as $championId => $champion)
			{
				$championDto       = new Champion($champion);
				$data[$championId] = $championDto;
			}
			$info['data'] = $data;
		}

		parent::__construct($info);
	}

	/**
	 * Quick shortcut to get a champions information by $championId
	 *
	 * @param int $championId
	 * @return Champion|null
	 */
	public function getChampion($championId)
	{
		if (isset($this->info['data'][$championId]))
		{
			return $this->info['data'][$championId];
		}

		return null;
	}
}
