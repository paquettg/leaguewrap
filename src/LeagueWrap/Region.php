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
	 * An array of region dependant domains.
	 *
	 * @param array
	 */
	protected $domains = [
		'ru' => 'https://eu.api.pvp.net/api/lol/', 
		'tr' => 'https://eu.api.pvp.net/api/lol/',
		'kr' => 'https://kr.api.pvp.net/api/lol/',
	];

	/**
	 * The default domain to attempt to query if the region is not
	 * in the $domains array.
	 *
	 * @param string
	 */
	protected $defaultDomain = 'https://prod.api.pvp.net/api/lol/';

	/**
	 * An array of region dependant static data domains.
	 *
	 * @param array
	 */
	protected $staticDataDomains = [];

	/**
	 * The default domain to attempt to query if the region is not
	 * in the $staticDataDomains array.
	 *
	 * @param string
	 */
	protected $defaultStaticDataDomain = 'https://prod.api.pvp.net/api/lol/static-data/';

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
	 * @param bool $static
	 * @return string
	 */
	public function getDomain($static = false)
	{
		if ($static)
		{
			return $this->getStaticDataDomain();
		}

		if (isset($this->domains[$this->region]))
		{
			return $this->domains[$this->region];
		}

		return $this->defaultDomain;
	}

	/**
	 * Returns the static data domain that this region needs to make its request.
	 *
	 * @return string
	 */
	public function getStaticDataDomain()
	{
		if (isset($this->staticDataDomains[$this->region]))
		{
			return $this->staticDataDomains[$this->region];
		}

		return $this->defaultStaticDataDomain;
	}

	/**
	 * Determines wether the given region is locked out.
	 *
	 * @param array $region
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
