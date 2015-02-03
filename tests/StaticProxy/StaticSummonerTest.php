<?php

use Mockery as m;

class StaticProxyStaticSummonerTest extends PHPUnit_Framework_TestCase {

	protected $client;

	public function setUp()
	{
		$this->client = m::mock('LeagueWrap\Client');
		LeagueWrap\StaticApi::mount();
	}

	public function tearDown()
	{
		m::close();
	}

	public function testInfo()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		Api::setKey('key', $this->client);
		$bakasan = Summoner::info('bakasan');
		$this->assertEquals(74602, $bakasan->id);
	}

	public function testInfoMixed()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/7024,97235', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.7024,97235.json'));

		Api::setKey('key', $this->client);
		$summoners = Summoner::info([
			'bakasan',
			7024,
			97235,
		]);
		$this->assertTrue(isset($summoners['IS1c2d27157a9df3f5aef47']));
	}

	public function testName()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/74602/name', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.name.74602.json'));

		Api::setKey('key', $this->client);
		$names = Summoner::name(74602);
		$this->assertEquals('bakasan', $names[74602]);
	}

	public function testMasteriesSummonerArray()
	{
		$this->client->shouldReceive('baseUrl')
		             ->times(2);
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/97235,7024/masteries', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.masteries.7024,97235.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/7024,97235', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.7024,97235.json'));

		Api::setKey('key', $this->client);
		$summoners = Summoner::info([
			7024,
			97235,
		]);
		Summoner::masteryPages($summoners);
		$this->assertEquals(0, count($summoners['IS1c2d27157a9df3f5aef47']->masteryPages));
	}
}
