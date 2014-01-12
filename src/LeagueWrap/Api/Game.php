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
		if ($identity instanceof Response\Summoner)
		{
			$id = $identity->id;
		}
		elseif (is_int($identity))
		{
			$id = $identity;
		}
		else
		{
			throw new Exception('The identity given was not valid for a recent games request.');
		}

		$array = $this->request('game/by-summoner/'.$id.'/recent');
		$games = [];
		foreach ($array['games'] as $info)
		{
			$game    = new Response\Game($info);
			$games[] = $game;
		}

		if ($identity instanceof Response\Summoner)
		{
			$identity->recentGames = $games;
		}

		return $games;
	}

}
