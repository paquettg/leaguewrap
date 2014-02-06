<?php
namespace LeagueWrap\Limit;

use Memcached;
use LeagueWrap\LimitInterface;

class Limit implements LimitInterface {

	protected $key;

	protected $hits;

	protected $seconds;

	protected $memcached;

	public function __construct()
	{
		$this->memcached = new Memcached;
		$this->memcached->addServer('localhost', 11211, 100);
	}

	public function setRate($hits, $seconds)
	{
		$this->key     = 'leagueWrap.hits.'.$hits.'x'.$seconds;
		$this->hits    = (int) $hits;
		$this->seconds = (int) $seconds;
		return true;
	}

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
}
