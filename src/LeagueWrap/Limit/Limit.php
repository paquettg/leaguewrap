<?php
namespace LeagueWrap\Limit;

use Memcached;
use LeagueWrap\LimitInterface;

class Limit implements LimitInterface {

	/**
	 * The key that will be used for the memcached storage.
	 *
	 * @var string
	 */
	protected $key;

	/**
	 * The max amount of hits the key can take in the given amount
	 * of seconds.
	 *
	 * @var int
	 */
	protected $hits;

	/**
	 * The amount of seconds to let the hits accumulate for.
	 *
	 * @var int
	 */
	protected $seconds;

	/**
	 * The region that is attached to this limit counter.
	 *
	 * @var string
	 */
	protected $region;

	/**
	 * The memcached instance.
	 *
	 * @var Memcached
	 */
	protected $memcached;

	/**
	 * Can we load memcached?
	 *
	 * @var bool
	 */
	protected $valid = false;

	public function __construct()
	{
		if (class_exists('Memcached'))
		{
			$this->memcached = new Memcached;
			$this->memcached->addServer('localhost', 11211, 100);
			$this->valid = true;
		}
	}

	/**
	 * Returns a new instance of the current limit object.
	 *
	 * @return Static $this
	 */
	public function newInstance()
	{
		$limit = new Static();
		return $limit;
	}

	/**
	 * Sets the rate limit for the given region.
	 *
	 * @param int $hits
	 * @param int $seconds
	 * @param string $region
	 * @chainable
	 */
	public function setRate($hits, $seconds, $region)
	{
		$this->key     = "leagueWrap.hits.$region.$hits.$seconds";
		$this->hits    = (int) $hits;
		$this->seconds = (int) $seconds;
		$this->region  = $region;
		return $this;
	}

	/**
	 * Returns the region that is tied to this limit counter.
	 *
	 * @return string 
	 */
	public function getRegion()
	{
		return $this->region;
	}

	/**
	 * Applies a hit to the given regions rate limiting.
	 *
	 * @param int $count Default 1
	 * @return bool
	 */
	public function hit($count = 1)
	{
		$hitsLeft = $this->memcached->get($this->key);
		if ($this->memcached->getResultCode() == Memcached::RES_NOTFOUND)
		{
			// this is the first hit
			$hitsLeft = $this->hits;
			$this->memcached->set($this->key, $this->hits, time() + $this->seconds);
		}

		if ($hitsLeft < $count)
		{
			return false;
		}

		if ($this->memcached->decrement($this->key, $count) === FALSE)
		{
			// it failed to decrement
			return false;
		}

		return true;
	}

	/**
	 * Check how many hits the given region has remaining.
	 *
	 * @return int
	 */
	public function remaining()
	{
		$hitsLeft = $this->memcached->get($this->key);
		if ($this->memcached->getResultCode() == Memcached::RES_NOTFOUND)
		{
			// this is the first hit
			$hitsLeft = $this->hits;
		}

		return $hitsLeft;
	}

	/**
	 * Is the current limit object valid on this machine (i.e. does
	 * the machine have memcache).
	 *
	 * @return bool
	 */
	public function isValid()
	{
		return $this->valid;
	}
}
