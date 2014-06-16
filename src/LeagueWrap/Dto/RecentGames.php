<?php
namespace LeagueWrap\Dto;

class RecentGames extends AbstractListDto {

	protected $listKey = 'games';

	public function __construct(array $info)
	{
		if (isset($info['games']))
		{
			$games = [];
			foreach ($info['games'] as $id => $game)
			{
				$gameDto    = new Game($game);
				$games[$id] = $gameDto;
			}
			$info['games'] = $games;
		}

		parent::__construct($info);
	}

	/**
	 * Get a game by the id.
	 *
	 * @param int $id
	 * @return Game|null
	 */
	public function game($id)
	{
		if ( ! isset($this->info['games'][$id]))
		{
			return null;
		}

		return $this->info['games'][$id];
	}
}
