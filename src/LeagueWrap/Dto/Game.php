<?php
namespace LeagueWrap\Dto;

class Game extends AbstractDto {

	/**
	 * Set up the information about this game.
	 *
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		if ( ! isset($info['fellowPlayers']))
		{
			// solo game
			$info['fellowPlayers'] = [];
		}
		$fellowPlayers = $info['fellowPlayers'];
		$players       = [];
		foreach ($fellowPlayers as $key => $value)
		{
			$player        = new Player($value);
			$players[$key] = $player;
		}
		$info['fellowPlayers'] = $players;

		// put the stats in its own Dto
		$stats = new Stats($info['stats']);
		$info['stats'] = $stats;

		parent::__construct($info);
	}

	/**
	 * Attempts to get a fellow player from this game.
	 *
	 * @param int $id
	 * @return Player|null
	 */
	public function player($id)
	{
		if ( ! isset($this->info['fellowPlayers']))
		{
			// no players
			return null;
		}
		$players = $this->info['fellowPlayers'];
		if (isset($players[$id]))
		{
			return $players[$id];
		}
		return null;
	}
}
