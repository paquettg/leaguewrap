<?php
namespace LeagueWrap\Api;

use LeagueWrap\ClientInterface;
use LeagueWrap\Response;
use LeagueWrap\Response\PlayerStats;

class Stats extends Api {

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.2',
	];

	/**
	 * The season we wish to get the stats from. Null will return
	 * the stats of the current season.
	 *
	 * @var string
	 */
	protected $season = null;

	/**
	 * A list of all permitted regions for the Stats api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'na',
		'eune',
		'euw',
	];

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * Sets the season param to the given input.
	 *
	 * @param string $season
	 * @chainable
	 */
	public function setSeason($season)
	{
		$this->season = trim(strtoupper($season));
		return $this;
	}

	/**
	 * Gets the stats summary by summoner id.
	 *
	 * @param mixed $identity
	 * @return array
	 */
	public function summary($identity)
	{
		$id = $this->extractId($identity);

		$params = [];
		if ( ! is_null($this->season))
		{
			$params['season'] = $this->season;
		}
		$array = $this->request('stats/by-summoner/'.$id.'/summary', $params);
		$stats = [];
		foreach ($array['playerStatSummaries'] as $key => $info)
		{
			$playerStats = new PlayerStats($info);
			$stats[$key] = $playerStats;
		}

		$this->attachResponse($identity, $stats, 'stats');

		return $stats;
	}

	/**
	 * Gets the stats for ranked queues only by summary id.
	 *
	 * @param mixed $identity
	 * @return array
	 */
	public function ranked($identity)
	{
		$id = $this->extractId($identity);

		$params = [];
		if ( ! is_null($this->season))
		{
			$params['season'] = $this->season;
		}
		$array = $this->request('stats/by-summoner/'.$id.'/ranked', $params);
		$stats = [];
		foreach ($array['champions'] as $key => $info)
		{
			$info['stats'] = new Response\Stats($info['stats']);
			$championStats = new Response\Champion($info);
			$stats[$key]   = $championStats;
		}

		$this->attachResponse($identity, $stats, 'rankedStats');

		return $stats;
	}
}
