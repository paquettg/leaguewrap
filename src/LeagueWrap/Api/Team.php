<?php
namespace LeagueWrap\Api;

use LeagueWrap\ClientInterface;
use LeagueWrap\Response;

class Team extends AbstractApi {

	/**
	 * A list of all the teams we have received so far.
	 *
	 * @param array
	 */
	protected $teams = [];

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v2.2',
	];

	/**
	 * A list of all permitted regions for the Champion api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'br',
		'euw',
		'eune',
		'na',
		'tr',
	];

	public function __construct(ClientInterface $client)
	{
		$this->client = $client;
	}

	/**
	 * Gets the team information by summoner id.
	 *
	 * @param mixed $identity
	 * @return array
	 */
	public function team($identity)
	{
		$id = $this->extractId($identity);

		$array = $this->request('team/by-summoner/'.$id);
		$teams = [];
		foreach ($array as $info)
		{
			$id   = $info['fullId'];
			$team = new Response\Team($info);
			$teams[$id] = $team;
		}

		$this->attachResponse($identity, $teams, 'teams');

		foreach ($teams as $id => $team)
		{
			$this->teams[$id] = $team;
		}

		return $teams;
	}
}
