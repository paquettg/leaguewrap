<?php
namespace LeagueWrap\Dto;

class LeagueEntry extends AbstractDto {

	public function __construct($info)
	{
		if (isset($info['miniSeries']))
		{
			$miniSeries         = new MiniSeries($info['miniSeries']);
			$info['miniSeries'] = $miniSeries;
		}
		else
		{
			$info['miniSeries'] = false;
		}

		$this->info = $info;
	}
}
