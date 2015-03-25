<?php

class DtoMatchHistoryTest extends PHPUnit_Framework_TestCase {

	public function testMatchNoResults()
	{
		$matchHistory = new LeagueWrap\Dto\MatchHistory([]);
		$this->assertEquals(null, $matchHistory->match(1));
	}

	public function testSetMatchOutOfController()
	{
		$matchHistory = new LeagueWrap\Dto\MatchHistory([]);
		$matchHistory['matches'] = [];
		$this->assertTrue(isset($matchHistory['matches']));
	}

	public function testUnsetMatchOutOfController()
	{
		$matchHistory = new LeagueWrap\Dto\MatchHistory([]);
		$matchHistory['matches'] = [];
		unset($matchHistory['matches']);
		$this->assertFalse(isset($matchHistory['matches']));
	}
}
