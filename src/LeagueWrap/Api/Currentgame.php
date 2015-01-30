<?php


namespace LeagueWrap\Api;
use \LeagueWrap\Dto\CurrentGame as CurrentGameDto;

/**
 * Spectator service endpoint
 */
class Currentgame extends AbstractApi
{

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = ['v1.0'];

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
	];

	/**
	 * @param platform ids for regions
	 */
	protected $platformIds = [
		'na' => 'NA1',
		'euw' => 'EUW1',
		'br' => 'BR1',
		'lan' => 'LA1',
		'las' => 'LA2',
		'oce' => 'OC1',
		'eune' => 'EUN1',
		'tr' => 'TR1',
		'ru' => 'RU',
		'kr' => 'KR'
	];

	public function currentGame($identity)
	{
		$summonerId = $this->extractId($identity);
		$info = $this->request('consumer/getSpectatorGameInfo/' . '%1$s' . '/' . $summonerId, [], false, true);
		$game = new CurrentGameDto($info);
		$game = $this->attachStaticDataToDto($game);

		$this->attachResponse($identity, $game, 'game');

		return $game;
	}

	/**
	 * Intercept client request to patch platform id into url (ugly hack!)
	 */
	protected function clientRequest($static, $uri, $params)
	{
		$uri = sprintf($uri, $this->platformIds[$this->region->getRegion()]);
		return parent::clientRequest($static, $uri, $params);
	}
}