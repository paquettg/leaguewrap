<?php
namespace LeagueWrap;

use LeagueWrap\Cache;
use LeagueWrap\CacheInterface;
use LeagueWrap\Api\AbstractApi;
use LeagueWrap\LimitInterface;
use LeagueWrap\Limit\Limit;
use LeagueWrap\Limit\Collection;

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
	 * This contains the cache container that we intend to use.
	 *
	 * @var CacheInterface
	 */
	protected $cache;

	/**
	 * How long, in seconds, should we remember a query's response.
	 *
	 * @var int
	 */
	protected $remember = null;

	/**
	 * The collection of limits to be used for all requests in this api.
	 *
	 * @var Collection
	 */
	protected $limits = null;

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

		// set up the limit collection
		$this->collection = new Collection;
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
		$api       = new $className($this->client, $this->collection);
		if ( ! $api instanceof AbstractApi)
		{
			// This is not an api class.
			throw new Exception('The api class "'.$className.'" was not found.');
		}

		$api->setKey($this->key)
		    ->setRegion($this->region);

		if ($this->cache instanceof CacheInterface)
		{
			$api->remember($this->remember, $this->cache);
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
	 * @param CacheInterface $cache
	 * @chainable
	 */
	public function remember($seconds = null, CacheInterface $cache = null)
	{
		if (is_null($cache))
		{
			// use the built in cache interface
			$cache = new Cache;
		}
		$this->cache    = $cache;
		$this->remember = $seconds;
		return $this;
	}

	/**
	 * Sets a limit to be added to the collection.
	 *
	 * @param int $hits
	 * @param int $seconds
	 * @param Limit $limit
	 * @chainable
	 */
	public function limit($hits, $seconds, LimitInterface $limit = null)
	{
		if (is_null($limit))
		{
			// use the built in limit interface
			$limit = new Limit;
		}

		$limit->setRate($hits, $seconds);

		$this->collection->addLimit($limit);
		return $this;
	}
}
