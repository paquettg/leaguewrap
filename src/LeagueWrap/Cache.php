<?php
namespace LeagueWrap;

class Cache implements CacheInterface {

	protected $seconds = 0;
	
	/**
	 * Sets the amount of time you would like the cache to live
	 * for.
	 *
	 * @param int $seconds
	 * @chainable
	 */
	public function setSeconds($seconds)
	{
		$this->seconds = $seconds;
		return $this;
	}

	/**
	 * Adds the response string into the cache under the given key.
	 *
	 * @param string $response
	 * @param string $key
	 * @return bool
	 */
	public function remember($response, $key)
	{
		return true;
	}

	/**
	 * Determines if the cache has the given key.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has($key)
	{
		return false;
	}

	/**
	 * Gets the contents that are stored at the given key.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key)
	{
		return 'yes?';
	}
}
