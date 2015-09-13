<?php
namespace LeagueWrap;

use LeagueWrap\Api\AbstractApi;
use LeagueWrap\Api\Staticdata;
use LeagueWrap\Limit\Limit;
use LeagueWrap\Limit\Collection;
use LeagueWrap\Limit\FileLimit;
use LeagueWrap\Exception\NoKeyException;
use LeagueWrap\Exception\ApiClassNotFoundException;
use LeagueWrap\Exception\NoValidLimitInterfaceException;

/**
 * @method Api\Champion champion()
 * @method Api\Game game()
 * @method Api\League league()
 * @method Api\Staticdata staticData()
 * @method Api\Stats stats()
 * @method Api\Summoner summoner()
 * @method Api\Team team()
 * @method Api\CurrentGame currentGame()
 */
class Api {

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
	 * The amount of seconds we will wait for a responde fromm the riot
	 * server. 0 means wait indefinitely.
	 */
	protected $timeout = 0;

	/**
	 * This contains the cache container that we intend to use.
	 *
	 * @var CacheInterface
	 */
	protected $cache;

	/**
	 * Only check the cache. Do not do any actual request.
	 *
	 * @var bool
	 */
	protected $cacheOnly = false;

	/**
	 * Cache client errors (4xx) from the http calls.
	 *
	 * @var bool
	 */
	protected $cacheClientError = true;

	/**
	 * Cache the server errors (5xx) from the http calls.
	 *
	 * @var bool
	 */
	protected $cacheServerError = false;

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
	 * Whould we attach static data to all requests done on the api?
	 *
	 * @var bool
	 */
	protected $attachStaticData = false;

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
     * @param ClientInterface $client
	 * @throws NoKeyException
	 */
	public function __construct($key = null, ClientInterface $client = null)
	{
		if (is_null($key))
		{
			throw new NoKeyException('We need a key... it\'s very important!');
		}

		if (is_null($client))
		{
			// set up the default client
			$client = new Client;
		}
		$this->client = $client;

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
	 * @throws ApiClassNotFoundException
	 */
	public function __call($method, $arguments)
	{
		// we don't use the arguments at the moment.
		unset($arguments);

		$className = 'LeagueWrap\\Api\\'.ucwords(strtolower($method));
		if ( ! class_exists($className))
		{
			// This class does not exist
			throw new ApiClassNotFoundException('The api class "'.$className.'" was not found.');
		}
		$api = new $className($this->client, $this->collection, $this);
		if ( ! $api instanceof AbstractApi)
		{
			// This is not an api class.
			throw new ApiClassNotFoundException('The api class "'.$className.'" was not found.');
		}

		$api->setKey($this->key)
		    ->setRegion($this->region)
		    ->setTimeout($this->timeout)
		    ->setCacheOnly($this->cacheOnly)
		    ->setClientErrorCaching($this->cacheClientError)
		    ->setServerErrorCaching($this->cacheServerError);
		if ($this->attachStaticData &&
		    ! ($api instanceof Staticdata))
		{
		    $api->attachStaticData($this->attachStaticData, $this->staticData());
		}

		if ($this->cache instanceof CacheInterface)
		{
			$api->remember($this->remember, $this->cache);
		}

		return $api;
	}

	/**
	 * Set the region code to a valid string.
	 *
	 * @param string $region
	 * @return $this
	 */
	public function setRegion($region)
	{
		$this->region = $region;
		return $this;
	}

	/**
	 * Set a timeout in seconds for how long we will wait for the server
	 * to respond. If the server does not respond within the set number
	 * of seconds we throw an exception.
	 *
	 * @param float $seconds
	 * @return $this
	 */
	public function setTimeout($seconds)
	{
		$this->timeout = floatval($seconds);
		return $this;
	}

	/**
	 * Sets the api endpoint to only use the cache to get the needed
	 * information for the requests.
	 *
	 * @param $cacheOnly bool
	 * @return $this
	 */
	public function setCacheOnly($cacheOnly = true)
	{
		$this->cacheOnly = $cacheOnly;
		return $this;
	}

	/**
	 * Sets the flag to decide if we want to cache client errors.
	 * (4xx http errors).
	 *
	 * @param $cache bool
	 * @return $this
	 */
	public function setClientErrorCaching($cache = true)
	{
		$this->cacheClientError = $cache;
		return $this;
	}

	/**
	 * Sets the flag to decide if we want to cache client errors.
	 * (5xx http errors).
	 *
	 * @param $cache bool
	 * @return $this
	 */
	public function setServerErrorCaching($cache = true)
	{
		$this->cacheServerError = $cache;
		return $this;
	}

	/**
	 * Sets the amount of seconds we should remember the response for.
	 * Leave it empty (or null) if you want to use the default set for 
	 * each api request.
	 *
	 * @param int $seconds
	 * @param CacheInterface $cache
	 * @return $this
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
	 * @param string $region
     * @param LimitInterface $limit
     * @return $this
     * @throws NoValidLimitInterfaceException
     */
	public function limit($hits, $seconds, $region = 'all', LimitInterface $limit = null)
	{
		if (is_null($limit))
		{
			// use the built in limit interface
			$limit = new Limit;
		}
		if ( ! $limit->isValid())
		{
			// fall back to the file base limit handling
			$limit = new FileLimit;
			if ( ! $limit->isValid())
			{
				throw new NoValidLimitInterfaceException("We could not load a valid limit interface.");
			}
		}

		if ($region == 'all')
		{
			foreach ([
				'br',
				'eune',
				'euw',
				'kr',
				'lan',
				'las',
				'na',
				'oce',
				'ru',
				'tr'] as $region)
			{
				$newLimit = $limit->newInstance();
				$newLimit->setRate($hits, $seconds, $region);
				$this->collection->addLimit($newLimit);
			}
		}
		else
		{
			// lower case the region
			$region = strtolower($region);
			$limit->setRate($hits, $seconds, $region);
			$this->collection->addLimit($limit);
		}

		return $this;
	}

	/**
	* @return array of Limit
	*/
	public function getLimits()
	{
		return $this->collection->getLimits();
	}

	/**
	 * Set wether or not to attach static data to all requests done on this
	 * api.
	 *
	 * @param bool $attach
	 * @return $this
	 */
	public function attachStaticData($attach = true)
	{
		$this->attachStaticData = $attach;
		return $this;
	}
}
