<?php
namespace LeagueWrap\Dto;

class Game extends AbstractDto {
	use ImportStaticTrait;

	protected $staticFields = [
		'championId' => 'champion',
		'spell1'     => 'summonerSpell',
		'spell2'     => 'summonerSpell',
	];

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
	 * @param int $playerId
	 * @return Player|null
	 */
	public function player($playerId)
	{
		if ( ! isset($this->info['fellowPlayers']))
		{
			// no players
			return null;
		}
		$players = $this->info['fellowPlayers'];
		if (isset($players[$playerId]))
		{
			return $players[$playerId];
		}
		return null;
	}
}
