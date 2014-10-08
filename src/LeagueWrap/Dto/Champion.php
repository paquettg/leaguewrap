<?php
namespace LeagueWrap\Dto;

class Champion extends AbstractDto {
	use ImportStaticTrait;

	protected $staticFields = [
		'id' => 'champion',
	];
}
