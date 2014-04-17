<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto;

class League extends AbstractApi {

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v2.3',
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
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 43200;

	/**
	 * Gets the league information by summoner id.
	 *
	 * @param mixed $identity
	 * @return array
	 */
	public function league($identity)
	{
		$id = $this->extractId($identity);

		$array   = $this->request('league/by-summoner/'.$id);
		$leagues = [];
		foreach ($array as $info)
		{
			$key           = $info['participantId'];
			$info['id']    = $key;
			$league        = new Dto\League($info);
			if ( ! is_null($league->playerOrTeam))
			{
				$key = $league->playerOrTeam->playerOrTeamName;
			}
			$leagues[$key] = $league;
		}

		$this->attachResponse($identity, $leagues, 'leagues');

		return $leagues;
	}

}
