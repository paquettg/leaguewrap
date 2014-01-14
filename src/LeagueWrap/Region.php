<?php
namespace LeagueWrap;

class Region {

	/**
	 * This contains all permitted regions. Leave empty to pass any region.
	 *
	 * @var array
	 */
	protected $regions = [];

	public function __construct(array $regions)
	{
		foreach ($regions as $region)
		{
			$this->regions[] = strtolower($region);
		}
	}

	/**
	 * Determines wether the given region is locked out.
	 *
	 * @param string $region
	 * @return bool
	 */
	public function isLocked($region)
	{
		if (count($this->regions) == 0)
		{
			// no regions are locked from this call.
			return true;
		}

		// controlle the case
		$region = strtolower($region);

		return ! in_array($region, $this->regions);
	}
}
