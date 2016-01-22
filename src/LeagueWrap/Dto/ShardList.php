<?php


namespace LeagueWrap\Dto;


class ShardList extends AbstractListDto
{

	protected $listKey = '';

	/**
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		foreach($info as &$shard) {
			$shard = new Shard($shard);
		}
		parent::__construct($info);
	}

	/**
	 * Get a shard by its region.
	 *
	 * @param String $region
	 * @return Shard|null
	 */
	public function getShardByRegion($region)
	{
		foreach($this->info as $shard) {
			if($shard->slug == $region)
				return $shard;
		}
		return null;
	}


}