<?php
namespace LeagueWrap;

use GuzzleHttp\Client as Guzzle;
use LeagueWrap\Exception\BaseUrlException;

class Client implements ClientInterface {

	protected $guzzle;
	protected $timeout = 0;

	/**
	 * Sets the base url to be used for future requests.
	 *
	 * @param string $url
	 * @return void
	 */
	public function baseUrl($url)
	{
		$this->guzzle = new Guzzle([
			'base_url' => $url,
			'defaults' => ['headers' => ['Accept-Encoding' => 'gzip,deflate']]
		]);
	}

	/**
	 * Set a timeout in seconds for how long we will wait for the server
	 * to respond. If the server does not respond within the set number
	 * of seconds we throw an exception.
	 *
	 * @param int $seconds
	 * @return void
	 */
	public function setTimeout($seconds)
	{
		$this->timeout = floatval($seconds);
	}

	/**
	 * Attempts to do a request of the given path.
	 *
	 * @param string $path
	 * @param array $params
	 * @return string
	 * @throws BaseUrlException
	 */
	public function request($path, array $params = [])
	{
		if ( ! $this->guzzle instanceof Guzzle)
		{
			throw new BaseUrlException('BaseUrl was never set. Please call baseUrl($url).');
		}

		$uri      = $path.'?'.http_build_query($params);
		$response = $this->guzzle
		                 ->get($uri, ['connect_timeout' => $this->timeout]);
		
		$body = $response->getBody();
		$body->seek(0);
		return $body->read($body->getSize());
	}
}
