<?php
namespace LeagueWrap;

interface CacheInterface {

	/**
	 * Sets the amount of time you would like the cache to live
	 * for.
	 *
	 * @param int $seconds
	 * @chainable
	 */
	public function setSeconds($seconds);

	/**
	 * Adds the response string into the cache under the given key for
	 * $seconds.
	 *
	 * @param string $key
	 * @param string $response
	 * @return bool
	 */
	public function remember($key, $response);

	/**
	 * Determines if the cache has the given key.
	 *
	 * @param string $key
	 * @return bool
	 */
	public function has($key);

	/**
	 * Gets the contents that are stored at the given key.
	 *
	 * @param string $key
	 * @return string
	 */
	public function get($key);
}
