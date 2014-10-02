<?php
namespace LeagueWrap\Limit;

use LeagueWrap\LimitInterface;

class Collection {

	protected $limits = [];

	public function addLimit(LimitInterface $limit)
	{
		$this->limits[] = $limit;
	}

	public function hitLimits($region, $count = 1)
	{
		foreach ($this->limits as $limit)
		{
			if ($limit->getRegion() == $region and
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
			if (is_null($remaining) or
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
