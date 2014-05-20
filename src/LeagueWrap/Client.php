<?php
namespace LeagueWrap;

use GuzzleHttp\Client as Guzzle;

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
	 * @throws Exception
	 */
	public function request($path, array $params = [])
	{
		if ( ! $this->guzzle instanceof Guzzle)
		{
			throw new Exception('BaseUrl was never set. Please call baseUrl($url).');
		}

		$uri      = $path.'?'.http_build_query($params);
		$response = $this->guzzle
		                 ->get($uri);
		
		$body = $response->getBody();
		$body->seek(0);
		return $body->read($body->getSize());
	}
}
