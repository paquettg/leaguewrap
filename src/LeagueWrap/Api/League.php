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
		'v2.4',
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
	 * Gets the league information by summoner id or list of summoner ids.
	 *
	 * @param mixed $identity
	 * @return array
	 */
	public function league($identities)
	{
		if (is_array($identities))
		{
			if (count($identities) > 40)
			{
				throw new ListMaxException('This request can only support a list of 40 elements, '.count($identities).' given.');
			}
		}

		$ids = $this->extractIds($identities);
		$ids = implode(',', $ids);
		$array   = $this->request('league/by-summoner/'.$ids);
		
		$summoners = [];
		foreach($array as $id => $summonerLeagues)
		{
			$leagues = [];
			foreach ($summonerLeagues as $info)
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
			$summoners[$id] = $leagues;
		}

		$this->attachResponses($identities, $summoners, 'leagues');

		if(count($summoners) == 1)
			return reset($summoners);
		else
			return $summoners;
	}

}
