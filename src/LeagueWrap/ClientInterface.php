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
