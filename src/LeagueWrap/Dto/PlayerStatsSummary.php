<?php
namespace LeagueWrap\Dto;

class PlayerStatsSummary extends AbstractDto {

	/**
	 * @param array $info
	 */
	public function __construct(array $info)
	{
		$aggregatedStats         = $info['aggregatedStats'];
		$info['aggregatedStats'] = new AggregateStats($aggregatedStats);

		parent::__construct($info);
	}
}
