<?php
namespace LeagueWrap\Api;

use LeagueWrap\Response;
use LeagueWrap\Response\RunePage;
use LeagueWrap\Response\Rune;
use LeagueWrap\Response\MasteryPage;
use LeagueWrap\Response\Talent;

class Summoner extends Api {

	/**
	 * The summoners we have loaded.
	 *
	 * @var array
	 */
	protected $summoners = [];

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.2',
		'v1.1',
	];

	public function __construct($client)
	{
		$this->client = $client;
	}

	/**
	 * Attempt to get a summoner by key.
	 *
	 * @param string $key
	 * @return object|null
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Attempt to get a summoner by key.
	 *
	 * @param string $key
	 * @return object|null
	 */
	public function get($key)
	{
		$key = strtolower($key);
		if (isset($this->summoners[$key]))
		{
			return $this->summoners[$key];
		}
		return null;
	}

	/**
	 * Gets the information about the user by the given identification.
     *
     * @param mixed $identity
     * @return Response\Summoner
	 */
	public function info($identity)
	{
		if (is_int($identity))
		{
			// it's the id
			$summoner = $this->infoById($identity);
		}
		else
		{
			// the summoner name
			$summoner = $this->infoByName($identity);
		}

		return $summoner;
	}

	/**
	 * Attempts to get all information about this user. This method
	 * will make 3 requests!
	 *
	 * @param mixed $identity
	 * @return Response\Summoner;
	 */
	public function allInfo($identity)
	{
		$summoner = $this->info($identity);
		$this->runePages($summoner);
		$this->masteryPages($summoner);
		
		return $summoner;
	}

	/**
	 * Gets all rune pages of the given user object or id.
	 *
	 * @param mixed $identity
	 * @return array
	 * @throws Exception
	 */
	public function runePages($identity)
	{
		if ($identity instanceof Response\Summoner)
		{
			$id = $identity->id;
		}
		elseif (is_int($identity))
		{
			$id = $identity;
		}
		else
		{
			throw new Exception('The identity given was not valid for a runes request.');
		}

		$array     = $this->request('summoner/'.$id.'/runes');
		$runePages = [];
		foreach ($array['pages'] as $info)
		{
			$slots = $info['slots'];
			unset($info['slots']);
			$runePage = new RunePage($info);
			// set runes
			$runes = [];
			foreach ($slots as $slot)
			{
				$id         = $slot['runeSlotId'];
				$rune       = new Rune($slot['rune']);
				$runes[$id] = $rune;
			}
			$runePage->runes = $runes;
			$runePages[]     = $runePage;
		}

		if ($identity instanceof Response\Summoner)
		{
			$identity->runePages = $runePages;
		}

		return $runePages;
	}

	/**
	 * Gets all the mastery pages of the given user object or id.
	 *
	 * @param mixed $identity
	 * @return array
	 * @throws Exception
	 */
	public function masteryPages($identity)
	{
		if ($identity instanceof Response\Summoner)
		{
			$id = $identity->id;
		}
		elseif (is_int($identity))
		{
			$id = $identity;
		}
		else
		{
			throw new Exception('The identity given was not valid for a mastery request.');
		}

		$array        = $this->request('summoner/'.$id.'/masteries');
		$masteryPages = [];
		foreach ($array['pages'] as $info)
		{
			$talentsInfo = $info['talents'];
			unset($info['talents']);
			$masteryPage = new MasteryPage($info);
			// set masterys
			$talents = [];
			foreach ($talentsInfo as $talent)
			{
				$id           = $talent['id'];
				$talent       = new Talent($talent);
				$talents[$id] = $talent;
			}
			$masteryPage->talents = $talents;
			$masteryPages[]       = $masteryPage;
		}

		if ($identity instanceof Response\Summoner)
		{
			$identity->masteryPages = $masteryPages;
		}

		return $masteryPages;
	}

	/**
	 * Gets the information by the id of the summoner.
	 *
	 * @param int $id
	 * @return Response\Summoner;
	 */
	protected function infoById($id)
	{
		$array    = $this->request('summoner/'.$id);
		$summoner = new Response\Summoner($array);
		$name     = strtolower($summoner->name);

		$this->summoners[$name] = $summoner;
		return $summoner;
	}

	/**
	 * Gets the information by the name of the summoner.
	 *
	 * @param string $name
	 * @return Response\Summoner;
	 */
	protected function infoByName($name)
	{
		$array    = $this->request('summoner/by-name/'.$name);
		$summoner = new Response\Summoner($array);
		$name     = strtolower($summoner->name);

		$this->summoners[$name] = $summoner;
		return $summoner;
	}
}
