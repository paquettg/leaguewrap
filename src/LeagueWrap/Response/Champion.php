<?php
namespace LeagueWrap\Response;

class Champion {

	protected $info;

	/**
	 * Set up the information about this champion.
	 *
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		$this->info = $info;
	}

	/**
	 * Gets the attribute of this champion.
	 *
	 * @param string $key
	 * @return string|null
	 */
	public function __get($key)
	{
		if (isset($this->info[$key]))
		{
			return $this->info[$key];
		}
		return null;
	}

	/**
	 * Returns the raw info array
	 * 
	 * @return array
	 */
	public function raw()
	{
		return $this->info;
	}

}
