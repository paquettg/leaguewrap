<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$client = m::mock('LeagueWrap\Client');
		$this->client = $client;
	}

	public function testChampion()
	{
		$api = new Api('key');
		$champion = $api->champion();
		$this->assertTrue($champion instanceof LeagueWrap\Api\Champion);
	}

	public function testSummoner()
	{
		$api = new Api('key');
		$summoner = $api->summoner();
		$this->assertTrue($summoner instanceof LeagueWrap\Api\Summoner);
	}

	public function testGame()
	{
		$api = new Api('key');
		$game = $api->game();
		$this->assertTrue($game instanceof LeagueWrap\Api\Game);
	}

	public function testLeague()
	{
		$api = new Api('key');
		$league = $api->league();
		$this->assertTrue($league instanceof LeagueWrap\Api\League);
	}

	public function testStats()
	{
		$api = new Api('key');
		$stats = $api->stats();
		$this->assertTrue($stats instanceof LeagueWrap\Api\Stats);
	}

	public function testTeam()
	{
		$api = new Api('key');
		$team = $api->team();
		$this->assertTrue($team instanceof LeagueWrap\Api\Team);
	}
}

