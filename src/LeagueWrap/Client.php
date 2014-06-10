<?php
namespace LeagueWrap;

use GuzzleHttp\Client as Guzzle;
use LeagueWrap\Exception\BaseUrlException;

class Client implements ClientInterface {

	protected $guzzle;

	/**
	 * Sets the base url to be used for future requests.
	 *
	 * @param string $url
	 * @return void
	 */
	public function baseUrl($url)
	{
		$this->guzzle = new Guzzle(['base_url' => $url]);
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
		                 ->get($uri);
		
		$body = $response->getBody();
		$body->seek(0);
		return $body->read($body->getSize());
	}
}
