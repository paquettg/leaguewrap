<?php
namespace LeagueWrap;

use Guzzle\Http\Client;

class Api {

	/**
	 * Default api url.
	 *
	 * @var string
	 */
	protected $url = 'http://prod.api.pvp.net/api/lol/';

	/**
	 * The region to be used. Defaults to 'na'.
	 *
	 * @var string
	 */
	protected $region = 'na';

	/**
	 * The client used to connect with the riot API.
	 *
	 * @var object
	 */
	protected $client;

	/**
	 * This is the api key, very important.
	 *
	 * @var string
	 */
	private $key;

	/**
	 * Initiat the default client and key.
	 *
	 * @param string $key
	 */
	public function __construct($key = null)
	{
		if (is_null($key))
		{
			throw new Exception('We need a key... it\'s very important!');
		}

		// set up the default client
		$this->client = new Client($this->url);

		// add the key
		$this->key = $key;
	}

	/**
	 * Change the url for the client.
	 *
	 * @param string $url
	 * @chainable
	 */
	public function resetUrl($url)
	{
		$this->client = new Client($url);
		return $this;
	}

	/**
	 * Set the region code to a valid string.
	 *
	 * @param string $region
	 * @chainable
	 */
	public function setRegion($region)
	{
		$this->region = $region;
		return $this;
	}

	/**
	 * Start a champion request.
	 *
	 * @return Api\Champion
	 */
	public function champion()
	{
		$champion = new Api\Champion($this->client);
		$champion->setKey($this->key)
		         ->setRegion($this->region);

		return $champion;
	}
}
