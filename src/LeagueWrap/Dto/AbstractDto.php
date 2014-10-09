<?php
namespace LeagueWrap\Dto;

use LeagueWrap\Api\Staticdata;

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
	 * Attempts to load all static data within the children DTO
	 * objects.
	 *
	 * @param Statcidata $staticData
	 * @chainable
	 */
	public function loadStaticData(Staticdata $staticData)
	{
		$fields = $this->getStaticFields();
		$data   = $this->getStaticData($fields, $staticData);
		$this->addStaticData($data);

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
	 * Gets all static fields that we expect to need to get all static data
	 * for any child dto object.
	 *
	 * @return array
	 */
	protected function getStaticFields()
	{
		$fields = [];
		foreach ($this->info as $info)
		{
			if (is_array($info))
			{
				foreach ($info as $value)
				{
					if ($value instanceof AbstractDto)
					{
						$fields += $info->getStaticFields();
					}
				}
			}
			if ($info instanceof AbstractDto)
			{
				$fields += $info->getStaticFields();
			}
		}
		return $fields;
	}

	protected function getStaticData(array $fields, Staticdata $staticData)
	{
		$results = [];
		foreach ($fields as $hash => $requests)
		{
			$result = [];
			foreach ($requests as $request => $values)
			{
				$method = 'get'.ucfirst($request);
				foreach ($values as $value)
				{
					$data           = $staticData->$method($value);
					$result[$value] = $data;
				}
			}
			$results[$hash][$request] = $result;
		}
		return $results;
	}

	/**
	 * Attempts to add the static data that we got from getStaticData to
	 * any children DTO objects.
	 *
	 * @param array $data
	 * @return void
	 */
	protected function addStaticData(array $data)
	{
		foreach ($this->info as $info)
		{
			if (is_array($info))
			{
				foreach ($info as $value)
				{
					if ($value instanceof AbstractDto)
					{
						$info->addStaticData($data);
					}
				}
			}
			if ($info instanceof AbstractDto)
			{
				$info->addStaticData($data);
			}
		}
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
