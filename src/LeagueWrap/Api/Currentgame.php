<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\CurrentGame as CurrentGameDto;

/**
 * Spectator service endpoint
 */
class Currentgame extends AbstractApi {

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.0'
	];

	/**
	 * A list of all permitted regions for the league api call.
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
		'jp'
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 900;

	/**
	 * @return String domain used for the request
	 */
	function getDomain()
	{
		return $this->getRegion()->getCurrentGameDomain();
	}

	/**
	 * Gets the current game of summoner.
	 *
	 * @param \LeagueWrap\Api\Summoner|Int $identity
	 * @return \LeagueWrap\Dto\AbstractDto
	 * @throws \Exception
	 * @throws \LeagueWrap\Exception\CacheNotFoundException
	 * @throws \LeagueWrap\Exception\InvalidIdentityException
	 * @throws \LeagueWrap\Exception\RegionException
	 * @throws \LeagueWrap\Response\HttpClientError
	 * @throws \LeagueWrap\Response\HttpServerError
	 */
	public function currentGame($identity)
	{
		$summonerId = $this->extractId($identity);
		$response   = $this->request($summonerId, [], false, false);
		$game       = $this->attachStaticDataToDto(new CurrentGameDto($response));

		$this->attachResponse($identity, $game, 'game');

		return $game;
	}

}
