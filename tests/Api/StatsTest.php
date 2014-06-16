<?php

use LeagueWrap\Api;
use Mockery as m;

class ApiStatsTest extends PHPUnit_Framework_TestCase {

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

	public function testSummary()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/stats/by-summoner/74602/summary', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));

		$api = new Api('key', $this->client);
		$stats = $api->stats()->summary(74602);
		$this->assertTrue($stats instanceof LeagueWrap\Dto\PlayerStatsSummaryList);
	}

	public function testSummaryArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/stats/by-summoner/74602/summary', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));

		$api = new Api('key', $this->client);
		$stats = $api->stats()->summary(74602);
		$this->assertTrue($stats[0] instanceof LeagueWrap\Dto\PlayerStatsSummary);
	}

	public function testSummarySummoner()
	{
		$this->client->shouldReceive('baseUrl')
		             ->twice();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/stats/by-summoner/74602/summary', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));
		$this->client->shouldReceive('request')
		             ->with('na/v1.4/summoner/by-name/bakasan', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/summoner.bakasan.json'));

		$api = new Api('key', $this->client);
		$bakasan = $api->summoner()->info('bakasan');
		$api->stats()->summary($bakasan);
		$this->assertTrue($bakasan->stats->playerStat(0) instanceof LeagueWrap\Dto\PlayerStatsSummary);
	}

	public function testRanked()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/stats/by-summoner/74602/ranked', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/stats.ranked.74602.season4.json'));

		$api   = new Api('key', $this->client);
		$stats = $api->stats()->ranked(74602);
		$this->assertTrue($stats->champion(0) instanceof LeagueWrap\Dto\ChampionStats);
	}

	public function testRankedArrayAccess()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/stats/by-summoner/74602/ranked', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/stats.ranked.74602.season4.json'));

		$api   = new Api('key', $this->client);
		$stats = $api->stats()->ranked(74602);
		$this->assertTrue($stats[0] instanceof LeagueWrap\Dto\ChampionStats);
	}
}

