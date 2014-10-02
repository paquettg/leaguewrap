<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiTest extends PHPUnit_Framework_TestCase {

	public function testChampion()
	{
		$api      = new Api('key');
		$champion = $api->champion();
		$this->assertTrue($champion instanceof LeagueWrap\Api\Champion);
	}

	public function testSummoner()
	{
		$api      = new Api('key');
		$summoner = $api->summoner();
		$this->assertTrue($summoner instanceof LeagueWrap\Api\Summoner);
	}

	public function testGame()
	{
		$api  = new Api('key');
		$game = $api->game();
		$this->assertTrue($game instanceof LeagueWrap\Api\Game);
	}

	public function testLeague()
	{
		$api    = new Api('key');
		$league = $api->league();
		$this->assertTrue($league instanceof LeagueWrap\Api\League);
	}

	public function testStats()
	{
		$api   = new Api('key');
		$stats = $api->stats();
		$this->assertTrue($stats instanceof LeagueWrap\Api\Stats);
	}

	public function testTeam()
	{
		$api  = new Api('key');
		$team = $api->team();
		$this->assertTrue($team instanceof LeagueWrap\Api\Team);
	}

	public function testStaticData()
	{
		$api        = new Api('key');
		$staticData = $api->staticData();
		$this->assertTrue($staticData instanceof LeagueWrap\Api\Staticdata);
	}

    public function testMatchHistory()
    {
        $api = new Api('key');
        $matchhistory = $api->matchHistory();
        $this->assertTrue($matchhistory instanceof LeagueWrap\Api\MatchHistory);
    }

    public function testMatch()
    {
        $api = new Api('key');
        $match = $api->match();
        $this->assertTrue($match instanceof LeagueWrap\Api\Match);
    }

	/**
	 * @expectedException LeagueWrap\Exception\NoKeyException
	 */
	public function testNoKeyException()
	{
		$api = new Api;
	}

	/**
	 * @expectedException LeagueWrap\Exception\ApiClassNotFoundException
	 */
	public function testApiClassNotFoundException()
	{
		$api  = new Api('key');
		$nope = $api->nope();
	}

	public function testGetLimits()
	{
		$api = new Api('key');
		$api->limit(5,5);
		$this->assertEquals(10, sizeof($api->getLimits()));
	}

	public function testGetLimitsOneRegion()
	{
		$api = new Api('key');
		$api->limit(5,5, 'na');
		$this->assertEquals(1, sizeof($api->getLimits()));
	}
}

