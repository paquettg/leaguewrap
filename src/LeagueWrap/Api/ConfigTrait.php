<?php
namespace LeagueWrap\Api;

use LeagueWrap\Region;

trait ConfigTrait {

	/**
	 * The region to be used. Defaults to 'na'.
	 *
	 * @var string
	 */
	protected $region = 'na';

	/**
	 * The amount of seconds we will wait for a responde from the riot
	 * server. 0 means wait indefinitely.
	 *
	 * @var int
	 */
	protected $timeout = 0;

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
	 * Set the region code to a valid string.
	 *
	 * @param string|Region $region
	 * @return $this
	 */
	public function setRegion($region)
	{
		if ( ! $region instanceof Region)
		{
			$region = new Region($region);
		}
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
	 * Set wether to attach static data to the response.
	 *
	 * @param bool $attach
	 * @param StaticData $static
	 * @return $this
	 */
	public function attachStaticData($attach = true, Staticdata $static = null)
	{
		$this->attachStaticData = $attach;
		$this->staticData       = $static;

		return $this;
	}
}
