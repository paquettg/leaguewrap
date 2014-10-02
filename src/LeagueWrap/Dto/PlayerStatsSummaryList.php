<?php
namespace LeagueWrap\Dto;

class PlayerStatsSummaryList extends AbstractListDto {

	protected $listKey = 'playerStatSummaries';

	public function __construct(array $info)
	{
		if (isset($info['playerStatSummaries']))
		{
			$stats = [];
			foreach ($info['playerStatSummaries'] as $key => $playerStat)
			{
				$playerStats = new PlayerStatsSummary($playerStat);
				$stats[$key] = $playerStats;
			}
			$info['playerStatSummaries'] = $stats;
		}

		parent::__construct($info);
	}

	/**
	 * Get the playerstat but the id in the response.
	 *
	 * @param int $playerStatId
	 * @return PlayerStatsSummary|null
	 */
	public function playerStat($playerStatId)
	{
		if ( ! isset($this->info['playerStatSummaries'][$playerStatId]))
		{
			return null;
		}

		return $this->info['playerStatSummaries'][$playerStatId];
	}
}
