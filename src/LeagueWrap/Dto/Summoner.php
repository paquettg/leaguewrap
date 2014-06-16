<?php
namespace LeagueWrap\Dto;

class Summoner extends AbstractDto {

	/**
	 * Attempts to get a rune page by the id.
	 *
	 * @param int $id
	 * @return RunePage|null
	 */
	public function runePage($id)
	{
		if ( ! isset($this->info['runePages']))
		{
			// no rune pages
			return null;
		}
		$runePages = $this->info['runePages'];
		if (isset($runePages[$id]))
		{
			return $runePages[$id];
		}
		return null;
	}

	/**
	 * Attempts to get the mastery page by the id.
	 *
	 * @param int $id
	 * @return MasteryPage|null
	 */
	public function masteryPage($id)
	{
		if ( ! isset($this->info['masteryPages']))
		{
			// no rune pages
			return null;
		}
		$masteryPages = $this->info['masteryPages'];
		if (isset($masteryPages[$id]))
		{
			return $masteryPages[$id];
		}
		return null;
	}

	/**
	 * Attempts to get the game by the id.
	 *
	 * @param int $id
	 * @return MasteryPage|null
	 */
	public function recentGame($id)
	{
		if ( ! isset($this->info['recentGames']))
		{
			// no rune pages
			return null;
		}
		$recentGames = $this->info['recentGames'];
		return $recentGames->game($id);
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
