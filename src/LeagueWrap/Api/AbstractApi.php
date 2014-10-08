<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\Summoner;
use LeagueWrap\Dto\AbstractDto;
use LeagueWrap\Api;
use LeagueWrap\Region;
use LeagueWrap\Cache;
use LeagueWrap\CacheInterface;
use LeagueWrap\ClientInterface;
use LeagueWrap\Limit\Collection;
use LeagueWrap\Exception\RegionException;
use LeagueWrap\Exception\LimitReachedException;
use LeagueWrap\Exception\InvalidIdentityException;
use LeagueWrap\Exception\CacheNotFoundException;

abstract class AbstractApi {
	
	/**
	 * The client used to communicate with the api.
	 *
	 * @var ClientInterface
	 */
	protected $client;

	/**
	 * The collection of limits to be used on this api.
	 *
	 * @var Collection
	 */
	protected $collection;

	/**
	 * The key to be used by the api.
	 *
	 * @param string
	 */
	protected $key;

	/**
	 * The region to be used by the api.
	 *
	 * @param string
	 */
	protected $region;

	/**
	 * Provides access to the api object to perform requests on
	 * different api endpoints.
	 */
	protected $api;

	/**
	 * A list of all permitted regions for this API call. Leave
	 * it empty to not lock out any region string.
	 *
	 * @param array
	 */
	protected $permittedRegions = [];

	/**
	 * The version we want to use. If null use the first
	 * version in the array.
	 *
	 * @param string|null
	 */
	protected $version = null;

	/**
	 * A count of the amount of API request this object has done
	 * so far.
	 *
	 * @param int
	 */
	protected $requests = 0;

	/**
	 * The amount of seconds we will wait for a responde fromm the riot
	 * server. 0 means wait indefinitely.
	 */
	protected $timeout = 0;

	/**
	 * This is the cache container that we intend to use.
	 *
	 * @var CacheInterface
	 */
	protected $cache = null;

	/**
	 * Only check the cache. Do not do any actual request.
	 *
	 * @var bool
	 */
	protected $cacheOnly = false;

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 0;

	/**
	 * The amount of seconds to keep things in cache
	 *
	 * @var int
	 */
	protected $seconds = 0;

	/**
	 * Should we attach static data to the requests done by this object?
	 *
	 * @var bool
	 */
	protected $attachStaticData = false;

	/**
	 * A static data api object to be used for static data request.
	 *
	 * @var staticData
	 */
	protected $staticData = null;

	/**
	 * Default DI constructor.
	 *
	 * @param ClientInterface $client
	 * @param Collection $collection
	 * @param Api $api
	 */
	public function __construct(ClientInterface $client, Collection $collection, Api $api)
	{
		$this->client     = $client;
		$this->collection = $collection;
		$this->api        = $api;
	}

	/**
	 * Returns the amount of requests this object has done
	 * to the api so far.
	 *
	 * @return int
	 */
	public function getRequestCount()
	{
		return $this->requests;
	}

	/**
	 * Set the key to be used in the api.
	 *
	 * @param string $key
	 * @chainable
	 */
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
	}

	/**
	 * Set the region to be used in the api.
	 *
	 * @param string $region
	 * @chainable
	 */
	public function setRegion($region)
	{
		$this->region = new Region($region);
		return $this;
	}

	/**
	 * Set a timeout in seconds for how long we will wait for the server
	 * to respond. If the server does not respond within the set number
	 * of seconds we throw an exception.
	 *
	 * @param float $seconds
	 * @chainable
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
	 * @chainable
	 */
	public function setCacheOnly($cacheOnly = true)
	{
		$this->cacheOnly = $cacheOnly;
		return $this;
	}

	/**
	 * Set wether to attach static data to the response.
	 *
	 * @param bool $attach
	 * @param StaticData $static
	 * @chainable
	 */
	public function attachStaticData($attach = true, Staticdata $static = null)
	{
		$this->attachStaticData = $attach;
		$this->staticData       = $static;
		return $this;
	}


	/**
	 * Select the version of the api you wish to
	 * query.
	 *
	 * @param string $version
	 * @return bool|$this
	 * @chainable
	 */
	public function selectVersion($version)
	{
		if ( ! in_array($version, $this->versions))
		{
			// not a value version
			return false;
		}

		$this->version = $version;
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
		$this->cache = $cache;
		if (is_null($seconds))
		{
			$this->seconds = $this->defaultRemember;
		}
		else
		{
			$this->seconds = $seconds;
		}

		return $this;
	}

	/**
	 * Wraps the request of the api in this method.
	 *
	 * @param string $path
	 * @param array $params
	 * @param bool $static
	 * @return array
	 * @throws RegionException
	 */
	protected function request($path, $params = [], $static = false)
	{
		// get version
		$version = $this->getVersion();

		// get and validate the region
		if ($this->region->isLocked($this->permittedRegions))
		{
			throw new RegionException('The region "'.$this->region->getRegion().'" is not permited to query this API.');
		}

		// set the region based domain
		$this->client->baseUrl($this->region->getDomain($static));
		if ($this->timeout > 0)
		{
			$this->client->setTimeout($this->timeout);
		}

		// add the key to the param list
		$params['api_key'] = $this->key;

		$uri = $this->region->getRegion().'/'.$version.'/'.$path;

		// check cache
		if ($this->cache instanceof CacheInterface)
		{
			$cacheKey = md5($uri.'?'.http_build_query($params));
			if ($this->cache->has($cacheKey))
			{
				$content = $this->cache->get($cacheKey);
			}
			elseif ($this->cacheOnly)
			{
				throw new CacheNotFoundException("A cache item for '$uri?".http_build_query($params)."' was not found!");
			}
			else
			{
				$content = $this->clientRequest($static, $uri, $params);

				// we want to cache this response
				$this->cache->set($content, $cacheKey, $this->seconds);
			}
		}
		elseif ($this->cacheOnly)
		{
			throw new CacheNotFoundException('The cache is not enabled but we were told to use only the cache!');
		}
		else
		{
			$content = $this->clientRequest($static, $uri, $params);
		}

		// decode the content
		return json_decode($content, true);
	}

	/**
	 * Make the actual request.
	 * 
	 * @param bool $static
	 * @param string $uri
	 * @param array $params
	 * @return string
	 * @throws LimitReachedException
	 */
	protected function clientRequest($static, $uri, $params)
	{
		// check if we have hit the limit
		if ( ! $static AND
			 ! $this->collection->hitLimits($this->region->getRegion()))
		{
			throw new LimitReachedException('You have hit the request limit in your collection.');
		}
		$content = $this->client->request($uri, $params);

		// request was succesful
		++$this->requests;

		return $content;
	}

	/**
	 * Get the version string.
	 *
	 * @return string
	 */
	protected function getVersion()
	{
		if (is_null($this->version))
		{
			// get the first version in versions
			$this->version = reset($this->versions);
		}
		
		return $this->version;
	}

	/**
	 * Attempts to extract an ID from the object/value given
	 *
	 * @param mixed $identity
	 * @return int
	 * @throws InvalidIdentityException
	 */
	protected function extractId($identity)
	{
		if ($identity instanceof Summoner)
		{
			return $identity->id;
		}
		elseif (filter_var($identity, FILTER_VALIDATE_INT) !== FALSE)
		{
			return $identity;
		}
		else
		{
			throw new InvalidIdentityException("The identity '$identity' is not valid.");
		}
	}

	/**
	 * Attempts to extract an ID from the array given.
	 *
	 * @param mixed $identities
	 * @return array
	 * @uses extractId()
	 */
	protected function extractIds($identities)
	{
		$ids = [];
		if (is_array($identities))
		{
			foreach ($identities as $identity)
			{
				$ids[] = $this->extractId($identity);
			}
		}
		else
		{
			$ids[] = $this->extractId($identities);
		}

		return $ids;
	}

	/**
	 * Attempts to attach the response to a summoner object.
	 *
	 * @param mixed $identity
	 * @param mixed $response
	 * @param string $key
	 * @return bool
	 */
	protected function attachResponse($identity, $response, $key)
	{
		if ($identity instanceof Summoner)
		{
			$identity->set($key, $response);
			return true;
		}
		
		return false;
	}

	/**
	 * Attempts to attach all the responses to the correct summoner.
	 *
	 * @param mixed $identity
	 * @param mixed $responses
	 * @param string $key
	 * @return bool
	 */
	protected function attachResponses($identities, $responses, $key)
	{
		if (is_array($identities))
		{
			foreach ($identities as $identity)
			{
				if ($identity instanceof Summoner)
				{
					$id = $identity->id;
					if (isset($responses[$id]))
					{
						$response = $responses[$id];
						$this->attachResponse($identity, $response, $key);
					}
					else
					{
						// we did not get a response for this id, attach null
						$this->attachResponse($identity, null, $key);
					}
				}
			}
		}
		else
		{
			$identity = $identities;
			if ($identity instanceof Summoner)
			{
				$id = $identity->id;
				if (isset($responses[$id]))
				{
					$response = $responses[$id];
					$this->attachResponse($identity, $response, $key);
				}
				else
				{
					// we did not get a response for this id, attach null
					$this->attachResponse($identity, null, $key);
				}
			}
		}

		return true;
	}

	/**
	 * Will attempt to attach any static data to the given dto if
	 * the attach static data flag is set.
	 *
	 * $param AbstractDto $dto
	 * @return AbstractDto
	 */
	protected function attachStaticDataToDto(AbstractDto $dto)
	{
		if ($this->attachStaticData)
		{
			$dto->loadStaticData($this->staticData);
		}
		return $dto;
	}
}

