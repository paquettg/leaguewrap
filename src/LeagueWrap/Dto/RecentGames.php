<?php
namespace LeagueWrap\Dto;

class RecentGames extends AbstractListDto {

	protected $listKey = 'games';

	public function __construct(array $info)
	{
		if (isset($info['games']))
		{
			$games = [];
			foreach ($info['games'] as $gameId => $game)
			{
				$gameDto        = new Game($game);
				$games[$gameId] = $gameDto;
			}
			$info['games'] = $games;
		}

		parent::__construct($info);
	}

	/**
	 * Get a game by the id.
	 *
	 * @param int $gameId
	 * @return Game|null
	 */
	public function game($gameId)
	{
		if ( ! isset($this->info['games'][$gameId]))
		{
			return null;
		}

		return $this->info['games'][$gameId];
	}
}
