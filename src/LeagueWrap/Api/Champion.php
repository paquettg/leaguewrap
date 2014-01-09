<?php
namespace LeagueWrap\Api;

use LeagueWrap\Response\Champion as Champ;

class Champion extends Api {
	
	/**
	 * Do we want to only get the free champions?
	 *
	 * @param string
	 */
	protected $free = 'false';

	/**
	 * We keep all the champion results here.
	 *
	 * @param array
	 */
	protected $champions = [];

	public function __construct($client)
	{
		$this->client = $client;
	}

	/**
	 * Attempt to get a champion by key.
	 *
	 * @param string $key
	 * @return object|null
	 */
	public function __get($key)
	{
		$key = strtolower($key);
		if (isset($this->champions[$key]))
		{
			return $this->champions[$key];
		}
		return null;
	}

	/**
	 * Gets all the champions in the given region.
	 *
	 * @return array
	 */
	public function all()
	{
		$params   = [
			'api_key'    => $this->key,
			'freeToPlay' => $this->free,
		];

		$response = $this->client
		                 ->get('/api/lol/'.$this->region.'/v1.1/champion?'.http_build_query($params))
		                 ->send();
		
		$body = $response->getBody();
		$body->seek(0);
		$content = $body->read($body->getSize());

		// decode the content
		$array = json_decode($content, true);

		// set up the champions
		foreach ($array['champions'] as $info)
		{
			$name                   = strtolower($info['name']);
			$champion               = new Champ($info);
			$this->champions[$name] = $champion;
		}

		return $this->champions;
	}

	/**
	 * Gets all the free champions for this week.
	 *
	 * @uses $this->all()
	 * @return array
	 */
	public function free()
	{
		$this->free = 'true';
		return $this->all();
	}
}
