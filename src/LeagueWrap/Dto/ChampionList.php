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
				$id             = intval($champion['id']);
				$championDto    = new Champion($champion);
				$champions[$id] = $championDto;
			}
			$info['champions'] = $champions;
		}
		parent::__construct($info);
	}

	/**
	 * Get a champion by its id.
	 *
	 * @param int $id
	 * @return Champion|null
	 */
	public function getChampion($id)
	{
		if ( ! isset($this->info['champions'][$id]))
		{
			return null;
		}
		return $this->info['champions'][$id];
	}
}
