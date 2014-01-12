<?php
namespace LeagueWrap\Api;

use LeagueWrap\Response;

class Game extends Api {

	/**
	 * The games we have loaded
	 * 
	 * @var array
	 */
	protected $games = [];

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.3',
	];

	public function __construct($client)
	{
		$this->client = $client;
	}

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
		$games = [];
		foreach ($array['games'] as $info)
		{
			$game    = new Response\Game($info);
			$games[] = $game;
		}

		$this->attachResponse($identity, $games, 'recentGames');

		return $games;
	}

}
