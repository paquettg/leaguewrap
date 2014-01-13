<?php
namespace LeagueWrap\Api;

use LeagueWrap\Response\Summoner;

abstract class Api {
	
	/**
	 * The client used to communicate with the api
	 *
	 * @var object
	 */
	protected $client;

	/**
	 * The key to be used by the api.
	 *
	 * @param string
	 */
	protected $key;

	/**
	 * The region to be used by the api.
	 *
	 * @param string
	 */
	protected $region;

	/**
	 * A list of all permitted regions for this API call. Leave
	 * it empty to not lock out any region string.
	 *
	 * @param array
	 */
	protected $permittedRegions = [];

	/**
	 * The version we want to use. If null use the first
	 * version in the array.
	 *
	 * @param string|null
	 */
	protected $version = null;

	/**
	 * A count of the amount of API request this object has done
	 * so far.
	 *
	 * @param int
	 */
	protected $requests = 0;

	/**
	 * Returns the amount of requests this object has done
	 * to the api so far.
	 *
	 * @return int
	 */
	public function getRequestCount()
	{
		return $this->requests;
	}

	/**
	 * Set the key to be used in the api.
	 *
	 * @param string $key
	 * @chainable
	 */
	public function setKey($key)
	{
		$this->key = $key;
		return $this;
	}

	/**
	 * Set the region to be used in the api.
	 *
	 * @param string $region
	 * @chainable
	 */
	public function setRegion($region)
	{
		$this->region = strtolower($region);
		return $this;
	}

	/**
	 * Select the version of the api you wish to
	 * query.
	 *
	 * @param string $version
	 * @return bool|$this
	 * @chainable
	 */
	public function selectVersion($version)
	{
		if ( ! in_array($version, $this->versions))
		{
			// not a value version
			return false;
		}

		$this->version = $version;
		return $this;
	}

	/**
	 * Wraps the request of the api in this method.
	 *
	 * @param string $path
	 * @param array $params
	 * @return array
	 * @throws RegionException
	 */
	protected function Request($path, $params = [])
	{
		// get version
		$version = $this->getVersion();

		// get and validate the region
		$region = $this->region;
		if ($this->regionLocked($region))
		{
			throw new RegionException('The region "'.$region.'" is not permited to query this API.');
		}

		// add the key to the param list
		$params['api_key'] = $this->key;

		$uri     = $region.'/'.$version.'/'.$path;
		$content = $this->client->request($uri, $params);

		// request was succesful
		++$this->requests;

		// decode the content
		return json_decode($content, true);
	}

	/**
	 * Get the version string.
	 *
	 * @return string
	 */
	protected function getVersion()
	{
		if (is_null($this->version))
		{
			// get the first version in versions
			$this->version = reset($this->versions);
		}
		
		return $this->version;
	}

	/**
	 * Determine if the given region is locked from doing
	 * requests to this api.
	 * 
	 * @param string $region
	 * @return bool
	 */
	protected function regionLocked($region)
	{
		if (count($this->permittedRegions) == 0)
		{
			// no regions are locked from this call.
			return true;
		}

		return ! in_array($region, $this->permittedRegions);
	}

	/**
	 * Attempts to extract an ID from the object/value given
	 *
	 * @param mixed $identity
	 * @return int
	 * @throws Exception
	 */
	protected function extractId($identity)
	{
		if ($identity instanceof Summoner)
		{
			return $identity->id;
		}
		elseif (is_int($identity))
		{
			return $identity;
		}
		else
		{
			throw new Exception('The identity given was not valid.');
		}
	}

	/**
	 * Attempts to attach the response to a summoner object.
	 *
	 * @param mixed $identity
	 * @param mixed $response
	 * @param string $key
	 * @return bool
	 */
	protected function attachResponse($identity, $response, $key)
	{
		if ($identity instanceof Summoner)
		{
			$identity->set($key, $response);
			return true;
		}
		
		return false;
	}
}
