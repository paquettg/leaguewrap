<?php


namespace LeagueWrap\Dto;


class ShardStatus extends AbstractDto
{

	public function __construct(array $info)
	{
		foreach($info['services'] as &$service) {
			$service = new Service($service);
		}
		parent::__construct($info);
	}

	/**
	 * @param $name
	 * @return null|Service
	 */
	public function getService($name) {
		foreach($this->services as $service) {
			if($service->name == $name)
				return $service;
		}
		return null;
	}

}