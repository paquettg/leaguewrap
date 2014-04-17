<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\StaticData\Champion as staticChampion;
use LeagueWrap\Dto\StaticData\ChampionList;

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
	 * Gets the static champion data of all champions if $id is null.
	 * If $id is set it will attempt to get info for that champion only.
	 *
	 * @param int $id
	 * @return ChampionList
	 */
	public function getChampion($id = null, $data = null)
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
		if ( ! is_null($data))
		{
			$params['champData'] = $data;
		}

		$path = 'champion';
		if ( ! is_null($id) and
		     $id != 'all')
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
}
