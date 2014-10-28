<?php

use Mockery as m;

class StaticProxyStaticStatsTest extends PHPUnit_Framework_TestCase {

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

	public function testSummary()
	{
		$this->client->shouldReceive('baseUrl')
		             ->once();
		$this->client->shouldReceive('request')
		             ->with('na/v1.3/stats/by-summoner/74602/summary', [
						'api_key' => 'key',
		             ])->once()
		             ->andReturn(file_get_contents('tests/Json/stats.summary.74602.season4.json'));

		Api::setKey('key', $this->client);
		$stats = Stats::summary(74602);
		$this->assertTrue($stats instanceof LeagueWrap\Dto\PlayerStatsSummaryList);
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

		Api::setKey('key', $this->client);
		$stats = Stats::ranked(74602);
		$this->assertTrue($stats->champion(0) instanceof LeagueWrap\Dto\ChampionStats);
	}
}


