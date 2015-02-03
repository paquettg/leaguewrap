<?php

use LeagueWrap\Api;
use Mockery as m;

class StaticMasteryTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$client       = m::mock('LeagueWrap\Client');
		$this->client = $client;
	}

	public function tearDown()
	{
		m::close();
	}

	public function testGetMasteryDefault()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/mastery', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.json'));

		$api       = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries();
		$mastery   = $masteries->getMastery(4231);
		$this->assertEquals('Oppression', $mastery->name);
	}

	public function testArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/mastery', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.json'));

		$api       = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries();
		$this->assertEquals('Oppression', $masteries[4231]->name);
	}

	public function testGetMasteryRegionKR()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/mastery', [
						'api_key' => 'key',
						'locale'  => 'ko_KR',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.kr.json'));

		$api       = new Api('key', $this->client);
		$masteries = $api->staticData()->setLocale('ko_KR')
		                               ->getMasteries();
		$mastery   = $masteries->getMastery(4111);
		$this->assertEquals('양날의 검', $mastery->name);
	}

	public function testGetMasteryById()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/mastery/4111', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.4111.json'));

		$api     = new Api('key', $this->client);
		$mastery = $api->staticData()->getMastery(4111);
		$this->assertEquals('Double-Edged Sword', $mastery->name);
	}

	public function testGetMasteryRank()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/mastery/4322', [
						'api_key'     => 'key',
						'masteryData' => 'ranks',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.4322.ranks.json'));

		$api     = new Api('key', $this->client);
		$mastery = $api->staticData()->getMastery(4322, 'ranks');
		$this->assertEquals(3, $mastery->ranks);
	}

	public function testGetMasteryAll()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.2/mastery', [
						'api_key'         => 'key',
						'masteryListData' => 'all',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/Static/mastery.all.json'));

		$api       = new Api('key', $this->client);
		$masteries = $api->staticData()->getMasteries('all');
		$mastery   = $masteries->getMastery(4322);
		$this->assertEquals('Reduces the cooldown of Summoner Spells by 10%', $mastery->description[2]);
	}
}
