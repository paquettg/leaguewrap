<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\StaticData\Champion as staticChampion;
use LeagueWrap\Dto\StaticData\ChampionList;
use LeagueWrap\Dto\StaticData\Item as staticItem;
use LeagueWrap\Dto\StaticData\ItemList;
use LeagueWrap\Dto\StaticData\Mastery as staticMastery;
use LeagueWrap\Dto\StaticData\MasteryList;
use LeagueWrap\Dto\StaticData\Realm as staticRealm;

class Staticdata extends AbstractApi {
	
	/**
	 * The locale you want the response in. By default it is not 
	 * passed (null).
	 *
	 * @var string
	 */
	protected $locale = null;

	/**
	 * The version of League of Legends that we want data from. By default
	 * it is not passed (null).
	 *
	 * @var string
	 */
	protected $DDversion = null;

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [
		'v1.2',
	];

	/**
	 * A list of all permitted regions for the Staticdata api call.
	 *
	 * @var array
	 */
	protected $permittedRegions = [
		'br',
		'eune',
		'euw',
		'kr',
		'lan',
		'las',
		'na',
		'oce',
		'ru',
		'tr',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 86400;

	/**
	 * Sets the locale the data should be returned in. Null returns
	 * the default local for that region.
	 *
	 * @param string $locale
	 * @chainable
	 */
	public function setLocale($locale)
	{
		$this->locale = $locale;

		return $this;
	}

	/**
	 * Gets all static champion data with the given $data option.
	 *
	 * @param string #data
	 * @retrn ChampionList
	 */
	public function getChampions($data = null)
	{
		return $this->getChampion(null, $data);
	}

	/**
	 * Gets the static champion data of all champions if $id is null.
	 * If $id is set it will attempt to get info for that champion only.
	 *
	 * @param int $id
	 * @param string $data
	 * @return ChampionList|Champion
	 */
	public function getChampion($id, $data = null)
	{
		$params = $this->setUpParams();
		if ( ! is_null($data))
		{
			$params['champData'] = $data;
		}

		$path = 'champion';
		if ($this->appendId($id))
		{
			$path .= "/$id";
		}
		else
		{
			// add the dataById argument
			$params['dataById'] = 'true';
		}

		$array = $this->request($path, $params, true);

		if ( ! is_null($id) and
		     $id != 'all')
		{
			return new staticChampion($array);
		}
		else
		{
			return new ChampionList($array);
		}
	}

	/**
	 * Gets static data on all items.
	 *
	 * @param string $data
	 * @return ItemList
	 */
	public function getItems($data = null)
	{
		return $this->getItem(null, $data);
	}

	/**
	 * Gets the static item data of all items if $id is null.
	 * If $id is set it will attempt to get info for that item only.
	 *
	 * @param int $id
	 * @param string $data
	 * @return ItemList|Item
	 */
	public function getItem($id, $data = null)
	{
		$params = $this->setUpParams();
		if ( ! is_null($data))
		{
			$params['itemListData'] = $data;
		}
		
		$array = $this->makeRequest('item', $id, $params);
		
		if ($this->appendId($id))
		{
			return new staticItem($array);
		}
		else
		{
			return new ItemList($array);
		}
	}

	/**
	 * Gets static data on all masteries.
	 *
	 * @param string $data
	 * @return MasteryList
	 */
	public function getMasteries($data = null)
	{
		return $this->getMastery(null, $data);
	}

	/**
	 * Gets the mastery data of all masteries if $id is null.
	 * If $id is a set it will attempt to get info for that mastery only.
	 *
	 * @param int $id
	 * @param string $data
	 * @return MasteryList|Mastery
	 */
	public function getMastery($id, $data = null)
	{
		$params = $this->setUpParams();
		if ( ! is_null($data))
		{
			$params['masteryListData'] = $data;
		}

		$array = $this->makeRequest('mastery', $id, $params);
		
		if ($this->appendId($id))
		{
			return new staticMastery($array);
		}
		else
		{
			return new MasteryList($array);
		}
	}

	/**
	 * Get realm information for the current region.
	 *
	 * @return Realm
	 */
	public function getRealm()
	{
		$params = $this->setUpParams();
		$array  = $this->makeRequest('realm', null, $params);
			
		return new staticRealm($array);
	}

	/**
	 * Make the request given the proper information.
	 *
	 * @param string $path
	 * @param mixed $id
	 * @param array $params
	 * @return array
	 */
	protected function makeRequest($path, $id, array $params)
	{
		if ($this->appendId($id))
		{
			$path .= "/$id";
		}

		return $this->request($path, $params, true);
	}

	/**
	 * Set up the boiler plat for the param array for any 
	 * static data call.
	 *
	 * @return array
	 */
	protected function setUpParams()
	{
		$params = [];
		if ( ! is_null($this->locale))
		{
			$params['locale'] = $this->locale;
		}
		if ( ! is_null($this->DDversion))
		{
			$params['version'] = $this->DDversion;
		}
		return $params;
	}

	/**
	 * Check if we should append the id to the end of the 
	 * url or not.
	 *
	 * @param mixed $id
	 * @return bool
	 */
	protected function appendId($id)
	{
		if ( ! is_null($id) AND
		     $id != 'all')
		{
			return true;
		}

		return false;
	}
}
