<?php
namespace LeagueWrap;

use LeagueWrap\Api\Staticdata;

class StaticOptimizer {

	/**
	 * Holds all the raw field data to be used to get the correct
	 * data from any given hash.
	 *
	 * @param array
	 */
	protected $fields;

	/**
	 * Stores the groups of requests that are grouped by static
	 * source.
	 *
	 * @param array
	 */
	protected $requests;

	/**
	 * Keep the results from the requests in $requests.
	 *
	 * @param array
	 */
	protected $results;

	/**
	 * Takes all the fields and optimizes them in the $requests
	 * array.
	 *
	 * @param array $fields
	 * @chainable
	 */
	public function optimizeFields(array $fields)
	{
		$this->fields = $fields;
		foreach ($this->fields as $field)
		{
			foreach ($field as $source => $ids)
			{
				if ( ! isset($this->requests[$source]))
				{
					$this->requests[$source] = [];
				}
				foreach ($ids as $id)
				{
					$this->requests[$source][] = $id;
				}
				$this->requests[$source] = array_unique($this->requests[$source]);
			}
		}
		return $this;
	}

	/**
	 * Uses the static api to get all the static information we need
	 * that have already been optimized.
	 *
	 * @param Staticdata $staticData
	 * @return void
	 */
	public function setStaticInfo(Staticdata $staticData)
	{
		$results = [];
		foreach ($this->requests as $source => $ids)
		{
			$result = [];
			$method = 'get'.ucfirst($source);
			if (count($ids) > 1)
			{
				// group up the calls
				$method .= 's';
				$data    = $staticData->$method();
				foreach ($ids as $id)
				{
					$result[$id] = $data[$id];
				}
			}
			else
			{
				$id   = reset($ids);
				$data = $staticData->$method($id);
				$result[$id] = $data;
			}
			$results[$source] = $result;
		}
		$this->results = $results;
	}

	/**
	 * Gets the result data array from the static api by
	 * the given hash.
	 *
	 * @param string $hash
	 * @return array
	 */
	public function getDataFromHash($hash)
	{
		$data   = [];
		$fields = $this->fields[$hash];
		foreach ($fields as $source => $ids)
		{
			$result  = [];
			$results = $this->results[$source];
			foreach ($ids as $id)
			{
				$result[$id] = $results[$id];
			}
			$data[$source] = $result;
		}
		return $data;
	}
}
