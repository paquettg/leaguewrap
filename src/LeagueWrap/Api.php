<?php
namespace LeagueWrap;

use LeagueWrap\Api\Champion;
use LeagueWrap\Api\Summoner;
use LeagueWrap\Api\Game;
use LeagueWrap\Api\League;
use LeagueWrap\Api\Stats;
use LeagueWrap\Api\Team;

class Api {

	/**
	 * Default api url.
	 *
	 * @var string
	 */
	protected $url = 'http://prod.api.pvp.net/api/lol/';

	/**
	 * The region to be used. Defaults to 'na'.
	 *
	 * @var string
	 */
	protected $region = 'na';

	/**
	 * The client used to connect with the riot API.
	 *
	 * @var object
	 */
	protected $client;

	/**
	 * This is the api key, very important.
	 *
	 * @var string
	 */
	private $key;

	/**
	 * Initiat the default client and key.
	 *
	 * @param string $key
	 */
	public function __construct($key = null, ClientInterface $client = null)
	{
		if (is_null($key))
		{
			throw new Exception('We need a key... it\'s very important!');
		}

		if (is_null($client))
		{
			// set up the default client
			$client = new Client;
		}
		$this->client = $client;
		$this->client->baseUrl($this->url);

		// add the key
		$this->key = $key;
	}

	/**
	 * Change the url for the client.
	 *
	 * @param string $url
	 * @chainable
	 */
	public function resetUrl($url)
	{
		$this->client->baseUrl($url);
		return $this;
	}

	/**
	 * Set the region code to a valid string.
	 *
	 * @param string $region
	 * @chainable
	 */
	public function setRegion($region)
	{
		$this->region = $region;
		return $this;
	}

	/**
	 * Start a champion request.
	 *
	 * @return Champion
	 */
	public function champion()
	{
		$champion = new Champion($this->client);
		$champion->setKey($this->key)
		         ->setRegion($this->region);

		return $champion;
	}

	/**
	 * Start a summoner request. We need either the summoner name
	 * or id for most of the requests in this object.
	 *
	 * @return Summoner;
	 */
	public function summoner()
	{
		$summoner = new Summoner($this->client);
		$summoner->setKey($this->key)
		         ->setRegion($this->region);

		return $summoner;
	}

	/**
	 * Start a game request. We need the summoner id for all
	 * requests in this object.
	 *
	 * @return Game;
	 */
	public function game()
	{
		$game = new Game($this->client);
		$game->setKey($this->key)
		     ->setRegion($this->region);

		return $game;
	}

	/**
	 * Starts a league request. We need the summoner id for all
	 * requests in this object.
	 *
	 * @return League
	 */
	public function league()
	{
		$league = new League($this->client);
		$league->setKey($this->key)
		       ->setRegion($this->region);
		
		return $league;
	}

	/**
	 * Starts a stats request. We need the summoner id for all
	 * requests in this object.
	 *
	 * @return Stats
	 */
	public function stats()
	{
		$stats = new Stats($this->client);
		$stats->setKey($this->key)
		      ->setRegion($this->region);
		
		return $stats;
	}

	/**
	 * Starts a team request. We need the summoner id for all
	 * requests in this object.
	 *
	 * @return Team
	 */
	public function team()
	{
		$team = new Team($this->team);
		$team->setKey($this->key)
		     ->setRegion($this->region);
	    
	    return $team;
	}
}
