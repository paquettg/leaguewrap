<?php
namespace LeagueWrap\Limit;

use LeagueWrap\LimitInterface;

class Collection {

	protected $limits = [];

    /**
     * Add a limit to this collection.
     *
     * @param LimitInterface $limit
     * @return void
     */
    public function addLimit(LimitInterface $limit)
	{
		$this->limits[] = $limit;
	}

    /**
     * Hit the limit set for the given region.
     *
     * @param string $region
     * @param int $count
     * @return bool
     */
    public function hitLimits($region, $count = 1)
	{
		foreach ($this->limits as $limit)
		{
			if ($limit->getRegion() == $region &&
			     ! $limit->hit($count))
			{
				return false;
			}
		}

		return true;
	}

	/**
	 * Returns the lowest
	 */
	public function remainingHits()
	{
		$remaining = null;
		foreach ($this->limits as $limit)
		{
			$hitsLeft = $limit->remaining();
			if (is_null($remaining) ||
			    $hitsLeft < $remaining)
			{
				$remaining = $hitsLeft;
			}
		}

		return $remaining;
	}

	/**
	* @return array of all limits in this collection
	**/
	public function getLimits()
	{
		return $this->limits;
	}
}
