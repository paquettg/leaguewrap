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
	 * Attempt to add a subscriber plugin to guzzle, primary usage is
	 * to be able to test this code.
	 *
	 * @param object $mock
	 * @return void
	 */
	public function addMock($mock)
	{
		// Add the mock subscriber to the client.
		$this->guzzle->getEmitter()->attach($mock);
	}

	/**
	 * Attempts to do a request of the given path.
	 *
	 * @param string $path
	 * @param array $params
	 * @return LeagueWrap\Response
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
		                 ->get($uri, ['connect_timeout' => $this->timeout,
		                              'exceptions' => false]);
		
		$body = $response->getBody();
		$code = $response->getStatusCode();
		if (is_object($body))
		{
			$body->seek(0);
			$content = $body->read($body->getSize());
		}
		else
		{
			// no content
			$content = '';
		}
		$response = new Response($content, $code);

		return $response;
	}
}
