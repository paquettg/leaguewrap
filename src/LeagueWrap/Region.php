<?php
namespace LeagueWrap;

class Region {

	/**
	 * The region that this object represents.
	 *
	 * @param string
	 */
	protected $region;

	/**
	 * @param array @platformIds platform ids for regions
	 */
	protected $platformIds = [
		'na'   => 'NA1',
		'euw'  => 'EUW1',
		'br'   => 'BR1',
		'lan'  => 'LA1',
		'las'  => 'LA2',
		'oce'  => 'OC1',
		'eune' => 'EUN1',
		'tr'   => 'TR1',
		'ru'   => 'RU',
		'kr'   => 'KR',
		'jp'   => 'JP1'
	];

	/**
	 * @return String platform id for the selected version
	 */
	protected function getPlatformId() {
		if(array_key_exists($this->region, $this->platformIds))
			return $this->platformIds[$this->region];
		else
			return strtoupper($this->region);
	}

	/**
	 * The default domain to attempt to query
	 */
	protected $defaultDomain = 'https://%s.api.pvp.net/api/lol/%s/';

	/**
	 * The default domain for static queries
	 */
	protected $defaultStaticDomain = 'https://global.api.pvp.net/api/lol/static-data/';

	protected $featuredGameDomain = 'https://%s.api.pvp.net/observer-mode/rest/';

	protected $currentGameDomain = 'https://%s.api.pvp.net/observer-mode/rest/consumer/getSpectatorGameInfo/%s/';

	protected $championMasteryDomain = 'https://%s.api.pvp.net/championmastery/location/%s/';

	protected $statusDomain = 'http://status.leagueoflegends.com/';

	/**
	 * @param $region
	 */
	public function __construct($region)
	{
		$this->region = strtolower($region);
	}

	/**
	 * Returns the region that was passed in the constructor.
	 *
	 * @return string
	 */
	public function getRegion()
	{
		return $this->region;
	}


	/**
	 * Returns the domain that this region needs to make its request.
	 *
	 * @return string
	 */
	public function getDefaultDomain()
	{
		return sprintf($this->defaultDomain, $this->getRegion(), $this->getRegion());
	}

	/**
	 * Returns the static data domain that this region needs to make its request.
	 *
	 * @return string
	 */
	public function getStaticDataDomain()
	{
		return $this->defaultStaticDomain;
	}

	public function getCurrentGameDomain() {
		return sprintf($this->currentGameDomain, $this->getRegion(), $this->getPlatformId());
	}

	/**
	 * Returns the observer domain that this region needs to make its request.
	 *
	 * @return string
	 */
	public function getFeaturedGamesDomain()
	{
		return sprintf($this->featuredGameDomain, $this->getRegion());
	}

	public function getChampionMasteryDomain()
	{
		return sprintf($this->championMasteryDomain, $this->getRegion(), $this->getPlatformId());
	}

	public function getStatusDomain()
	{
		return $this->statusDomain;
	}

	/**
	 * Determines wether the given region is locked out.
	 *
	 * @param array $regions
	 * @return bool
	 */
	public function isLocked(array $regions)
	{
		if (count($regions) == 0)
		{
			// no regions are locked from this call.
			return true;
		}

		foreach ($regions as $region)
		{
			if ($this->region == strtolower($region))
			{
				// the region is fine
				return false;
			}
		}

		// the region was not found
		return true;
	}
}
