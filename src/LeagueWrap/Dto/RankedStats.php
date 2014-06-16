<?php
namespace LeagueWrap\Dto;

class RankedStats extends AbstractListDto {

	protected $listKey = 'champions';

	public function __construct(array $info)
	{
		if (isset($info['champions']))
		{
			$champions = [];
			foreach ($info['champions'] as $key => $champion)
			{
				$championStats   = new ChampionStats($champion);
				$champions[$key] = $championStats;
			}
			$info['champions'] = $champions;
		}
		parent::__construct($info);
	}

	/**
	 * Get the champion by the id returned by the API.
	 *
	 * @param int $id
	 * @return ChampionStats|null
	 */
	public function champion($id)
	{
		if ( ! isset($this->info['champions'][$id]))
		{
			return null;
		}

		return $this->info['champions'][$id];
	}
}
