<?php

class FacadeApiTest extends PHPUnit_Framework_TestCase {

	public function setUp()
	{
		LeagueWrap\StaticApi::mount();
	}

	public function testSetKey()
	{
		$api = Api::setKey('key');
		$this->assertTrue($api instanceof LeagueWrap\Api);
	}

	public function testChampion()
	{
		Api::setKey('key');
		$champion = Api::champion();
		$this->assertTrue($champion instanceof LeagueWrap\Api\Champion);
	}

	public function testSummoner()
	{
		Api::setKey('key');
		$summoner = Api::summoner();
		$this->assertTrue($summoner instanceof LeagueWrap\Api\Summoner);
	}

	public function testGame()
	{
		Api::setKey('key');
		$game = Api::game();
		$this->assertTrue($game instanceof LeagueWrap\Api\Game);
	}

	public function testLeague()
	{
		Api::setKey('key');
		$league = Api::league();
		$this->assertTrue($league instanceof LeagueWrap\Api\League);
	}

	public function testStats()
	{
		Api::setKey('key');
		$stats = Api::stats();
		$this->assertTrue($stats instanceof LeagueWrap\Api\Stats);
	}

	public function testTeam()
	{
		Api::setKey('key');
		$team = Api::team();
		$this->assertTrue($team instanceof LeagueWrap\Api\Team);
	}
}
