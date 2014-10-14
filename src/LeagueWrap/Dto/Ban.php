<?php
namespace LeagueWrap\Dto;

/**
 * Class Ban
 * @package LeagueWrap\Dto
 * Represents a single ban of a match
 */
class Ban extends AbstractDto {
	use ImportStaticTrait;

	protected $staticFields = [
		'championId' => 'champion',
	];
}
