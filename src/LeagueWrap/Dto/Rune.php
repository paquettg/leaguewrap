<?php
namespace LeagueWrap\Dto;

class Rune extends AbstractDto {
	use ImportStaticTrait;

	protected $staticFields = [
		'runeId' => 'rune',
	];
}

