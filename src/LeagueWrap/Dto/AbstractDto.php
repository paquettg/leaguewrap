<?php
namespace LeagueWrap\Dto;

Abstract class AbstractDto {
	
	protected $info;

	/**
	 * Set up the information about this response.
	 *
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		$this->info = $info;
	}

	/**
	 * Gets the attribute of this Dto.
	 *
	 * @param string $key
	 * @return string|null
	 */
	public function __get($key)
	{
		return $this->get($key);
	}

	/**
	 * Sets a new attribute for this Dto.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public function __set($key, $value)
	{
		$this->set($key, $value);
	}

	/**
	 * Gets the attribute of this Dto.
	 *
	 * @param string $key
	 * @return string|null
	 */
	public function get($key)
	{
		if (isset($this->info[$key]))
		{
			return $this->info[$key];
		}
		return null;
	}

	/**
	 * Sets a new attribute for this Dto.
	 *
	 * @param string $key
	 * @param mixed $value
	 * @chainable
	 */
	public function set($key, $value)
	{
		$this->info[$key] = $value;
		return $this;
	}

	/**
	 * Returns the raw info array
	 * 
	 * @return array
	 * @recursive
	 */
	public function raw()
	{
		// unpack
		$raw = [];
		foreach($this->info as $key => $info)
		{
			if (is_array($info))
			{
				$info = $this->unpack($info);
			}
			// check if it's just a single object
			if ($info instanceof AbstractDto)
			{
				$info = $info->raw();
			}
			// set the raw value
			$raw[$key] = $info;
		}

		return $raw;
	}

	/**
	 * Unpacks an array that contains Dto objects.
	 *
	 * @return array
	 */
	protected function unpack(array $info)
	{
		$return = [];
		foreach ($info as $key => $value)
		{
			if ($value instanceof AbstractDto)
			{
				$value = $value->raw();
			}
			$return[$key] = $value;
		}

		return $return;
	}
}
