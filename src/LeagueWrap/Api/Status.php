<?php
namespace LeagueWrap\Api;

use LeagueWrap\Dto\ShardList;
use LeagueWrap\Dto\ShardStatus;

class Status extends AbstractApi
{

	/**
	 * Valid version for this api call.
	 *
	 * @var array
	 */
	protected $versions = [];

	/**
	 * A list of all permitted regions for the Champion api call.
	 *
	 * @param array
	 */
	protected $permittedRegions = [
		'br',
		'eune',
		'euw',
		'lan',
		'las',
		'na',
		'oce',
		'kr',
		'ru',
		'tr',
	];

	/**
	 * The amount of time we intend to remember the response for.
	 *
	 * @var int
	 */
	protected $defaultRemember = 1800;

	/**
	 * @return String domain used for the request
	 */
	function getDomain()
	{
		return $this->getRegion()->getStatusDomain();
	}

	public function shards()
	{
		$response = $this->request('shards', [], true, false);
		return new ShardList($response);

	}

	public function shardStatus($region = null)
	{
		if (!isset($region))
			$region = $this->getRegion()->getRegion();
		$response = $this->request('shards/' . $region, [], true, false);
		return new ShardStatus($response);
	}
}