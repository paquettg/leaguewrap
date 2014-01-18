<?php
namespace LeagueWrap;

use LeagueWrap\Api\AbstractApi;

class Api {

	/**
	 * Default api url.
	 *
	 * @var string
	 */
	protected $url = 'https://prod.api.pvp.net/api/lol/';

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
	 * Should we even try to cache any of the requests?
	 *
	 * @var bool
	 */
	protected $cache = false;

	/**
	 * How long, in seconds, should we remember a query's response.
	 *
	 * @var int
	 */
	protected $remember = null;

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
	 * This is the primary service locater if you utilize the api (which you should) to 
	 * load instance of the abstractApi. This is the method that is called when you attempt
	 * to invoke "Champion()", "League()", etc.
	 *
	 * @param string $method
	 * @param array $arguments
	 * @return AbstractApi
	 */
	public function __call($method, $arguments)
	{
		$className = 'LeagueWrap\\Api\\'.ucwords(strtolower($method));
		$api       = new $className($this->client);
		if ( ! $api instanceof AbstractApi)
		{
			// This is not an api class.
			throw new Exception('The api class "'.$className.'" was not found.');
		}

		$api->setKey($this->key)
		    ->setRegion($this->region);

		if ($this->cache)
		{
			$api->remember($this->remember);
		}

		return $api;
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
	 * Sets the amount of seconds we should remember the response for.
	 * Leave it empty (or null) if you want to use the default set for 
	 * each api request.
	 *
	 * @param int $seconds
	 * @chainable
	 */
	public function remember($seconds = null)
	{
		$this->cache    = true;
		$this->remember = $seconds;
		return $this;
	}
}
