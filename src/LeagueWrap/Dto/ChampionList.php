<?php
namespace LeagueWrap\Dto;

class ChampionList extends AbstractListDto {

	protected $listKey = 'champions';

	public function __construct(array $info)
	{
		if (isset($info['champions']))
		{
			$champions = [];
			foreach ($info['champions'] as $champion)
			{
				$championId             = intval($champion['id']);
				$championDto    = new Champion($champion);
				$champions[$championId] = $championDto;
			}
			$info['champions'] = $champions;
		}
		parent::__construct($info);
	}

	/**
	 * Get a champion by its id.
	 *
	 * @param int $championId
	 * @return Champion|null
	 */
	public function getChampion($championId)
	{
		if ( ! isset($this->info['champions'][$championId]))
		{
			return null;
		}
		return $this->info['champions'][$championId];
	}
}
