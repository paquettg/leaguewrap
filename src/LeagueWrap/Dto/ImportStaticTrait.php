<?php
namespace LeagueWrap\Dto;

use LeagueWrap\Api\Staticdata;

trait ImportStaticTrait {

	/**
	 * Attempts to load all static data from this DTO object.
	 *
	 * @param Staticdata $staticData
	 * @chainable
	 */
	public function loadStaticData(Staticdata $staticData)
	{
		foreach ($this->staticFields as $key => $data)
		{
			$method = 'get'.ucfirst($data);
			$info   = $staticData->$method($this->info[$key]);

			$this->info[$data.'StaticData'] = $info;
		}

		return parent::loadStaticData($staticData);
	}
}
