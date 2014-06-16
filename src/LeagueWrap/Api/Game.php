<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\RecentGames;

class Game extends AbstractApi {

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.3',
	];

	/**
	 * A list of all permitted regions for the Champion api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'br',
		'eune',
		'euw',
		'lan',
		'las',
		'na',
		'oce',
		'kr',
		'ru',
		'tr',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 1800;

	/**
	 * Get the recent games by summoner id.
	 *
	 * @param mixed $id
	 * @return array
	 */
	public function recent($identity)
	{
		$id = $this->extractId($identity);

		$array = $this->request('game/by-summoner/'.$id.'/recent');
		$games = new RecentGames($array);

		$this->attachResponse($identity, $games, 'recentGames');

		return $games;
	}
}
