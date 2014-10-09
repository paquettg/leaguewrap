<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\RankedStats;
use LeagueWrap\Dto\PlayerStatsSummaryList;

class Stats extends AbstractApi {

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.3',
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
		'br',
		'eune',
		'euw',
		'lan',
		'las',
		'na',
		'oce',
		'ru',
		'tr',
		'kr',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 600;

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
		$summonerId = $this->extractId($identity);

		$params = [];
		if ( ! is_null($this->season))
		{
			$params['season'] = $this->season;
		}
		$info  = $this->request('stats/by-summoner/'.$summonerId.'/summary', $params);
		$stats = new PlayerStatsSummaryList($info);
		$stats = $this->attachStaticDataToDto($stats);

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
		$summonerId = $this->extractId($identity);

		$params = [];
		if ( ! is_null($this->season))
		{
			$params['season'] = $this->season;
		}
		$info  = $this->request('stats/by-summoner/'.$summonerId.'/ranked', $params);
		$stats = $this->attachStaticDataToDto(new RankedStats($info));

		$this->attachResponse($identity, $stats, 'rankedStats');

		return $stats;
	}
}
