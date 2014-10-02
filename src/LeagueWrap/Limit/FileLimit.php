<?php
namespace LeagueWrap\Limit;

use LeagueWrap\LimitInterface;

/**
 * This is a fallback limit interface incase the memcached interface
 * is not valid. This might happen is memcached is not installed
 * and enabled in php. This limit system is slow and requires a lot of
 * I/O so try not to use it.
 */
class FileLimit implements LimitInterface {

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
	 * Can we load memcached?
	 *
	 * @var bool
	 */
	protected $valid = false;

	/**
	 * The directory to store all the limit files in.
	 *
	 * @var string
	 */
	protected $dir = '/tmp';

	/**
	 * The full path to the limit file.
	 *
	 * @var string
	 */
	protected $path;

	public function __construct()
	{
		if (is_writable($this->dir))
		{
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
		$this->path    = $this->dir."/leagueWrap.hits.$region.$hits.$seconds";
		$this->hits    = (int) $hits;
		$this->seconds = (int) $seconds;
		$this->region  = $region;
		return $this;
	}

	/**
	 * Returns the region that is tied to this limit counter.
	 
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
		if (file_exists($this->path))
		{
			$expires = $this->getPathContent('expires');
			if ( ! is_null($expires))
			{
				$hits  = $this->getPathContent('hits');
				$hits += $count;
				if ($hits > $this->hits)
				{
					// we reached the limit
					return false;
				}
				$size = $this->writePathContent($expires, $hits);
				return $size !== false;
			}
		}

		// first hit
		$expires = time() + $this->seconds;
		$size = $this->writePathContent($expires, $count);
		return $size !== false;
	}

	/**
	 * Check how many hits the given region has remaining.
	 *
	 * @return int
	 */
	public function remaining()
	{
		if ( ! file_exists($this->path))
		{
			// this is the first hit
			return $this->hits;
		}
		$hits = $this->getPathContent('hits');

		return $this->hits - $hits;
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

	/**
	 * Gets the content of the current path and returns
	 * the data requested.
	 * 
	 * @param string $data
	 * @return int
	 */
	protected function getPathContent($data)
	{
		$info = file_get_contents($this->path);
		list($expires, $hits) = explode(',', $info);
		if ($expires < time())
		{
			// it has expires
			unlink($this->path);
			$hits    = 0;
			$expires = null;
		}
		if ($data == 'hits')
		{
			return $hits;
		}
		if ($data == 'expires')
		{
			return $expires;
		}
	}

	/**
	 * Writes the new expiry timestamp and count to the given
	 * path for this limit.
	 *
	 * @param int $expires
	 * @param int $count
	 * @return mixed
	 */
	protected function writePathContent($expires, $count)
	{
		$info = $expires.','.$count;
		return file_put_contents($this->path, $info);
	}
}
