<?php
namespace LeagueWrap;

use Memcached;

class Cache implements CacheInterface {

	protected $memcached;

	public function __construct()
	{
		$this->memcached = new Memcached;
		$this->memcached->addServer('localhost', 11211, 100);
	}

	/**
	 * Adds the response string into the cache under the given key.
	 *
	 * @param string $response
	 * @param string $key
	 * @param int $seconds
	 * @return bool
	 */
	public function set($response, $key, $seconds)
	{
		return $this->memcached->set($key, $response, time() + $seconds);
	}

	/**
	 * Determines if the cache has the given key.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has($key)
	{
		$this->memcached->get($key);
		if ($this->memcached->getResultCode() == Memcached::RES_NOTFOUND)
		{
			return false;
		}
		return true;
	}

	/**
	 * Gets the contents that are stored at the given key.
	 *
	 * @param string $key
	 * @return strig
	 */
	public function get($key)
	{
		return $this->memcached->get($key);
	}
}
