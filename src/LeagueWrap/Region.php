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
	 * The default domain to attempt to query
	 */
	protected $defaultDomain = 'https://%s.api.pvp.net/api/lol/';
	
	/**
	 * The default domain for static queries
	 */
	protected $defaultStaticDomain = 'https://global.api.pvp.net/api/lol/static-data/';

	protected $defaultObserverDomain = 'https://%s.api.pvp.net/observer-mode/rest/';

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

		return sprintf($this->defaultDomain, $this->getRegion());
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

	/**
	 * @return stringReturns the observer domain that this region needs to make its request.
	 */
	public function getObserverDomain()
	{
		return sprintf($this->defaultObserverDomain, $this->getRegion());
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
