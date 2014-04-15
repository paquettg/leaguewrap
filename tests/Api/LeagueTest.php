<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiLeagueTest extends PHPUnit_Framework_TestCase {

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

	public function testLeague()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.3/league/by-summoner/272354', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/league.272354.json'));

		$api = new Api('key', $this->client);
		$leagues = $api->league()->league(272354);
		$this->assertTrue($leagues['GamerXz'] instanceof LeagueWrap\Response\League);
	}

	public function testLeagueSummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.3/league/by-summoner/272354', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/league.272354.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/GamerXz', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.gamerxz.json'));

		$api = new Api('key', $this->client);
		$gamerxz = $api->summoner()->info('GamerXz');
		$api->league()->league($gamerxz);
		$this->assertTrue($gamerxz->league('GamerXz') instanceof LeagueWrap\Response\League);
	}

	public function testLeagueSummonerEntry()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.3/league/by-summoner/272354', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/league.272354.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/GamerXz', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.gamerxz.json'));

		$api = new Api('key', $this->client);
		$gamerxz = $api->summoner()->info('GamerXz');
		$api->league()->league($gamerxz);
		$first = $gamerxz->league('GamerXz')->entry('19112668');
		$this->assertEquals('Lapakaa', $first->playerOrTeamName);
	}

	public function testLeagueSummonerPlayerOrTeam()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v2.3/league/by-summoner/272354', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/league.272354.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/GamerXz', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.gamerxz.json'));

		$api = new Api('key', $this->client);
		$gamerxz = $api->summoner()->info('GamerXz');
		$api->league()->league($gamerxz);
		$myTeam = $gamerxz->league('gamerxz')->entry('FIareon');
		$this->assertEquals(2, $myTeam->miniSeries->target);
	}
}
