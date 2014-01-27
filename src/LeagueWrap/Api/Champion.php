<?php
namespace LeagueWrap\Api;

use LeagueWrap\ClientInterface;
use LeagueWrap\Response\Champion as Champ;

class Champion extends AbstractApi {
	
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

	/**
	 * Valid versions for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.1',
	];

	/**
	 * A list of all permitted regions for the Champion api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'na',
		'eune',
		'euw',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 86400;

	public function __construct(ClientInterface $client)
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
		return $this->get($key);
	}

	/**
	 * Attempt to get a champion by key.
	 *
	 * @param string $key
	 * @return object|null
	 */
	public function get($key)
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
			'freeToPlay' => $this->free,
		];

		$array = $this->request('champion', $params);

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
