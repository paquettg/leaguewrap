<?php
namespace LeagueWrap\Response;

class Summoner extends Dto {

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
		$masteryPages = $this->info['recentGames'];
		if (isset($masteryPages[$id]))
		{
			return $masteryPages[$id];
		}
		return null;
	}
}
