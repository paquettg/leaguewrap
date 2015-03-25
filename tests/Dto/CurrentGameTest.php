<?php

class DtoCurrentGameTest extends PHPUnit_Framework_TestCase {

	public function testBanNotFound()
	{
		$currentGame = new LeagueWrap\Dto\CurrentGame([]);
		$this->assertEquals(null, $currentGame->ban(1));
	}

	public function testCurrentGameNotFound()
	{
		$currentGame = new LeagueWrap\Dto\CurrentGame([]);
		$this->assertEquals(null, $currentGame->participant(1));
	}
}
