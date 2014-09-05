<?php
namespace LeagueWrap;

interface ClientInterface {

	/**
	 * Set the base url for all future requests.
	 *
	 * @param string $url
	 * @return void
	 */
	public function baseUrl($url);

	/**
	 * Set a timeout in seconds for how long we will wait for the server
	 * to respond. If the server does not respond within the set number
	 * of seconds we throw an exception.
	 *
	 * @param int $seconds
	 * @return void
	 */
	public function setTimeout($seconds);

	/**
	 * Attempts to make a request of the given path with any
	 * additional parameters. It should return the response as
	 * a string.
	 *
	 * @param string $path
	 * @param array $params
	 * @return string
	 */
	public function request($path, array $params);
}
