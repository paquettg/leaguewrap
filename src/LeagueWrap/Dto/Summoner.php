<?php
namespace LeagueWrap\Dto;

class Summoner extends AbstractDto {

	/**
	 * Attempts to get a rune page by the id.
	 *
	 * @param int $runePageId
	 * @return RunePage|null
	 */
	public function runePage($runePageId)
	{
		if ( ! isset($this->info['runePages']))
		{
			// no rune pages
			return null;
		}
		$runePages = $this->info['runePages'];
		if (isset($runePages[$runePageId]))
		{
			return $runePages[$runePageId];
		}
		return null;
	}

	/**
	 * Attempts to get the mastery page by the id.
	 *
	 * @param int $masteryPageId
	 * @return MasteryPage|null
	 */
	public function masteryPage($masteryPageId)
	{
		if ( ! isset($this->info['masteryPages']))
		{
			// no rune pages
			return null;
		}
		$masteryPages = $this->info['masteryPages'];
		if (isset($masteryPages[$masteryPageId]))
		{
			return $masteryPages[$masteryPageId];
		}
		return null;
	}

	/**
	 * Attempts to get the game by the id.
	 *
	 * @param int $gameId
	 * @return MasteryPage|null
	 */
	public function recentGame($gameId)
	{
		if ( ! isset($this->info['recentGames']))
		{
			// no rune pages
			return null;
		}
		$recentGames = $this->info['recentGames'];
		return $recentGames->game($gameId);
	}

	/**
	 * Attempts to get a league by the champion/team name or
	 * id.
	 *
	 * @param mixed $identity
	 * @return League|null
	 */
	public function league($identity)
	{
		if ( ! isset($this->info['leagues']))
		{
			// no leagues
			return null;
		}
		$leagues = $this->info['leagues'];
		foreach ($leagues as $league)
		{
			if (is_null($league->playerOrTeam))
			{
				// we could not find the player or team in this league
				continue;
			}

			// try the name
			if (strtolower($league->playerOrTeam->playerOrTeamName) == strtolower($identity))
			{
				return $league;
			}

			// try the id
			if ($league->playerOrTeam->playerOrTeamId == $identity)
			{
				return $league;
			}
		}
		return null;
	}
}
